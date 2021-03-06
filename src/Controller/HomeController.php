<?php

namespace App\Controller;

use App\Entity\Urls;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository(Urls::class)->getUrls();

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );


        return $this->render('home/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/mas-visitadas", name="masVisitadas")
     */
    public function masVisitadas(PaginatorInterface $paginator, Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository(Urls::class)->getUrls();

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );


        return $this->render('home/index.html.twig', [
            'pagination' => $pagination
        ]);
    }


}
