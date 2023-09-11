<?php

namespace App\DataFixtures;

use App\Entity\Dish;
use App\Entity\Category;
use App\Entity\Restaurant;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class RestaurantFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        
        //Nous préparons un tableau associatif de Catégories, dont la clef contient le nom de la Catégorie, tandis que la valeur contiendra l'objet Category que nous lierons aux Restaurants. L'objet pour l'instant n'est pas encore créé: nous plaçons comme valeur temporarie: null.
        $categoryList = [
            'Chinois'=> null,
            'Fast-Food' => null,
            'Indien' => null,
            'Italien' => null,
            'General' => null,
        ];

        //Les différents attributs de nos restaurants sont renseignés dans ce tableau de tableaux
        $restaurantData = [
            //Premier sous-tableau, contenant les informations d'UN restaurant. La fonction makeContent() permettra de générer un Lorem Ipsum original par tableau si nous n'avons pas de description prête
            [  
                'name' => 'Asia Room',
                'address' => '*** Paris',
                'description' => $this->makeContent(),
                'openHours' => "11h à 22h",
                'category' => 'Chinois',
            ],
            [  
                'name' => 'La Maison du Dim Sum',
                'address' => '*** Paris',
                'description' => $this->makeContent(),
                'openHours' => "11h à 22h",
                'category' => 'Chinois',
            ],
            [  
                'name' => "New art du Ravioli",
                'address' => '*** Paris',
                'description' => $this->makeContent(),
                'openHours' => "11h à 22h",
                'category' => 'Chinois',
            ],
            [  
                'name' => 'Chez Haki',
                'address' => '*** Paris',
                'description' => $this->makeContent(),
                'openHours' => "11h à 22h",
                'category' => 'Chinois',
            ],
            [  
                'name' => 'La Cantine Chinoise Wenzhou',
                'address' => '*** Paris',
                'description' => $this->makeContent(),
                'openHours' => "11h à 22h",
                'category' => 'Chinois',
            ],
            [  
                'name' => 'New Fulis',
                'address' => '*** Paris',
                'description' => $this->makeContent(),
                'openHours' => "11h à 22h",
                'category' => 'Chinois',
            ],
            [  
                'name' => 'KFC',
                'address' => '*** Paris',
                'description' => $this->makeContent(),
                'openHours' => "11h à 22h",
                'category' => 'Fast-Food',
            ],
            [  
                'name' => 'Quick',
                'address' => '*** Paris',
                'description' => $this->makeContent(),
                'openHours' => "11h à 22h",
                'category' => 'Fast-Food',
            ],
            [  
                'name' => 'McDonalds',
                'address' => '*** Paris',
                'description' => $this->makeContent(),
                'openHours' => "11h à 22h",
                'category' => 'Fast-Food',
            ],
            [  
                'name' => 'Chicken Spot',
                'address' => '*** Paris',
                'description' => $this->makeContent(),
                'openHours' => "11h à 22h",
                'category' => 'Fast-Food',
            ],
            [  
                'name' => 'Roomies',
                'address' => '*** Paris',
                'description' => $this->makeContent(),
                'openHours' => "11h à 22h",
                'category' => 'Fast-Food',
            ],
            [  
                'name' => 'Factory Co',
                'address' => '*** Paris',
                'description' => $this->makeContent(),
                'openHours' => "11h à 22h",
                'category' => 'Fast-Food',
            ],
            [  
                'name' => 'Etoile du Kashmir',
                'address' => '*** Paris',
                'description' => $this->makeContent(),
                'openHours' => "11h à 22h",
                'category' => 'Indien',
            ],
            [  
                'name' => 'Le Parfum de l\'Inde',
                'address' => '*** Paris',
                'description' => $this->makeContent(),
                'openHours' => "11h à 22h",
                'category' => 'Indien',
            ],
            [  
                'name' => 'Station Krishna',
                'address' => '*** Paris',
                'description' => $this->makeContent(),
                'openHours' => "11h à 22h",
                'category' => 'Indien',
            ],
            [  
                'name' => 'Royal Kashmir',
                'address' => '*** Paris',
                'description' => $this->makeContent(),
                'openHours' => "11h à 22h",
                'category' => 'Indien',
            ],
            [  
                'name' => 'Fuxia',
                'address' => '*** Paris',
                'description' => $this->makeContent(),
                'openHours' => "11h à 22h",
                'category' => 'Italien',
            ],
            [  
                'name' => 'La Maison Italienne',
                'address' => '*** Paris',
                'description' => $this->makeContent(),
                'openHours' => "11h à 22h",
                'category' => 'Italien',
            ],
            [  
                'name' => 'Pepita',
                'address' => '*** Paris',
                'description' => $this->makeContent(),
                'openHours' => "11h à 22h",
                'category' => 'Italien',
            ],
            [  
                'name' => 'Le Pain Quotidien',
                'address' => '*** Paris',
                'description' => $this->makeContent(),
                'openHours' => "11h à 22h",
                'category' => 'General',
            ],
            ];

        //Nous préparons plusieurs nom de plats génériques selon les catégories:
        $dishData = [
            'Chinois'=> [
                'Bo Bun', 'Gyoza', 'Boeuf Loc Lac', 'Délice Boeuf', 'Délice Porc', 'Nouilles sautées Boeuf', 'Pad Thai', 'Salade Poulet', 'Rouleaux de Printemps', 'Soupe de Nouilles Légumes', 'Wok Aubergines',
            ],
            'Fast-Food' => [
                'Hamburger Bacon', 'Veggie Burger', 'Burger du Jour', 'Potatoes', 'Frites', 'Fanta', 'Cheesecake', 'Crème glacée',
            ],
            'Indien' => [
                'Nan au Fromage', 'Nan Poulet Légumes', 'Nan Nature', 'Boeuf en sauce avec riz', 'Crevettes décortiquées sauce au choix', 'Baigan bharta', 'Palak paneer', 'Alloo Masala', 'DALL Lentiilles', 'Biryani Agneau', 'Biryani KEEMA viande hachée',
            ],
            'Italien' => [
                'Pizza Margherita', 'Calabrese', 'Pizza Prosciutto e Funghi', 'Pizza végétarienne', 'Pizza 4 fromaggi', 'Tartufata Burrata', 'Campana Bufala', 'Jambon de Parme', 'Bresaola', 'Mortadelle Massima'
            ],
            'General' => [
                'Pancakes', 'Breakfast Burrito', 'Omelette aux champignons', 'Muffin', 'Brownie',
            ],
        ];


        //Préparation de la création des plats et restaurants

        //Nous commençons par créer toutes nos catégories selon les clefs de notre tableau
        //L'& nous permet d'indiquer que nous désirons la variable $categoryValue et non une copie de sa valeur afin de pouvoir modifier notre tableau
        foreach($categoryList as $categoryKey => &$categoryValue){
            $categoryValue = new Category;
            $categoryValue->setName($categoryKey);
            $categoryValue->setDescription($this->makeContent()); //Description aléatoire
            $manager->persist($categoryValue); //Pour chaque catégorie créée, nous effectuons une demande de persistance
        }
        
        //Création des plats et restaurants: Nous créons tous les restaurants et nous leur attribuons un nombre aléatoire de plats parmi une sélection prédéterminée
        foreach($restaurantData as $restaurantInfo){
            $restaurant = new Restaurant;
            $restaurant->setName($restaurantInfo['name']);
            $restaurant->setAddress($restaurantInfo['address']);
            $restaurant->setDescription($restaurantInfo['description']);
            $restaurant->setOpenHours($restaurantInfo['openHours']);
            $restaurant->setCategory($categoryList[$restaurantInfo['category']]);
            //Nous passons une boucle for laquelle iterera autant de fois qu'il existe de noms de plats dans le tableau de plats de la catégorie de notre Restaurant
            for($i=0; $i < (count($dishData[$restaurantInfo['category']]) - 1); $i++){
                if(rand(0,1)){ //Une chance sur deux d'ajouter le plat
                    $dish = new Dish;
                    $dish->setName($dishData[$restaurantInfo['category']][$i]); //Le numéro $i du sous-tableau tableau dishData correspondant à la catégorie de notre restaurant
                    $dish->setDescription($this->makeContent()); 
                    $dish->setPrice(rand(1,15) + 0.99); //Prix au produit aléatoire
                    $dish->setRestaurant($restaurant); //Nous lions le plat au restaurant créé dans la boucle parente
                    $manager->persist($dish); //Demande de persistance du plat actuel
                }
            }
            $manager->persist($restaurant); //Demande de persistance du restaurant actuel
        }

        $manager->flush(); //Nous appliquons toutes les demandes en attente et nous terminons notre fonction load()
    }

    public function makeContent(){
        /*
         * makeContent() est une méthode ayant pour but de préparer des contenu de bulletin originaux
         * Ces contenus sont préparés à partir d'une sélection de plusieurs morceaux de texte
         * Chaque chaine de caractères retournée par makeContent() commence par le même Lorem Ipsum
         * Ce contenu est préparé entre autres grâce à la fonction shuffle()
         */
        
        /*
         * ETAPE #1
         * Préparation de notre première variable $lorem, laquelle sera le début constant de nos chaines
         * de caractères. Préparation de notre tableau $snippets, lequel contiendra tous les différents
         * extraits utilisés pour créer nos contenus de bulletin
         */
        
        //Notre première variable, $lorem, contient un texte constant
        $lorem = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse consectetur viverra metus, id lobortis elit fermentum non. Sed maximus turpis id lorem dignissim, nec faucibus purus tincidunt. Sed vitae euismod ante. Integer eget risus augue. Sed sagittis sollicitudin erat, vel consequat velit. Nunc ac fringilla diam. ';
        //Nous créons notre tableau $snippets, lequel contient chaque extrait utilisé pour notre texte
        $snippets = [
            'Ut semper vehicula erat, ac lacinia dolor condimentum vel. Vestibulum accumsan, nunc a finibus maximus, est lectus iaculis quam, vitae malesuada orci turpis sit amet lectus. Etiam hendrerit lorem ut felis ultricies convallis. Integer eget ligula est. Vestibulum tempor vestibulum urna, ac tempus sapien volutpat a',
            'Nulla at nunc id tellus pulvinar volutpat. Phasellus viverra est nulla, ornare commodo nulla vehicula in. Phasellus bibendum condimentum neque quis consequat. Sed arcu nibh, rutrum eget libero vel, varius molestie orci.',
            'Donec ultrices sodales diam, nec dictum mauris vulputate non. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam in aliquam arcu, eu vestibulum turpis. Integer tincidunt finibus elit, tristique ornare erat tempor sit amet. Ut dictum nisi dolor, in feugiat leo fermentum id.',
            'Aenean at mi aliquam, volutpat diam in, lacinia velit. Maecenas et ipsum diam. Quisque justo sem, consectetur sed tempus sed, pulvinar sed nisi. Suspendisse potenti. Integer pretium molestie libero, id feugiat enim. Donec vitae ultricies urna. Pellentesque eget porttitor lacus. Maecenas eget lorem ipsum. Aliquam erat volutpat. Donec varius laoreet elementum.',
            'Pellentesque venenatis commodo consequat. Praesent quis lorem ullamcorper ex suscipit vehicula ut nec arcu. Quisque eu magna eget elit bibendum rutrum. Integer lacus felis, tempus eu mi sit amet, convallis cursus lacus. Aenean imperdiet imperdiet nisl sit amet condimentum. Vestibulum placerat aliquet maximus.',
            'Nam id vulputate risus. Proin dignissim accumsan rutrum. Morbi risus quam, imperdiet sed mi in, tristique vehicula metus. Mauris ut lectus elit. Aliquam ex enim, laoreet vel sodales nec, faucibus sit amet urna. Duis bibendum diam in lorem ultricies, aliquet condimentum turpis porta. Nullam interdum tortor vel mollis feugiat.',
            'Aliquam vel fermentum erat. In nunc ipsum, fermentum sit amet est sit amet, tempus imperdiet purus.In tincidunt vestibulum risus, non bibendum diam fringilla at. Nunc eget finibus enim, id auctor mauris. Pellentesque posuere neque eget odio volutpat scelerisque. Ut egestas faucibus nisi quis interdum. Nam tristique et odio interdum tincidunt.',
            'Phasellus at euismod sem, ut tempor lacus. Cras leo orci, gravida placerat malesuada a, efficitur quis mauris. Donec quis arcu efficitur, ornare orci ut, sodales lacus.Maecenas eget semper mi. Aenean ut aliquet nunc. Proin porta fringilla iaculis. Suspendisse potenti. Fusce consectetur blandit tortor quis fermentum.',
            'Vestibulum pretium urna vel metus ullamcorper pulvinar. In hac habitasse platea dictumst. Fusce pellentesque varius congue. Maecenas blandit ornare velit, in condimentum magna semper non. Cras accumsan lobortis dui id sollicitudin. Integer non mauris non risus tincidunt mollis eu volutpat quam. Ut id orci vehicula, finibus tellus eget, luctus odio.', //Même à la dernière entrée du tableau, ajouter une virgule afin d'éviter toute erreur de syntaxe en cas d'ajout ultérieur de nouvelle entrée
        ];
        
        /*
         * ETAPE #2
         * Préparation de notre variable $content, qui sera la chaine de caractères rendue par notre fonction
         * afin de composer la valeur 'content'
         */
        
        //Nous mélangeons notre tableau $snippets afin d'avoir des valeurs originales pour les clefs 0 et 1
        shuffle($snippets);
        
        //$content est la concaténation de $lorem et des deux premières entrées de notre tableau $snippets
        $content = $lorem . $snippets[0] . $snippets[1];
        
        /*
         * ETAPE #3
         * Nous retournons la valeur de la variable $content
         */
        return $content;
    }
}
