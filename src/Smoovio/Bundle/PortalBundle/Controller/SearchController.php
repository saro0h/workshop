<?php

namespace Smoovio\Bundle\PortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('SmoovioPortalBundle:Search:index.html.twig');
    }
}
