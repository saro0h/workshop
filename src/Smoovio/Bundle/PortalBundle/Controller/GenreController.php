<?php

namespace Smoovio\Bundle\PortalBundle\Controller;

use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class GenreController extends Controller
{
    /**
     * @return Response
     */
    public function listAction()
    {
        $genres = $this->getGenreRepository()->findBy([], ['title' => 'asc']);

        return $this->render('SmoovioPortalBundle:Genre:list.html.twig', ['genres' => $genres]);
    }

    /**
     * @return ObjectRepository
     */
    private function getGenreRepository()
    {
        return $this->get('smoovio_core.repository.genre');
    }
}
