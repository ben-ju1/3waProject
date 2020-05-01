<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */

    public function homePage()
    {
        return $this->render('home/homepage.html.twig');
    }

    /**
     * @Route("/notre-église", name="about")
     */
    public function aboutPage()
    {
        return $this->render('home/about.html.twig');
    }

    /**
     * @Route("/rejoignez-nous", name="join-us")
     */
    public function howPage()
    {
        return $this->render('home/join-us.html.twig');
    }

    /**
     * @Route("/signaler", name="signal")
     */
    public function signalPage()
    {
        return $this->render('home/signal.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */

    public function contactPage()
    {
        return $this->render('home/contact.html.twig');
    }
}
