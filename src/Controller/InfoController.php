<?php

namespace App\Controller;

use ApiPlatform\Symfony\Bundle\Test\Response as TestResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\POST;
use App\Controller\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\POSTRepository;
use Symfony\Flex\Response as FlexResponse;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Paginator;


class InfoController extends AbstractController
{    

    #[Route('/list{page?1}/{nbre?12}', name: 'app_info')]

    public function index(POSTRepository $postRepository,ManagerRegistry $doctrine,Request $request,$page,$nbre):Response
{   
    $repository=$doctrine->getRepository(Post::class);

    $posts=$postRepository->findBy([],limit:$nbre,offset:($page-1)*$nbre);
    
    $nbPost=$repository->count([]);

    $nbrePage=ceil($nbPost / $nbre);
    


    return $this->render('info/base.html.twig',[

        'posts'=> $posts,
        'isPaginated'=>true,
        'nbrePage'=>$nbrePage,
        'page'=>$page,
        'nbre'=>$nbre
    ]);


}

#[Route('/article/delete/{id}',methods: ['GET','DELETE'] ,name: 'delete_article')]
  
   public function delete(POSTRepository $postRepository,ManagerRegistry $doctrine,$id):Response
   {
       $post=$postRepository->find($id);
       
       $entityManager=$doctrine->getManager();

       $entityManager->remove($post);
       
       $entityManager->flush();

       return $this->redirectToRoute('app_info');

   }

    
   
}







