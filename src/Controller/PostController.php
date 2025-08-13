<?php

namespace App\Controller;

use App\Entity\Post; 
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class PostController extends AbstractController
{
    #[Route('/post', name: 'post_index', methods:['GET'])]
    public function index(PostRepository $postRepos): Response
    {
        $posts = $postRepos->findAll();

        return $this->render('post/index.html.twig',[
        'posts'=>$posts
        ]);
    }



    #[Route('/post/create', name: 'post_create', methods:['GET','POST'])]

    public function create(Request $request,EntityManagerInterface $em):Response

{  
$post = new Post();

$form = $this->createForm(PostType::class,$post);
$form->handleRequest($request);

if($form->isSubmitted() && $form->isValid())
{
    $em->persist($post);
    $em->flush();
    return $this->redirectToRoute('post_index');
}
return $this->render('post/create.html.twig',[
    'form'=>$form->createView()
]);
}



#[Route('post/{id}/remove',name: 'post_remove', methods:['POST'])]
public function remove(EntityManagerInterface $em, Post $post, Request $request):Response
{


if ($this->isCsrfTokenValid('delete'.$post->getId(),$request->request->get('_token')))
{
    $em->remove($post);
    $em->flush();
}
return $this->redirectToRoute('post_index');
}




#[Route('/post/{id}/edit', name: 'post_edit', methods: ['GET', 'POST'])]
public function edit(Post $post, Request $request, EntityManagerInterface $em,PostRepository $postRepos): Response
{
    // Crée un formulaire basé sur PostType, pré-rempli avec le Post existant
    $form = $this->createForm(PostType::class, $post);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush(); // Pas besoin de persist(), l'entité est déjà connue de Doctrine
        return $this->redirectToRoute('post_index');
    }

    return $this->render('post/index.html.twig', [
        'form' => $form->createView(),
        'post' => $post,
        'posts' => $postRepos->findAll() 
    ]);
}










}