<?php

namespace App\Tests\Service;

use App\Service\Mailer;
use Symfony\Component\Mailer\MailerInterface as SymfonyMailerInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class MailerUnitTest extends TestCase
{
    public function testSendWithoutFrom()
    {
        $to = 'hola@mail.com';
        $subject = 'subject';
        $template = 'template.html.twig';
        $vars = ['foo' => 'bar'];
        $defaultEmailFrom = 'from@mail.com';

        /** @var SymfonyMailerInterface&MockObject */
        $symfonyMailer = $this->getMockBuilder(SymfonyMailerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $symfonyMailer
            ->expects(self::exactly(2))
            ->method('send')
            ->with($this->callback(
                fn (TemplatedEmail $templatedEmail) =>
                \count($templatedEmail->getFrom()) === 1 &&
                    $templatedEmail->getFrom()[0]->getAddress() === $defaultEmailFrom &&
                    $templatedEmail->getHtmlTemplate() === $template &&
                    $templatedEmail->getContext()['foo'] === 'bar' &&
                    $templatedEmail->getSubject() === $subject &&
                    \count($templatedEmail->getTo()) === 1 &&
                    $templatedEmail->getTo()[0]->getAddress() === $to
            ));

        $mailer = new Mailer($symfonyMailer, $defaultEmailFrom);

        $mailer->send(
            $to,
            $subject,
            $template,
            $vars
        );
    }

    public function testSendWithFrom()
    {
        $to = 'hola@mail.com';
        $subject = 'subject';
        $template = 'template.html.twig';
        $vars = ['foo' => 'bar'];
        $defaultEmailFrom = 'default@mail.com';
        $from = 'from@mail.com';

        /** @var SymfonyMailerInterface&MockObject */
        $symfonyMailer = $this->getMockBuilder(SymfonyMailerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $symfonyMailer
            ->expects(self::exactly(1))
            ->method('send')
            ->with($this->callback(
                fn (TemplatedEmail $templatedEmail) =>
                \count($templatedEmail->getFrom()) === 1 &&
                    $templatedEmail->getFrom()[0]->getAddress() === $from &&
                    $templatedEmail->getHtmlTemplate() === $template &&
                    $templatedEmail->getContext()['foo'] === 'bar' &&
                    $templatedEmail->getSubject() === $subject &&
                    \count($templatedEmail->getTo()) === 1 &&
                    $templatedEmail->getTo()[0]->getAddress() === $to
            ));

        $mailer = new Mailer($symfonyMailer, $defaultEmailFrom);

        $mailer->send(
            $to,
            $subject,
            $template,
            $vars,
            $from
        );
    }
}
