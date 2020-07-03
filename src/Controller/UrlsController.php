<?php

namespace App\Controller;

use App\Entity\Urls;
use App\Entity\User;
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

    /**
     * @Route("/urls/{id}", name="VerUrls")
     */
    public function verUrls($id)
    {

        $em = $this->getDoctrine()->getManager();

        $urls = $em->getRepository(Urls::class)->find($id);

        return $this->render('urls/verUrls.html.twig', ["urls" => $urls]);

    }

    /**
     * @Route("/url-user", name="urlsUser")
     */
    public function urlsUser(){

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $urls = $em->getRepository(Urls::class)->findBy(['user' => $user]);
        return$this->render('urls/urlsUser.html.twig', ['urls' => $urls]);

    }


    //1. Estategia para acortar urls
    public function shortUrl($aUrl){

       return  $url_short = 'http://xy.com/'. substr(md5($aUrl.mt_rand()), 0, 8);

    }


}
