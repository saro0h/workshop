<?php

namespace Smoovio\Bundle\CoreBundle\Tests\Unit\Entity;

use Smoovio\Bundle\CoreBundle\Entity\Director;
use Smoovio\Bundle\CoreBundle\Entity\Movie;

class DirectorTest extends \PHPUnit_Framework_TestCase
{
    public function testAddMovie()
    {
        $movieA = new Movie();
        $movieB = new Movie();

        $director = new Director();

        $this->assertAttributeCount(0, 'movies', $director);

        $director->addMovie($movieA);
        $director->addMovie($movieA);
        $this->assertAttributeCount(1, 'movies', $director);

        $director->addMovie($movieB);
        $this->assertAttributeCount(2, 'movies', $director);

        $this->assertEquals($movieA->getDirectors(), [$director]);
        $this->assertEquals($movieB->getDirectors(), [$director]);
    }
}
