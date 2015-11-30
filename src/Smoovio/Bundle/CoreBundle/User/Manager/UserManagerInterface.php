<?php

namespace Smoovio\Bundle\CoreBundle\User\Manager;

use Smoovio\Bundle\CoreBundle\Entity\UserInterface;

interface UserManagerInterface
{
    /**
     * @param UserInterface $user
     *
     * @return void
     */
    public function createUser(UserInterface $user);
} 
