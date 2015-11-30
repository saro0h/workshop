<?php

namespace Smoovio\Bundle\CoreBundle\User\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Smoovio\Bundle\CoreBundle\CoreEvents;
use Smoovio\Bundle\CoreBundle\Entity\UserInterface;
use Smoovio\Bundle\CoreBundle\Event\NewAccountCreatedEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class UserManager implements UserManagerInterface
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var EncoderFactoryInterface
     */
    protected $encoderFactory;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @param ObjectManager            $manager
     * @param EncoderFactoryInterface  $encoderFactory
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
        ObjectManager $manager,
        EncoderFactoryInterface $encoderFactory,
        EventDispatcherInterface $dispatcher
    ) {
        $this->objectManager = $manager;
        $this->encoderFactory = $encoderFactory;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param UserInterface $user
     *
     * @return UserInterface
     */
    public function createUser(UserInterface $user)
    {
        $user->encodePassword($this->encoderFactory->getEncoder($user));

        $this->storeUser($user);

        $this->dispatcher->dispatch(
            CoreEvents::NEW_ACCOUNT_CREATED,
            new NewAccountCreatedEvent($user)
        );
    }

    /**
     * @param UserInterface $user
     */
    protected function storeUser(UserInterface $user)
    {
        $this->objectManager->persist($user);
        $this->objectManager->flush();
    }
} 
