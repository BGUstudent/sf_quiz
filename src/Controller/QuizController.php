<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Questions;
use App\Entity\Answers;
use App\Form\QuestionType;
use App\Repository\QuestionsRepository;
use Symfony\Component\HttpFoundation\Request;



class QuizController extends AbstractController
{
    /**
     * @Route("/quiz/qcm", name="qcm")
     */
    public function qcm(){
        $repo = $this->getDoctrine()->getRepository(Questions::class);
        $question = $repo->findAll();
        return $this->render('quiz/qcm.html.twig', [
            'question'=>$question,
        ]);
    }

    /**
     * @Route("/quiz/result", name="result")
     */
    public function result(){
        $repo = $this->getDoctrine()->getRepository(Answers::class);
        $count=count($_POST)-1;
        $score=0;
        $wrong=[];
        foreach ($_POST as $key=>$value){
            if((intval($value)+2)%3==0){
                $score++;
            }else{
                $wrong[]=$repo->findBy(array('id'=>$value));
            }
        }
        array_pop($wrong); //pour enlever le submit qui est contenu dans le POST

        return $this->render('quiz/result.html.twig', [
            'score'=>$score,
            'count'=>$count,
            'wrong'=>$wrong,
        ]);
    }

    /**
     * @Route("/quiz/notion/{id}", name="notion")
     */
    public function notion($id){
        $repo = $this->getDoctrine()->getRepository(Questions::class);
        $question = $repo->find($id);
        $repo2 = $this->getDoctrine()->getRepository(Answers::class);
        $answers[] = $repo2->findBy(array('question'=>$id),array('id' => 'ASC'));

        return $this->render('quiz/notion.html.twig', [
            'question'=>$question,
            'answers'=>$answers
        ]);
    }

    /**
     * @Route("/quiz/concepts", name="concepts")
     */
    public function concepts(){
        $repo = $this->getDoctrine()->getRepository(Questions::class);
        $question = $repo->findAll();

        return $this->render('quiz/concepts.html.twig', [
            'question'=>$question
        ]);
    }

    /**
     * @Route("/admin/edit", name="edit")
     */
    public function edit(){
        $repo = $this->getDoctrine()->getRepository(Questions::class);
        $question = $repo->findAll();
        return $this->render('admin/edit.html.twig', [
            'question'=>$question
        ]);
    }
    
    /**
    * @Route("/admin/edit1/{id}", name="edit1")
    */
    public function edit1($id, Request $request, EntityManagerInterface $manager){
        $entityManager = $this->getDoctrine()->getManager();
        $question = $entityManager->getRepository(Questions::class)->find($id);
        $question->setContent($question->getContent());

        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($question);
            $manager->flush();

            return $this->redirectToRoute('edit');
        }
        return $this->render('admin/edit1.html.twig', [
            'form'=>$form->createView(),
        ]);
    }
    
    /**
     * @Route("/admin/delete/{id}", name="delete")
     */
    public function delete($id){
        $entityManager = $this->getDoctrine()->getManager();
        $question = $entityManager->getRepository(Questions::class)->find($id);
        $entityManager->remove($question);
        $entityManager->flush();
        return $this->redirectToRoute('concepts');
    }

    /**
     * @Route("/admin/add", name="add")
     */
    public function add(Request $request, EntityManagerInterface $manager){
        $question = new Questions();

        $answer1 = new Answers();
        $answer1->setContent('Bonne réponse');
        $answer1->setValue(1);
        $answer1->setQuestion($question);
        $question->getAnswers()->add($answer1);
        $answer2 = new Answers();
        $answer2->setContent('Mauvaise réponse');
        $answer2->setValue(0);
        $answer2->setQuestion($question);
        $question->getAnswers()->add($answer2);
        $answer3 = new Answers();
        $answer3->setContent('Mauvaise réponse');
        $answer3->setValue(0);
        $answer3->setQuestion($question);
        $question->getAnswers()->add($answer3);

        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($question);
            $manager->flush();

            return $this->redirectToRoute('notion', ['id' =>$question->getId()]);
        }
        return $this->render('admin/add.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route("/quiz/search", name="search")
     */
    public function search(){
        $titre = "<h1>Programmation Orientée Objet</h1>";
        $repo = $this->getDoctrine()->getRepository(Questions::class);
        $search = $_GET['key'];
        $question= $repo->findAll();
        $match=[];
        foreach ($question as $item) {
            similar_text($search, $item->getConcepts(),$percent);
            if ($percent > 42){
                $match[] = $item;
            };
        }
        return $this->render('quiz/search.html.twig', [
            'match'=>$match
        ]);
    }

    /**
     * @Route("/", name="index")
     */
    public function index(){
        $titre = "<h1>Programmation Orientée Objet</h1>";
        $message = "Bienvenue et bon courage";

        return $this->render('quiz/index.html.twig', [
            'titre'=>$titre,
            'message'=>$message

        ]);
    }
}
