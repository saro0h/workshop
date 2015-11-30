<?php

namespace Smoovio\Bundle\CoreBundle\User\Registration;

use Symfony\Component\Validator\Constraints as Assert;
use Smoovio\Bundle\CoreBundle\Validator\Constraints as SmoovioAssert;
use Smoovio\Bundle\CoreBundle\Entity\User;

class Registration
{

    /**
     * @Assert\NotBlank()
     * @SmoovioAssert\UniqueAttribute(
     *      repository="Smoovio\Bundle\CoreBundle\Entity\User",
     *      property="username"
     * )
     */
    private $username;

    /**
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     * @SmoovioAssert\UniqueAttribute(
     *      repository="Smoovio\Bundle\CoreBundle\Entity\User",
     *      property="email"
     * )
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @Assert\True()
     */
    protected $termsAccepted;

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        $user = new User();
        $user->setUsername($this->username);
        $user->setRawPassword($this->password);
        $user->setEmail($this->email);

        return $user;
    }

    /**
     * @return bool
     */
    public function getTermsAccepted()
    {
        return $this->termsAccepted;
    }

    /**
     * @param bool $termsAccepted
     */
    public function setTermsAccepted($termsAccepted)
    {
        $this->termsAccepted = (bool) $termsAccepted;
    }
}
