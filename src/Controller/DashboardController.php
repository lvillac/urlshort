<?php

namespace App\Controller;

use App\Entity\Urls;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $nombre_usuario = $user->getNombre();

        $query = $em->getRepository(Urls::class)->getUrlsUser();

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );


        return $this->render('dashboard/index.html.twig', [
            'pagination' => $pagination,
            'user' => $nombre_usuario
        ]);
    }
}
