<?php

namespace App\Services;

use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Validator\Exception\ValidatorException;
use Twig\Environment;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MailerService
{
    public function __construct(
        private MailerInterface $mailer,private \Twig\Environment $twig)
    {
    }

    public function send(string $subject, string $from, string $to, string $template,array $parameters): void
    {
        $email = (new Email())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->html($this->twig->render($template,$parameters),
                'text/html'
            );
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $exception) {
            throw new ValidatorException($exception->getMessage());
        }
    }
}