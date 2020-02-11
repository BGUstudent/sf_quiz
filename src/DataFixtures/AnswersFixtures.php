<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use APP\Entity\Answers;
use APP\Entity\Questions;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;


class AnswersFixtures extends Fixture implements OrderedFixtureInterface
{
    private $quizAnswers = array (
        0 => array( 
            0 => "Un conteneur symbolique et autonome qui contient des informations et des mécanismes concernant un sujet.",
            1 => "Un élément de référence qui définit une instruction.",
            2 => "Une entité (une chose) définie dans un espace  à trois dimension."),
        1 => array( 
            0 => "Créer un objet selon une classe avec une variable définie.",
            1 => "Faire une copie à un instant donné d’une fonction.",
            2 => "Photographier la classe de madame Pritz pour son départ à la retraite."),
        2 => array( 
            0 => "La référence à objet sont des variables de type objet que l'on  a déclaré.",
            1 => "Un pointeur qui permet de rappeler un objet.",
            2 => "Une parodie de chanson."),
        3 => array( 
            0 => "Une méthode qui permet de lire la valeur d’une propriétés inexistante dans la classe.",
            1 => "Une variable de travail interne à une instruction.",
            2 => "Un slogan de salle de fitness."),
        4 => array( 
            0 => "Une méthode qui  permet de faire ce que l'on appelle de la surcharge de propriétés d'une classe.",
            1 => "Une commande pour placer des valeurs.",
            2 => "Une race de canidé."),
        5 => array( 
            0 => "Des fonctions qui implémentent les traitements de la classe.",
            1 => "Des commandes de mise en application.",
            2 => "Des façons d’agir sur une action donné."),
        6 => array( 
            0 => "Ce sont des variables qui peuvent être des variables d'instances, des variables de classes ou des constantes.",
            1 => "Des éléments de définition de fonction.",
            2 => "Un terrain appartenant à un particulier."),
        7 => array( 
            0 => "Un éléments qui modifie une méthode.",
            1 => "Des valeurs par défaut.",
            2 => "une icône en forme d’engrenage."),
        8 => array( 
            0 => "Une fonction particulière appelée lors de l'instanciation.",
            1 => "Un programme de compilation.",
            2 => "Un ouvrier du BTP."),
        9 => array( 
            0 => "Une méthode spéciale lancée lors de la destruction d'un objet afin de récupérer les ressource.",
            1 => "Une fonction de suppression.",
            2 => "Un cimmérien agressif."),
        10 => array( 
            0 => "A définir les champs d’actions d’une variables.",
            1 => "A signifier  les inclusions de fichier.",
            2 => "A choisir la hausse du canon."),
        11 => array( 
            0 => "C’est une copie ou prise de référence de l’objet référencer.",
            1 => "Une fonction de modification.",
            2 => "Un technicien logistique."),
        12 => array( 
            0 => "Une variable non accessible directement en dehors de la fonction.",
            1 => "Un élément de fonction.",
            2 => "Un utilisateur changent de pseudo constamment."),
        13 => array( 
            0 => "Un mécanisme consistant à rassembler les données et les méthodes au sein d'une structure en cachant l'implémentation de l'objet.",
            1 => "Une fonction de méthode sur les objets.",
            2 => "Une usine de bouteille."),
        14 => array( 
            0 => "Public, private et protected.",
            1 => "All, some et restricted.",
            2 => "All your base are belong to us."),
        15 => array( 
            0 => "De proposer de nouvelles fonctionnalités sans casser la structure originale",
            1 => "Agrandir une fonction.",
            2 => "Faire des travaux dans un établissement scolaire."),
        16 => array( 
            0 => "Un mécanisme qui permet, lors de la déclaration d’une nouvelle classe, d'y inclure les caractéristiques d’une autre classe.",
            1 => "Une Fonction permutant la copie.",
            2 => "Un événement familial."),
        17 => array( 
            0 => "Cela permet de choisir entre différentes versions d'une même fonction ou méthode selon le nombre et le type des arguments fournis.",
            1 => "Le fait de donner trop de fonction.",
            2 => "Un non événement dans l’Education Nationale."),
        18 => array( 
            0 => "C’est lorsqu’on redéfinit une classe mère dans une classe fille.",
            1 => "L’inclusion d’un trop grand nombre de variables.",
            2 => "Une erreur dans les plans de construction."),
        19 => array( 
            0 => "Il fournit un moyen d'accéder aux membres static ou Constant, ainsi qu'aux propriétés ou méthodes surchargées d'une classe.",
            1 => "Une fonction avec 3 variables.",
            2 => "Une expression javanaise."),
        20 => array( 
            0 => "Une valeur qui ne change jamais en cours de script.",
            1 => "Une fonction pour tracer un ligne droite.",
            2 => "La connerie humaine."),
        21 => array( 
            0 => "C’est un alias est un moyen d’accéder au contenu d’une même variable en utilisant un autre nom.",
            1 => "Cataloguer une méthode.",
            2 => "GA BU ZO MEU."),
        );
    public function load(ObjectManager $manager)
    {
        for($i=0; $i<22; $i++){
            for($j=0; $j<3; $j++){
            $answer = new Answers();
            $answer->setContent($this->quizAnswers[$i][$j]);
            if($j==0){
                $answer->setValue(1);
            }else{
                $answer->setValue(0);
            }
            $answer->setQuestion($this->getReference('question_'.$i));
            $manager->persist($answer);
            }
        }
        $manager->flush();
    }
    public function getOrder() {
        return 2; // Load after Questions
    }
}
