<?php

namespace App\Controller;

use App\Entity\Token;
use App\Form\UserType;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use function mb_strtolower;
use function mb_strtoupper;
use function ucfirst;

class SecurityController extends AbstractController
{
    private $mailer;

    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param TokenGeneratorInterface $tokenGenerator
     * @return RedirectResponse|Response
     * @Route("/inscription", name="security_registration")
     */

    // Inscription d'un nouvel utilisateur

    public function registration(Request $request, UserPasswordEncoderInterface $encoder, TokenGeneratorInterface $tokenGenerator)
    {
        $user = new User();
        $manager = $this->getDoctrine()->getManager();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $token = new Token();
            $token->setUser($user);
            $token->setToken($tokenGenerator->generateToken());
            $token->setCreatedAt(new \DateTime());
            $manager->persist($token);

            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setFirstname(ucfirst(mb_strtolower($request->request->get('user')['firstname'])));
            $user->setLastname(mb_strtoupper($request->request->get('user')['lastname']));
            $user->setRoles($user->getRoles());
            $user->setPassword($hash);
            $user->addToken($token);
            $manager->persist($user);
            if ($this->sendingMail($user)) {
                $this->addFlash('success', 'Veuillez valider le lien envoyé sur votre adresse email');
            } else {
                $this->addFlash('error', 'Une erreur s\'est produite');
            }
            $manager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('security/registration.html.twig',
            [
                'form' => $form->createView(),
            ]);
    }

    /**
     * @Route("/connexion", name="security_login")
     * @param AuthenticationUtils $utils
     * @return Response
     */

    // Connexion d'un utilisateur

    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $lastUsername = $utils->getLastUsername();

        $this->addFlash('user_login', "Bienvenue sur le site de l'église Le Rameau");

        return $this->render('security/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername,
        ]);
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout()
    {
    }

    /**
     * @Route("/{token}", name="mail_verification")
     * @param string $token
     * @return Response
     */
    public function tokenValidation(string $token)
    {
        $em = $this->getDoctrine()->getManager();
        $repositoryToken = $this->getDoctrine()->getRepository(Token::class);
        $repositoryUser = $this->getDoctrine()->getRepository(User::class);
        // On cherche l'entité correspondant au token
        $arrayTokenValues = $repositoryToken->findTokenByString($token);
        if ($arrayTokenValues === []) {
            $this->addFlash('error', 'Le lien n\'est plus valide');
            return $this->redirectToRoute('home');
        }
        $tokenEntity = $repositoryToken->findBy(['id' => $arrayTokenValues[0]['id']])[0];
        if ($tokenEntity !== []) {
            $userRelatedToToken = $repositoryUser->findBy(['id' => $arrayTokenValues[0]['user_id']])[0];
            // Date actuelle qui s'incremente
            $now = new \DateTime();
            $now = strtotime($now->format("Y-m-d H:i:s"));

            $tokenCreatedAt = $tokenEntity->getCreatedAt();

            // Ajout de 24 heures pour la date d'expiration du token
            $tokenExpiration = $tokenCreatedAt->add(new \DateInterval('P1D'))->format('Y-m-d H:i:s');
            // Transformation en int afin de pouvoir vérifier en comparant
            $tokenExpiration = strtotime($tokenExpiration);
            if ($now < $tokenExpiration) {
                if ($userRelatedToToken !== null) {
                    $userRelatedToToken->setIsConfirmed(true);
                    $em->persist($userRelatedToToken);
                    $em->remove($tokenEntity);
                    $em->flush();
                    $this->addFlash('success', 'Votre compte a bien été crée !');
                    return $this->redirectToRoute('home');
                }
            }
        }
        return new Response('Le lien de confirmation a expiré');
    }

    public function sendingMail(User $user)
    {
        if ($user !== null) {
            $mail = new \Swift_Message('Eglise Le Rameau');
            $mail->setFrom('egliselerameau@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView('mail/registration-mailing.html.twig', [
                        'user' => $user->getFirstname() . ' ' . $user->getLastname(),
                        'token' => $user->getTokens()[0]->getToken(),
                    ]), 'text/html'
                );
            $this->mailer->send($mail);
            return true;
        }
        return false;
    }

    /**
     * @Route("testo")
     */
    public function testo()
    {
        $transport = new \Swift_SmtpTransport('smtp.gmail.com', 465);
        $mailer = new Swift_Mailer($transport);
    }
}
