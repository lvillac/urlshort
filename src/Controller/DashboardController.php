<?php

namespace App\Controller;

use App\Entity\Urls;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        //var_dump($user->getId());die();

        $query = $em->getRepository(Urls::class)->getUrlsUser();

        return $this->render('dashboard/index.html.twig', [
            'url' => $query
        ]);
    }
}
