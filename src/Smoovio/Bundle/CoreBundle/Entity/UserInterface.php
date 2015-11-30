<?php

namespace Smoovio\Bundle\CoreBundle\Entity;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface as SecurityUserInterface;

interface UserInterface extends SecurityUserInterface
{
    public function encodePassword(PasswordEncoderInterface $encoder);
} 
