<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Entity\Category;
use App\Entity\Commande;
use App\Entity\Restaurant;
use App\Entity\Reservation;
use App\Service\RestoTools;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/backoffice")
 * @Security("is_granted('ROLE_CLIENT')")
 */
class CommandeController extends AbstractController
{
    /**
     * @Route("/", name="commande_backoffice")
     */
    public function commandeBackoffice(): Response
    {
        //Nous récupérons l'Utilisateur
        $user = $this->getUser();
        //Cette fonction a pour but de nous aider à traiter les différentes commandes de Dish passées en tant qu'utilisateur
        //Pour obtenir la liste des Commande et Reservation, nous devons faire appel à l'Entity Manager ainsi qu'aux Repository pertinents
        $entityManager = $this->getDoctrine()->getManager();
        $commandeRepository = $entityManager->getRepository(Commande::class);
        //Nous récupérons la liste des Catégories pour notre navbar
        $categoryRepository = $entityManager->getRepository(Category::class);
        $categories = $categoryRepository->findAll();
        //Nous récupérons les Commande actives
        $pastCommandes = $commandeRepository->findBy(['client' => $user, 'status' => 'validee']);
        //Nous récupérons les Commande actives
        $activeCommandes = $commandeRepository->findBy(['client' => $user, 'status' => 'panier']);
        //Nous transmettons les deux résultats à notre vue Twig:
        return $this->render('commande/commande-backoffice.html.twig', [
            'categories' => $categories,
            'user' => $user,
            'activeCommandes' => $activeCommandes,
            'commandes' => $pastCommandes,
        ]);
    }

    /**
     * @Route("/delete/{commandeId}", name="commande_delete_backoffice")
     */
    public function deleteCommande(Request $request, $commandeId, RestoTools $restoTools): Response
    {
        //Cette fonction a pour but de supprimer une commande ainsi que toutes les Reservation liées
        //Nous récupérons l'Utilisateur en cours
        $user = $this->getUser();
        //Nous récupérons tout d'abord l'Entity Manager ainsi que le Repository de Commande
        $entityManager = $this->getDoctrine()->getManager();
        $commandeRepository = $entityManager->getRepository(Commande::class);
        //Nous récupérons ensuite la Commande dont l'ID nous a été transmis
        $commande = $commandeRepository->find($commandeId);
        //Si la Commande n'existe pas OU que le status n'est pas "panier", nous retournons au Backoffice
        if (!$commande || ($commande->getClient() != $user) || ($commande->getStatus() != 'panier')) {
            return $this->redirect($this->generateUrl('commande_backoffice'));
        }
        //Si notre commande est bien valide, nous pouvons supprimer les Reservation après restitution de leurs quantity
        foreach ($commande->getReservations() as $reservation) {
            $dish = $reservation->getDish();
            $entityManager->persist($dish);
            $entityManager->remove($reservation);
        }
        //Une fois que toutes les Reservations ont été supprimées, nous passons à la requête de suppression de notre commande
        $entityManager->remove($commande);
        //Nous appliquons toutes les requêtes
        $entityManager->flush();
        //Nous créons un flash bag
        $restoTools->createFlashbag('Votre commande a bien été supprimée');
        //Une fois la suppression effecuée, nous retournons au backoffice
        return $this->redirect($this->generateUrl('commande_backoffice'));
    }
    
