<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'posts' => $this->getPosts(),
        ]);
    }
    
    #[Route('/post/{slug?}', name: 'app_show')]
    public function show(?string $slug = null): Response
    {
        return $this->render('index/single.html.twig', [
            'slug' => $slug,
        ]);
    }

    private function getPosts(): array
    {
        return [
            ['id' => 1, 'title' => 'Postagem Teste 001', 'slug' => 'postagem-test-001'],
            ['id' => 2, 'title' => 'Postagem Teste 002', 'slug' => 'postagem-test-002'],
            ['id' => 3, 'title' => 'Postagem Teste 003', 'slug' => 'postagem-test-003'],
            ['id' => 4, 'title' => 'Postagem Teste 004', 'slug' => 'postagem-test-004'],
        ];
    }
}
