<?php 

namespace App\Service;

use App\Entity\Category;
use App\Entity\Commande;
use App\Entity\Reservation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\RequestStack;

class RestoTools{
	
	private $security;
	private $manager;
    private $requestStack;

	public function __construct(Security $security, EntityManagerInterface $manager, RequestStack $requestStack){
		$this->security = $security; //Security non utilisé ici permet de récupérer l'utilisateur via $this->security->getUser();
		$this->manager = $manager; //Manager permet de récupérer l'Entity Manager
		$this->requestStack = $requestStack; //requestStack permet de récupérer l'objet $request
	}

    public function createFlashbag(string $info): bool{
        //Cette fonction génère un flashbag selon le message passé en argument
        $this->requestStack->getSession()->getFlashBag()->add('message', $info);
        return true;
    }
 
}