<?php

namespace Smoovio\Bundle\PortalBundle\Controller;

use Smoovio\Bundle\CoreBundle\Entity\Genre;
use Doctrine\Common\Persistence\ObjectRepository;
use Smoovio\Bundle\CoreBundle\Entity\Movie;
use Smoovio\Bundle\CoreBundle\Entity\Role;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MovieController extends Controller
{
    /**
     * @param Movie $movie
     * @return Response
     */
    public function detailAction(Movie $movie)
    {
        return $this->render('SmoovioPortalBundle:Movie:detail.html.twig', ['movie' => $movie]);
    }

    /**
     * @param string $slug
     * @return Response
     * @throws NotFoundHttpException
     */
    public function listByGenreAction($slug)
    {
        /** @var Genre $genre */
        $genre = $this->getGenreRepository()->findOneBySlug($slug);

        if (null === $genre) {
            throw new NotFoundHttpException();
        }

        $movies = $this->getMovieRepository()->findByGenre($genre, ['title' => 'asc']);

        return $this->render(
            'SmoovioPortalBundle:Movie:listByGenre.html.twig',
            ['movies' => $movies, 'genre' => $genre]
        );
    }

    /**
     * @param int $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function listByActorAction($id)
    {
        /** @var Role[] $roles */
        $roles = $this->getRoleRepository()->findByActor($id);
        $actor = $this->getActorRepository()->find($id);

        $movies = array_map(
            function (Role $role) {
                return $role->getMovie();
            },
            $roles
        );

        return $this->render(
            'SmoovioPortalBundle:Movie:listByActor.html.twig',
            ['movies' => $movies, 'actor' => $actor]
        );
    }

    /**
     * @param int $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function listByDirectorAction($id)
    {
        $director = $this->getDirectorRepository()->find($id);
        $movies = $director->getMovies();

        return $this->render(
            'SmoovioPortalBundle:Movie:listByDirector.html.twig',
            ['movies' => $movies, 'director' => $director]
        );
    }

    /**
     * @return ObjectRepository
     */
    private function getMovieRepository()
    {
        return $this->get('smoovio_core.repository.movie');
    }

    /**
     * @return ObjectRepository
     */
    private function getRoleRepository()
    {
        return $this->get('smoovio_core.repository.role');
    }

    /**
     * @return ObjectRepository
     */
    private function getActorRepository()
    {
        return $this->get('smoovio_core.repository.actor');
    }

    /**
     * @return ObjectRepository
     */
    private function getDirectorRepository()
    {
        return $this->get('smoovio_core.repository.director');
    }

    /**
     * @return ObjectRepository
     */
    private function getGenreRepository()
    {
        return $this->get('smoovio_core.repository.genre');
    }
}
