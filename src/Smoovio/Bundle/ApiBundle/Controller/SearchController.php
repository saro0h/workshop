<?php

namespace Smoovio\Bundle\ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SearchController extends Controller
{
    /**
     * @Route("/search", defaults={"_format": "json"})
     */
    public function movieAction(Request $request)
    {
        $searchTerm = $request->query->get('term');
        $searchTerm = trim($searchTerm);

        if (empty($searchTerm)) {
            throw new BadRequestHttpException('You have to provide a search term.');
        }

        $movies = $this->get('smoovio_core.repository.movie')->search($searchTerm);

        return $this->render('SmoovioApiBundle:Search:movie.json.twig', ['movies' => $movies]);
    }
}
