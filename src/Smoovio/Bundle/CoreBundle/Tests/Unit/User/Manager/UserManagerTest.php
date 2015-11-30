<?php

namespace Smoovio\Bundle\CoreBundle\Tests\Unit\User\Manager;

use Prophecy\Argument;
use Prophecy\Prophet;
use Smoovio\Bundle\CoreBundle\CoreEvents;
use Smoovio\Bundle\CoreBundle\Event\NewAccountCreatedEvent;
use Smoovio\Bundle\CoreBundle\User\Manager\UserManager;

class UserManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testManagerCreatesUserSuccessful()
    {
        $userhash = null;

        $user = $this->getMockBuilder('Smoovio\Bundle\CoreBundle\Entity\User')
            ->getMock();

        $encoder = $this->getMock('Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface');

        $encoderFactory = $this->getMockForAbstractClass('Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface');
        $encoderFactory->expects($this->once())
            ->method('getEncoder')
            ->with($user)
            ->will($this->returnValue($encoder));

        $user->expects($this->once())
            ->method('encodePassword')
            ->with($encoder);

        $providerMock = $this->getMock('Doctrine\Common\Persistence\ObjectManager');

        $providerMock->expects($this->once())
            ->method('persist')
            ->with($user);
        $providerMock->expects($this->once())
            ->method('flush');

        $eventDispatcherMock = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');

        $userManager = new UserManager($providerMock, $encoderFactory, $eventDispatcherMock);
        $userManager->createUser($user);
    }

    public function testManagerCreatesUserSuccessfulWithProphecy()
    {
        $prophet = new Prophet();
        $manager = $prophet->prophesize('Doctrine\Common\Persistence\ObjectManager');
        $encoderFactory = $prophet->prophesize('Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface');
        $encoder = $prophet->prophesize('Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface');
        $dispatcher = $prophet->prophesize('Symfony\Component\Eventdispatcher\EventDispatcherInterface');
        $user = $prophet->prophesize('Smoovio\Bundle\CoreBundle\Entity\User');

        $encoderFactory->getEncoder($user->reveal())->willReturn($encoder)->shouldBeCalled();
        $user->encodePassword($encoder->reveal())->shouldBeCalled();
        $manager->persist($user)->shouldBeCalled();
        $manager->flush()->shouldBeCalled();
        $dispatcher->dispatch(
            CoreEvents::NEW_ACCOUNT_CREATED,
            Argument::that(
                function ($event) use ($user) {
                    return $event instanceof NewAccountCreatedEvent
                        && $event->getUser() === $user;
                }
            )
        );

        $userManager = new UserManager($manager->reveal(), $encoderFactory->reveal(), $dispatcher->reveal());
        $userManager->createUser($user->reveal());


        $prophet->checkPredictions();
    }
} 
