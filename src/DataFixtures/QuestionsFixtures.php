<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Questions;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class QuestionsFixtures extends Fixture implements OrderedFixtureInterface
{
    private $quizQuestions = array (
        "Qu'est-ce qu'un objet ?",
        "Que veut dire instancier une classe ?",
        "Comment expliquer la référence à l'objet ?",
        "Qu’est ce qu’un getter ?",
        "Et un setter ? ",
        "Que sont les méthodes ?",
        "Qu’appelle t’on propriétés ?",
        "Que sont les paramètres ?",
        "Qu’est ce que le constructeur ?",
        "Et le destructeur ?",
        "A quoi sert les différentes portées ?",
        "Que signifie un opérateur d’objet ?",
        "Qu’est ce qu’une pseudo-variable ?",
        "Expliquer le principe d'encapsulation ?", //cacher l'état interne d'un objet et d'imposer de passer par des méthodes permettant un accès sécurisé à l'état de l'objet.
        "Quels sont les 3 niveaux de visibilité ?",
        "Quel est le principe d’étendre une classe ?",
        "Qu’est ce qu’un héritage ?",
        "Qu’est ce que la surcharge de classe ?",
        "Comment fonctionne la surcharge de propriétés ?",
        "Quels sont les 3 opérateurs de résolution de portée ?",
        "A quoi sert une constante ?",
        "Qu’est ce que référencer une classe ?"
        );

        private $quizConcepts = array (
            "Objet",
            "Instance",
            "Référence à l'objet",
            "Getter",
            "Setter",
            "Méthodes",
            "Propriétés",
            "Paramètres",
            "Constructeur",
            "Destructeur",
            "Portées",
            "Opérateur d’objet",
            "Pseudo-variable",
            "Encapsulation", 
            "Niveaux de visibilité",
            "Etendre une classe",
            "Héritage",
            "Surcharge de classe",
            "Surcharge de propriétés",
            "Opérateurs de résolution de portée",
            "Constante",
            "Référencer une classe"
            );

    public function load(ObjectManager $manager)
    {
        for($i=0; $i<22; $i++){
            $question = new Questions();
            $question->setContent($this->quizQuestions[$i]);
            $question->setConcepts($this->quizConcepts[$i]);
            $this->addReference('question_'.$i, $question);
            $manager->persist($question);
        }
        $manager->flush();
    }

    public function getOrder() {
        return 1; // Load before Answers
    }
}