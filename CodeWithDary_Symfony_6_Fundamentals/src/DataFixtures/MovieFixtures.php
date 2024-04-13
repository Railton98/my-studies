<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $movie = (new Movie)
            ->setTitle('The Dark Knight')
            ->setReleaseYear(2008)
            ->setDescription('This is the description of the Dark Knight')
            ->setImagePath('https://cdn.pixabay.com/photo/2024/01/15/11/36/batman-8510027_640.png');
        // Add Data to Pivot Table
        $movie->addActor($this->getReference('actor_1'));
        $movie->addActor($this->getReference('actor_2'));

        $manager->persist($movie);

        $movie2 = (new Movie)
            ->setTitle('Avengers: Endgame')
            ->setReleaseYear(2019)
            ->setDescription('This is the description of the Avengers: Endgame')
            ->setImagePath('https://cdn.pixabay.com/photo/2022/06/05/11/18/action-figures-7243811_960_720.jpg');
        // Add Data to Pivot Table
        $movie2->addActor($this->getReference('actor_3'));
        $movie2->addActor($this->getReference('actor_4'));

        $manager->persist($movie2);

        $manager->flush();
    }
}
