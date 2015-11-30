<?php

namespace Smoovio\Bundle\PortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function indexAction(Request $request)
    {
        return new Response('Not implemented.</body>', 501);
    }
}
