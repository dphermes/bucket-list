<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    /**
     * @Route("/wishlist", name="wish_list")
     */
    public function list(): Response
    {
        return $this->render('wish/list.html.twig');
    }

    /**
     * @Route("/details/{id}", name="wish_details", requirements={"id": "[0-9]+"})
     */
    /* TODO methods={GET} */
    public function detail(int $id): Response
    {
        // @TODO : Fetch wish in DB
        return $this->render('wish/details.html.twig', array('id' => $id));
    }

}
