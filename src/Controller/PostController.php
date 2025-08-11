<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PostController extends AbstractController
{
    #[Route('/post', name: 'post', methods:['GET'])]
    public function index(PostRepository $postRepo): Response
    {
        $posts = $postRepo->findAll();

        return $this->render('post/index.html.twig',[
            'posts'=> $posts,
        ]);

    }
}
