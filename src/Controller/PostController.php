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
    public function index(PostRepository $postRepo): Response
    {
        $posts = $postRepo->findAll();

        return $this->render('post/index.html.twig',[
            'posts'=> $posts,
        ]);

        
    }
    
      // Route pour créer un nouveau post
    #[Route('/post/create', name: 'post_create', methods:['GET','POST'])]

    public function create(Request $request, EntityManagerInterface $em):Response

{    // Création d'un nouvel objet Post
    $post = new Post();


    // Création du formulaire basé sur le type PostType
    $form = $this->createForm(PostType::class,$post);
    $form->handleRequest($request);

    // Si le formulaire est soumis et valide
    if($form->isSubmitted()&& $form->isValid())
    {   //envoie du formulaire
        $em->persist($post);
        $em->flush();
        return $this->redirectToRoute('post_index');
    }
     // Redirection vers la page listant tous les posts
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



}