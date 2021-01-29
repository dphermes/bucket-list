<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddWishController extends AbstractController
{
    /**
     * @Route("/add-wish", name="add_wish")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {

        $myNewWish = new Wish();

        // Créé une instance du form, en lui associant une entité
        $form = $this->createForm(WishType::class, $myNewWish);

        // Prend les données du formulaire soumis et les hydrate dans mon entité
        $form->handleRequest($request);

        // Est-ce que le formulaire osumis est valide...
        if($form->isSubmitted() && $form->isValid()){
            // Hydrate les propriété manquante requise en BDD
            $myNewWish->setDateCreated(new \DateTime());
            $myNewWish->setIsPublished(true);

            // Déclenche l'insert en bdd
            $entityManager->persist($myNewWish);
            $entityManager->flush();

            // Créé un message à transférer à la page vers laquelle on sera redirigé après validation du form
            $this->addFlash('success', 'Your bucket has been created successfully');

            // Redirige vers une autre page
            return $this->redirectToRoute('wish_details', ['id' => $myNewWish->getId()]);
        }

        return $this->render('add_wish/add.html.twig', [
            "wish_form" => $form->createView()
        ]);
    }
}
