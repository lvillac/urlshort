<?php

namespace App\Controller;

use App\Entity\Urls;
use App\Form\UrlsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UrlsController extends AbstractController
{
    /**
     * @Route("/registrar-url", name="RegistrarUrl")
     */
    public function index(Request $request)
    {
        $url = new Urls();

        $form = $this->createForm(UrlsType::class, $url);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user = $this->getUser();
            $url->setUser($user);

            $aUrl = $form['url']->getData();

            //Acortamos url
            $url_short = $this->shortUrl($aUrl);

            $url->setUrlCorta($url_short);

            $em = $this->getDoctrine()->getManager();
            $em->persist($url);
            $em->flush();
            return $this->redirectToRoute('dashboard');

        }

        return $this->render('urls/index.html.twig', [
            'form' => $form->createView()
        ]);
    }



    public function shortUrl($aUrl){

       return  $url_short = 'http://xy.com/'. substr(md5($aUrl.mt_rand()), 0, 8);

    }
}
