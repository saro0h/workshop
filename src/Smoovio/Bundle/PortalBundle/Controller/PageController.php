<?php

namespace Smoovio\Bundle\PortalBundle\Controller;

use Smoovio\Bundle\CoreBundle\Entity\MovieList;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class PageController extends Controller
{
    /**
     * @return Response
     * @throws ServiceUnavailableHttpException
     */
    public function homeAction()
    {
        /** @var MovieList $list */
        $list = $this->getMovieListRepository()->findOneBySlug('portal');

        if (!$list instanceof MovieList) {
            throw new ServiceUnavailableHttpException();
        }

        $movies = $list->getMovies();

        return $this->render('SmoovioPortalBundle:Page:home.html.twig', ['movies' => $movies]);
    }

    /**
     * @return ObjectRepository
     */
    private function getMovieListRepository()
    {
        return $this->get('smoovio_core.repository.movielist');
    }
}