    /**
     * @Route("/buy/remove/{dishId}", name="reservation_delete_backoffice")
     * @Security("is_granted('ROLE_CLIENT')")
     */
    public function removeReservation(Request $request, $dishId = false, RestoTools $restoTools): Response{
        $user = $this->getUser();
        //Cette méthode de Controller a pour objectif de décrémenter ou de supprimer une Réservation effectuée précédemment dans une Commande liée à ce Restaurant précis
        //Nous récupérons l'Entity Manager afin de pouvoir dialoguer avec notre base de données
        $entityManager = $this->getDoctrine()->getManager();
        $dishRepository = $entityManager->getRepository(Dish::class);
        $commandeRepository = $entityManager->getRepository(Commande::class);
        //Nous récupérons le dish indiqué par notre paramètre de route
        $dish = $dishRepository->find($dishId);
        //Si le dish n'existe pas, nous revenons à notre page d'index
        if(!$dish){
            return $this->redirect($this->generateUrl('index'));
        }
        //Si le dish existe, nous récupérons le Restaurant lié
        $restaurant = $dish->getRestaurant();
        //Nous vérifions s'il existe une commande liée à ce Restaurant avec un statut 'panier'
        $commandes = $commandeRepository->findBy(['restaurant' => $dish->getRestaurant(), 'client' => $user, 'status' => 'panier']);
        //Si la commande n'existe pas, la Reservation non et nous revenons donc à l'accueil du Restaurant
        if(empty($commandes)){
            return $this->redirect($this->generateUrl('index_restaurant', ['restaurantId' => $restaurant->getId()]));
        }
        //Si la Commande existe, nous la tirons de son tableau et nous recherchons s'il existe une Reservation au nom du dish lié
        $commande = $commandes[0];
        $reservation = false; //Nous initialisons Reservation
        //Si un dish d'une Reservation présente dans notre Commande est la même que le dish de notre méthode de controller, nous récupérons cette Reservation sous notre variable $reservation
        foreach($commande->getReservations() as $commandeReservation){
            if($commandeReservation->getDish() == $dish){ 
                $reservation = $commandeReservation;
                break;
            }
        }
        //Si la Reservation n'existe pas, nous revenons à notre page de Restaurant
        if(!$reservation){
            return $this->redirect($this->generateUrl('index_restaurant', ['restaurantId' => $restaurant->getId()]));
        } else {
            //Nous vérifions la quantity de la Réservation. Si elle est égale ou inférieure à 0 après décrémentation, nous supprimons la Réservation
            $reservation->setQuantity($reservation->getQuantity() - 1);
            if($reservation->getQuantity() <= 0){
                $commande->removeReservation($reservation); //Nous retirons la Reservation de la Commande
                $entityManager->remove($reservation); //Requête de suppression de la Reservation
            } else $entityManager->persist($reservation);
        }
        //Si la dernière réservation de la Commande a été supprimée, nous supprimons également la Commande
        if($commande->getReservations()->isEmpty()){ //Fonction ArrayCollection vérifiant si le tableau est vide
            $entityManager->remove($commande);
        }
        $entityManager->flush();
        //Nous créons un flash bag
        $restoTools->createFlashbag('Reservation supprimée');
        //Après le processus de décrémentation/suppression, nous revenons à l'accueil du Restaurant
        return $this->redirect($this->generateUrl('commande_backoffice'));
    }
    
    /**
     * @Route("/buy/validate/{restaurantId}", name="commande_validate_backoffice")
     * @Security("is_granted('ROLE_CLIENT')")
     */
    public function validateCommande(Request $request, $restaurantId, RestoTools $restoTools): Response{
        $user = $this->getUser();
        //Cette fonction valide la Commande en cours dans ce restaurant
        //Nous récupérons l'Entity Manager et le Repository de Restaurant
        $entityManager = $this->getDoctrine()->getManager();
        $restaurantRepository = $entityManager->getRepository(Restaurant::class);
        //Nous récupérons le Restaurant indiqué
        $restaurant = $restaurantRepository->find($restaurantId);
        //Si le restaurant n'existe pas, nous retournons à l'index
        if(!$restaurant){
            return $this->redirect($this->generateUrl('index'));
        }
        //Si le Restaurant existe, nous vérifions s'il existe une Commande en mode panier en son nom, et si oui, nous la validons
        $commande = false;
        foreach($restaurant->getCommandes() as $restaurantCommande){
            if(($restaurantCommande->getStatus() == 'panier') && ($restaurantCommande->getClient() == $user)){
                $commande = $restaurantCommande;
                break;
            }
        }
        //Si la commande est trouvée, nous modifions son statut
        if($commande){
            $commande->setStatus('validee');
            $entityManager->persist($commande);
            $entityManager->flush();
            //Nous créons un flash bag notifiant la validation de la commande
            $restoTools->createFlashbag('Votre commande a bien été validée');
        }
        //Nous revenons alors vers la vitrine de notre Restaurant
        return $this->redirect($this->generateUrl('commande_backoffice'));
    }

}
