<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    public function __construct(private MovieRepository $movieRepository)
    {
    }

    #[Route('/movies', methods: ['GET'], name: 'movies.index')]
    public function index(): Response
    {
        $movies = $this->movieRepository->findAll();

        return $this->render('movies/index.html.twig', compact('movies'));
    }

    #[Route('/movies/{id}', methods: ['GET'], name: 'movies.show')]
    public function show($id): Response
    {
        $movie = $this->movieRepository->find($id);

        return $this->render('movies/show.html.twig', compact('movie'));
    }
}
