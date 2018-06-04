<?php

namespace App\BlogBundle\EventListener;

use App\BlogBundle\AppBlogBundleEvents;
use App\BlogBundle\Event\IncorrectLoginEvent;
use Swift_Mailer;
use Swift_Message;
use Swift_RfcComplianceException;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class IncorrectLoginListener implements EventSubscriberInterface
{
    private $logger;

    private $mailer;

    private $templating;

    public function __construct(
        $logger,
        Swift_Mailer $mailer,
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
            'Emails/registration.html.twig', ['attempts' => $incorrectAttempts]
        );

        $message = (new \Swift_Message('Hello Admin'))
            ->setFrom('send@example.com')
            ->setTo('recipient@example.com')
            ->setBody($body, 'text/html');

        $failedRecipients = [];

        try {
            $this->mailer->send($message, $failedRecipients);
        } catch (Swift_RfcComplianceException $e) {
            $this->logger->critical(
                sprintf(
                    'Failed to send email to recipients [%s] with message: %s',
                    implode(', ', $failedRecipients),
                    $e->getMessage()
                )
            );
        }
    }
}