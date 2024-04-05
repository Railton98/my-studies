<?php

namespace App\DataFixtures;

use App\Entity\Event;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EventFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $timezone = new DateTimeZone('America/Sao_Paulo');

        $event = (new Event)
            ->setTitle('Evento 1')
            ->setDescription('Evento 1')
            ->setBody('Evento 1')
            ->setSlug('evento-1')
            ->setStartDate(new DateTime('2024-04-05 14:00:00', $timezone))
            ->setEndDate(new DateTime('2024-04-05 18:00:00', $timezone))
            ->setCreatedAt(new DateTimeImmutable('now', $timezone))
            ->setUpdatedAt(new DateTimeImmutable('now', $timezone));

        $manager->persist($event);
        $manager->flush();
    }
}
