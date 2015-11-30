<?php

namespace Smoovio\Bundle\PortalBundle\Tests\Functional;

use Smoovio\Bundle\PortalBundle\Test\WebTestCase;

class AuthControllerTest extends WebTestCase
{
    public function testGetLoginIsSuccessful()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('h1:contains("Login")')->count());
    }

    public function testLoginWithCorrectDataRedirectsToProfile()
    {
        $client = static::createClient();
        $this->loadFixtures($client->getKernel());

        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Sign In!')->form();

        $form['_username'] = 'user_provider_test';
        $form['_password'] = 'userpass';
        $form['_remember_me']->untick();

        $crawler = $client->submit($form);

        $this->assertNull($client->getCookieJar()->get('SMOOVIO_REMEMBERME'));
        $this->assertSame(302, $client->getResponse()->getStatusCode());
        $this->assertContains('/profile', $client->getResponse()->getTargetUrl());
    }

    public function testLoginWithWrongDataRedirectsToLogin()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Sign In!')->form();
        $crawler = $client->submit($form, [
            '_username' => 'user',
            '_password' => 'foo',
        ]);

        $this->assertSame(302, $client->getResponse()->getStatusCode());
        $this->assertContains('/login', $client->getResponse()->getTargetUrl());
    }

    public function testLoginWithInvalidCSRFToken()
    {
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Sign In!')->form();
        $crawler = $client->submit($form, [
            '_username' => 'foo',
            '_password' => 'bar',
            '_csrf_token' => 'baz',
        ]);

        $this->assertGreaterThan(0, $crawler->filter('html:contains("Invalid CSRF token.")')->count());
    }

    public function testLoginWithRememberMe()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Sign In!')->form();
        $crawler = $client->submit($form, [
            '_username'    => 'user_provider_test',
            '_password'    => 'userpass',
            '_remember_me' => 'on',
        ]);

        $remembermeCookie = $client->getCookieJar()->get('SMOOVIO_REMEMBERME');
        $this->assertNotNull($remembermeCookie);

        $this->assertSame(302, $client->getResponse()->getStatusCode());
        $this->assertContains('/profile', $client->getResponse()->getTargetUrl());

        $client->restart();
        $client->getCookieJar()->set($remembermeCookie);

        $crawler = $client->request('GET', '/profile');

        $this->assertSame(501, $client->getResponse()->getStatusCode());

        $securityContext = $client->getContainer()->get('security.context');
        $this->assertTrue($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED'));
        $this->assertFalse($securityContext->isGranted('IS_AUTHENTICATED_FULLY'));
    }

    public function testGetSignupIsSuccessful()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/signup');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testRegistrationIsSuccessful()
    {
        $client = static::createClient();
        $this->loadFixtures($client->getKernel());

        $crawler = $client->request('GET', '/signup');
        $form = $crawler->selectButton('Sign up!')->form();
        $crawler = $client->submit($form, [
            'smoovio_core_registration_form[username]' => 'user_new',
            'smoovio_core_registration_form[email]' => 'new@example.com',
            'smoovio_core_registration_form[password][password]' => 'user_new_pass',
            'smoovio_core_registration_form[password][confirm]' => 'user_new_pass',
            'smoovio_core_registration_form[terms]' => 1
        ]);

        $this->assertSame(302, $client->getResponse()->getStatusCode());
        $this->assertSame('/', $client->getResponse()->getTargetUrl());
    }

    public function testRegisterSameUserTwiceIsNotSuccessful()
    {
        $client = static::createClient();
        $this->loadFixtures($client->getKernel());

        // user is already registered via load fixtures
        $crawler = $client->request('GET', '/signup');
        $form = $crawler->selectButton('Sign up!')->form();
        $crawler = $client->submit($form, [
            'smoovio_core_registration_form[username]' => 'user_provider_test',
            'smoovio_core_registration_form[email]' => 'user@user.com',
            'smoovio_core_registration_form[password][password]' => 'user_new_pass',
            'smoovio_core_registration_form[password][confirm]' => 'user_new_pass',
            'smoovio_core_registration_form[terms]' => 1
        ]);

        $this->assertSame(1, $crawler->filter('li:contains("The username "user_provider_test" is already in use")')->count());
        $this->assertSame(1, $crawler->filter('li:contains("The email "user\@usercom" is already in use")')->count());
    }

    public function testUserRegistrationSentsConfirmationMail()
    {
        $client = static::createClient();
        $this->loadFixtures($client->getKernel());

        $crawler = $client->request('GET', '/signup');
        $form = $crawler->selectButton('Sign up!')->form();

        $client->enableProfiler();

        $crawler = $client->submit($form, [
            'smoovio_core_registration_form[username]' => 'user_new',
            'smoovio_core_registration_form[email]' => 'foo@foo.com',
            'smoovio_core_registration_form[password][password]' => 'user_new_pass',
            'smoovio_core_registration_form[password][confirm]' => 'user_new_pass',
            'smoovio_core_registration_form[terms]' => 1
        ]);

        $mailCollector = $client->getProfile()->getCollector('swiftmailer');
        $this->assertEquals(1, $mailCollector->getMessageCount());

        $collectedMessages = $mailCollector->getMessages();
        $message = $collectedMessages[0];

        $this->assertInstanceOf('Swift_Message', $message);
        $this->assertEquals('Welcome to Smoovio', $message->getSubject());
        $this->assertEquals('noreply@smoovio.de', key($message->getFrom()));
        $this->assertEquals('foo@foo.com', key($message->getTo()));
    }
}
