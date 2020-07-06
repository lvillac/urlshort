<?php

namespace App\Controller;

use App\Entity\Urls;
use App\Entity\User;
use App\Form\UrlsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        $user = $this->getUser();
        $nombre_usuario = $user->getNombre();

        if ($form->isSubmitted() && $form->isValid()) {

            $url->setUser($user);

            $aUrl = $form['url']->getData();

            //Acortamos url -- Utilizamos la estrategia 1, para implementar otra estrategia solo hacer llamada a la funcion correspondiente a la strategia 2
            $url_short = $this->shortUrl($aUrl);

            $url->setUrlCorta($url_short);

            $em = $this->getDoctrine()->getManager();
            $em->persist($url);
            $em->flush();
            return $this->redirectToRoute('dashboard');

        }

        return $this->render('urls/index.html.twig', [
            'form' => $form->createView(),
            'user' => $nombre_usuario
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
    public function urlsUser()
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $urls = $em->getRepository(Urls::class)->findBy(['user' => $user]);
        return $this->render('urls/urlsUser.html.twig', ['urls' => $urls]);

    }


    //1. Estategia para acortar urls
    public function shortUrl($aUrl)
    {

        return $url_short = 'http://xy.com/' . substr(md5($aUrl . mt_rand()), 0, 8);

    }

    //2. Estategia para acortar urls largas
    public function acortarUrl($aUrl)
    {
        $longitud = strlen($aUrl);
        if ($longitud > 45) {
            $longitud = $longitud - 30;
            $parte_inicial = substr($aUrl, 0, -$longitud);
            $parte_final = substr($aUrl, -15);
            $nueva_url = $parte_inicial . $parte_final;
            return $nueva_url;
        } else {
            return $aUrl;
        }
    }

    /**
     * @Route("/clicks", options={"expose"=true}, name="clicks")
     */
    public function ajaxClicks(Request $request)
    {

        if ($request->isXmlHttpRequest()) {

            $em = $this->getDoctrine()->getManager();
            $id = $request->request->get('id');
            $url = $em->getRepository(Urls::class)->find($id);
            $clicks = $url->getClicks() + 1;

            //Aumentamos clicks
            $query = $em->getRepository(Urls::class)->createQueryBuilder('')
                ->update(Urls::class, 'url')
                ->set('url.clicks', ':clicks')
                ->setParameter('clicks', $clicks)
                ->where('url.id = :id')
                ->setParameter('id', $id)
                ->getQuery();

            $result = $query->execute();

            return new JsonResponse(['clicks' => $clicks]);
        } else {
            throw new \Exception('Error');
        }


    }


}
