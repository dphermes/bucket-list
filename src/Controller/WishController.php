<?php

namespace App\Controller;

use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    /**
     * @Route("/wishlist", name="wish_list")
     */
    public function list(WishRepository $wishRepository): Response
    {
        // $allWishes = $wishRepository->findBy(["isPublished" => "true"], ["title" => "DESC"]);
        $allWishes = $wishRepository->findCategorizedWishes();

        return $this->render('wish/list.html.twig', [
            'controller_name' => 'WishController',
            'wishes' => $allWishes,
        ]);
    }

    /**
     * @Route("/details/{id}", name="wish_details")
     */
    /* TODO methods={GET} */
    public function detail(WishRepository $wishRepository, $id): Response
    {
        // @TODO : Fetch wish in DB
        $myWish = $wishRepository->find($id);

        // If this wish doesn't exist in DB
        if(!$myWish){
            // 404 Error
            throw $this->createNotFoundException('This wish is gone!');
        }

        return $this->render('wish/details.html.twig', [
            'controller_name' => 'WishController',
            'id' => $id,
            'wish' => $myWish,
        ]);
    }

}
