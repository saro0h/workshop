<?php

namespace Smoovio\Bundle\CoreBundle\Tests\Integration\Validator;

use Smoovio\Bundle\CoreBundle\User\Registration\Registration;
use Smoovio\Bundle\CoreBundle\Validator\Constraints\UniqueAttributeValidator;
use Symfony\Bundle\FrameworkBundle\Validator\ConstraintValidatorFactory;
use Symfony\Component\Validator\Validation;

class UniqueAttributeValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testValidatorHasViolationsIfInputDataIsIncorrect()
    {

        // user
        $registration = new Registration();
        $registration->setEmail('test@email.de');
        $registration->setUsername('testuser');
        $registration->setPassword('hash');
        $registration->setTermsAccepted(true);

        // em
        $repo = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->setMethods(['findBy'])
            ->getMock();
        $repo->expects($this->exactly(2))
            ->method('findBy')
            ->withConsecutive(
                [['username' => 'testuser']],
                [['email' => 'test@email.de']]
            )
            ->will($this->returnValue(['someuserobject']));

        $emMock = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->setMethods(['getRepository'])
            ->getMock();
        $emMock->expects($this->exactly(2))
            ->method('getRepository')
            ->will($this->returnValue($repo));

        // validator
        $constraintValidators = [
            'validator_unique_attribute' => new UniqueAttributeValidator($emMock)
        ];

        $containerMock = $this->getMockForAbstractClass('Symfony\Component\DependencyInjection\ContainerInterface');

        $validatorFactory = new ConstraintValidatorFactory($containerMock, $constraintValidators);

        $validatorBuilder = Validation::createValidatorBuilder();
        $validatorBuilder->enableAnnotationMapping();
        $validatorBuilder->setConstraintValidatorFactory($validatorFactory);

        $validator = $validatorBuilder->getValidator();

        $this->assertCount(2, $validator->validate($registration));
    }

    public function testValidatorHasNoViolationsIfInputDataIsCorrect()
    {

        // user
        $registration = new Registration();
        $registration->setEmail('test@email.de');
        $registration->setUsername('testuser');
        $registration->setPassword('hash');
        $registration->setTermsAccepted(true);

        // em
        $repo = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->setMethods(['findBy'])
            ->getMock();
        $repo->expects($this->any())
            ->method('findBy')
            ->withConsecutive(
                [['username' => 'testuser']],
                [['email' => 'test@email.de']]
            )
            ->will($this->returnValue([]));

        $emMock = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->setMethods(['getRepository'])
            ->getMock();
        $emMock->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($repo));

        // validator
        $constraintValidators = [
            'validator_unique_attribute' => new UniqueAttributeValidator($emMock)
        ];

        $containerMock = $this->getMockForAbstractClass('Symfony\Component\DependencyInjection\ContainerInterface');

        $validatorFactory = new ConstraintValidatorFactory($containerMock, $constraintValidators);

        $validatorBuilder = Validation::createValidatorBuilder();
        $validatorBuilder->enableAnnotationMapping();
        $validatorBuilder->setConstraintValidatorFactory($validatorFactory);

        $validator = $validatorBuilder->getValidator();

        $this->assertCount(0, $validator->validate($registration));
    }
} 