<?php

namespace App\BlogBundle\EventListener;

use App\BlogBundle\AppBlogBundleEvents;
use App\BlogBundle\Event\IncorrectLoginEvent;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Twig\Error\Error;

class IncorrectLoginListener implements EventSubscriberInterface
{
    private $logger;

    private $mailer;

    private $templating;

    public function __construct(
        $logger,
        \Swift_Mailer $mailer,
        EngineInterface $templating
    )
    {
        $this->logger = $logger;
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public static function getSubscribedEvents()
    {
        return [
            AppBlogBundleEvents::INCORRECT_LOGIN_EVENT => 'sendMailIncorrectLoginAttempts'
        ];
    }

    public function sendMailIncorrectLoginAttempts(IncorrectLoginEvent $event)
    {
        $incorrectAttempts = $event->getAttempts();

        $this->logger->info('Somebody has been trying login, attempts = ' . $incorrectAttempts);

        $body = $this->templating->render(
        // app/Resources/views/Emails/registration.html.twig
            'Emails/registration.html.twig', ['attempts' => $incorrectAttempts]
        );

        $message = (new \Swift_Message('Hello Admin'))
            ->setFrom('send@example.com')
            ->setTo('recipient@example.com')
            ->setBody($body, 'text/html');

        $sended = $this->mailer->send($message);
        $this->logger->info('Sent: ' . $sended);

    }
}