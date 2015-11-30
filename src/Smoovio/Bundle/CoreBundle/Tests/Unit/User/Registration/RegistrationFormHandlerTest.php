<?php

namespace Smoovio\Bundle\CoreBundle\Tests\Unit\User\Registration;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Smoovio\Bundle\CoreBundle\Entity\User;
use Smoovio\Bundle\CoreBundle\User\Registration\RegistrationFormHandler;
use Smoovio\Bundle\CoreBundle\User\Registration\Registration;
use Smoovio\Bundle\CoreBundle\User\Manager\UserManagerInterface;

class RegistrationFormHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testHandle()
    {
        $manager = \Mockery::mock(UserManagerInterface::class);
        $handler = new RegistrationFormHandler($manager);

        $form = \Mockery::mock(FormInterface::class);
        $request = \Mockery::mock(Request::class);

        $user = \Mockery::mock(User::class);
        $registration = \Mockery::mock(Registration::class);
        $registration->shouldReceive('getUser')->times(1)->andReturn($user);

        $form->shouldReceive('handleRequest')->times(1);
        $form->shouldReceive('isValid')->times(1)->andReturn(true);
        $form->shouldReceive('getData')->times(1)->andReturn($registration);

        $manager->shouldReceive('createUser')->times(1)->with($user);

        $handler->handle($form, $request, []);
    }

    protected function tearDown()
    {
        \Mockery::close();
    }
}
