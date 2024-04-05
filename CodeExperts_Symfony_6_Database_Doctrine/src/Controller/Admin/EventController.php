<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/events', name: 'admin_event')]
class EventController extends AbstractController
{
    #[Route('/', name: 'index', methods: 'GET')]
    public function index(): Response
    {
        return $this->render('admin/event/index.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }

    #[Route('/store', name: 'store', methods: 'GET')]
    public function store(EntityManagerInterface $manager): Response
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

        return new Response('Evendo criado com sucesso!');
    }
}
