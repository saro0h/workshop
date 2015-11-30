<?php

namespace Smoovio\Bundle\CoreBundle\Tests\Unit\EventListener;

use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use Smoovio\Bundle\CoreBundle\EventListener\SendConfirmationMailListener;

class SendConfirmationMailListenerTest extends \PHPUnit_Framework_TestCase
{
    /** @var SendConfirmationMailListener */
    private $listener;

    /** @var ObjectProphecy|\Swift_Mailer */
    private $mailer;

    /** @var ObjectProphecy|\Twig_Environment */
    private $templating;

    /** @var Prophet */
    private $prophet;

    /** @var string */
    private $templateName;

    /** @var string */
    private $sender;

    protected function setUp()
    {
        $this->templateName = 'test.html.twig';
        $this->sender = 'test@example.com';
        $this->prophet = new Prophet();
        $this->mailer = $this->prophet->prophesize('\Swift_Mailer');
        $this->templating = $this->prophet->prophesize('\Twig_Environment');

        $this->listener = new SendConfirmationMailListener(
            $this->mailer->reveal(),
            $this->templating->reveal(),
            $this->templateName,
            $this->sender
        );
    }

    public function testOnNewAccountCreated()
    {
        $userName = 'tester';
        $userEmail = 'tester@example.com';
        $messageBody = 'Body';
        $messageSubject = 'Subject';

        $template = $this->prophet->prophesize('Twig_Template');
        $event = $this->prophet->prophesize('Smoovio\Bundle\CoreBundle\Event\NewAccountCreatedEvent');
        $user = $this->prophet->prophesize('Smoovio\Bundle\CoreBundle\Entity\User');

        $this->templating->loadTemplate($this->templateName)
            ->willReturn($template->reveal())
            ->shouldBeCalled();
        $template->renderBlock('subject', [])->willReturn('Subject');
        $event->getUser()->willReturn($user);
        $user->getUsername()->willReturn($userName);
        $user->getEmail()->willReturn($userEmail);
        $template->renderBlock('body', ['username' => $userName])
            ->willReturn($messageBody)
            ->shouldBeCalled();

        $this->mailer->send(
            Argument::that(
                function (\Swift_Message $message) use ($userEmail, $messageBody, $messageSubject) {
                    $this->assertSame($this->sender, $message->getSender());
                    $this->assertSame($userEmail, $message->getTo());
                    $this->assertSame($messageSubject, $message->getSubject());
                    $this->assertSame($messageBody, $message->getBody());
                }
            )
        );

        $this->listener->onNewAccountCreated($event->reveal());

        $this->prophet->checkPredictions();
    }
}
