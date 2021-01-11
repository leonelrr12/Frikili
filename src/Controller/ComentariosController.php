<?php

namespace App\Controller;

use App\Entity\Comentarios;
use App\Form\ComentariosType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComentariosController extends AbstractController
{
    /**
     * @Route("/comentarios", name="comentarios")
     */
    public function index(Request $request): Response
    {
        $user = $this->getUser();
        //$post = $this->getPost();
        $comentario = new Comentarios();
        $form = $this->createForm(ComentariosType::class, $comentario);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $comentario->setUser($user);
            //$comentario->setPosts($post);
            $em->persist($comentario);
            $em->flush();
            return $this->redirectToRoute('dashboard');
        }
        return $this->render('comentarios/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
