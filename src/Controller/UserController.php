<?php

namespace App\Controller;

use App\Form\AccountSettingsType;
use App\Form\PersonnalSettingsType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/utilisateur/profile/", name="user_profile")
     */

    // Affiche la première vue du profil utilisateur

    public function userProfile()
    {

        $user = $this->getUser();
        $this->denyAccessUnlessGranted('ROLE_USER');

        if ($user) {
            $form = $this->createForm(UserType::class, $user);

            return $this->render('user/profile.html.twig', [
                'user' => $user,
                'username' => $user->getUsername(),
                'form' => $form->createView(),
            ]);
        }
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/json/profile", name="json_profile")
     */

    // Renvoie utilisateur courant au format JSON

    public function profileSettings()
    {
        $user = $this->getUser();

        // Formulaire d'informations concernant le compte

        $formAccountSettings = $this->createForm(AccountSettingsType::class, $user, [
            'userEmail' => $user->getEmail(),
            'userUsername' => $user->getUsername(),
        ]);

        // Formulaire d'informations personnel

        $formPersonnalSettings = $this->createForm(PersonnalSettingsType::class, $user, [
            'userFirstname' => $user->getFirstname(),
            'userLastname' => $user->getLastname(),
        ]);

        // Retour en format JSON des 3 requêtes sous tableau
        return $this->json(
            [
                'formAccountSettingsView' =>
                    $this->render('user/_accountSettings.html.twig', [
                        'form' => $formAccountSettings->createView(),
                    ]),
                'formPersonnalSettingsView' => $this->render('user/_accountSettings.html.twig', [
                    'form' => $formPersonnalSettings->createView(),
                ]),
            ]
        );
    }

    /**
     * @Route("/utilisateur/edit-personnal-settings", name="edit_personnal_settings")
     */

    // Gestion de l'edition des informations personnels utilisateur (firstname/lastname...)

    public function editPersonnalSettings(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $formPersonnalSettings = $this->createForm(PersonnalSettingsType::class, $user);
        $formPersonnalSettings->handleRequest($request);
        if (!$formPersonnalSettings->isValid()) {
            return $this->json([
                'message' => 'error',
                'personnalSettings' => $this->render('user/_accountSettings.html.twig', [
                    'form' => $formPersonnalSettings->createView(),
                ])
            ], 200);
        }
        $user->setFirstname(\ucfirst($request->request->get('personnal_settings')['firstname']));
        $user->setLastname(\mb_strtoupper($request->request->get('personnal_settings')['lastname']));
        $em->persist($user);
        $em->flush();
        $this->addFlash('personnal_success', 'Vos informations personnels ont bien été enregistrées !');
        return $this->json([
            'message' => 'success',
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/utilisateur/edit-account-settings", name="edit_account_settings")
     */

    // Gestion de l'edition des informations utilisateur (pwd/email...)

    public function editAccountSettings(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $formAccountSettings = $this->createForm(AccountSettingsType::class, $user);
        $formAccountSettings->handleRequest($request);

        if (!$formAccountSettings->isValid()) {
            return $this->json([
                'message' => 'error',
                'accountSettings' => $this->render('user/_accountSettings.html.twig', [
                    'form' => $formAccountSettings->createView(),
                ])
            ], 200);
        }
        if (!$encoder->isPasswordValid($user, $request->request->get('account_settings')['actualPassword'])) {
            return $this->json([
                'message' => 'invalid_password',
            ]);
        }
            $user->setEmail($request->request->get('account_settings')['email']);
            $user->setUsername($request->request->get('account_settings')['username']);
            $user->setPassword($encoder->encodePassword($user, $request->request->get('account_settings')['newPassword']));
            $em->persist($user);
            $em->flush();
            $this->addFlash('personnal_success', 'Vos informations personnels ont bien été enregistrées !');
            return $this->json([
                'message' => 'success',
            ]);
    }
}
