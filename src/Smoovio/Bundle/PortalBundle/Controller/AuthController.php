<?php

namespace Smoovio\Bundle\PortalBundle\Controller;

use Smoovio\Bundle\PortalBundle\Form\RegistrationType;
use Smoovio\Bundle\CoreBundle\User\Registration\Registration;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;

class AuthController extends Controller
{
    public function loginAction(Request $request)
    {
        $utils = $this->get('security.authentication_utils');

        return $this->render('SmoovioPortalBundle:Auth:login.html.twig', [
            'last_username' => $utils->getLastUsername(),
            'error' => $utils->getLastAuthenticationError(),
        ]);
    }

    public function signupAction(Request $request)
    {
        $form = $this->createForm(new RegistrationType(), new Registration());

        if ($this->getRegistrationFormHandler()->handle($form, $request)) {
            return $this->redirect($this->generateUrl('portal_home'));
        }

        return $this->render('SmoovioPortalBundle:Auth:signup.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return \Smoovio\Bundle\CoreBundle\Form\Handler\FormHandlerInterface
     */
    protected function getRegistrationFormHandler()
    {
        return $this->container->get('smoovio_core.registration.handler');
    }
}
