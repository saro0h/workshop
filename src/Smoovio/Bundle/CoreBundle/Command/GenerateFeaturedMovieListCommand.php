<?php

namespace Smoovio\Bundle\CoreBundle\Command;

use Doctrine\ORM\EntityManager;
use Smoovio\Bundle\CoreBundle\Entity\MovieList;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateFeaturedMovieListCommand extends Command
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        parent::configure();

        $this->setName('smoovio:playlist:create_featured')
            ->setDescription('Generates a random list of featured movies');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $movieRepository = $this->entityManager->getRepository('SmoovioCoreBundle:Movie');

        $count = $movieRepository
            ->createQueryBuilder('m')
            ->select('COUNT(m)')
            ->getQuery()
            ->getSingleScalarResult();

        $list = new MovieList('Featured Movies', 'portal');

        for ($i = 0; $i < 10; $i++) {
            $movie = $movieRepository->createQueryBuilder('m')
                ->setFirstResult(rand(0, $count - 1))
                ->setMaxResults(1)
                ->getQuery()
                ->getSingleResult();
            $list->addMovie($movie);

            $output->writeln('Added ' . $movie->getTitle());
        }

        $this->entityManager->persist($list);
        $this->entityManager->flush();
        $output->writeln('Done');

        return 0;
    }
}
 