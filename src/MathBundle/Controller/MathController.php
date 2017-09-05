<?php

namespace MathBundle\Controller;

use Exception;
use MathBundle\Entity\Joueur;
use MathBundle\Entity\Operateur;
use MathBundle\Entity\Partie;
use MathBundle\Entity\Question;
use MathBundle\Form\JoueurType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of MathController
 *
 * @author Sébastien
 * @Route("/math")
 */
class MathController extends Controller
{

    /**
     * @Template("MathBundle::index.html.twig")
     * @Route("/", name="math")
     */
    public function indexAction(Request $request)
    {
        $session = $this->get('session');
        $serializer = $this->get('jms_serializer');
        ////////////////ZONE DE TEST SERIALISATION////////////////
//        $serializer = $this->get('jms_serializer');
//        $joueurTest = $this->getDoctrine()->getRepository('MathBundle\Entity\Joueur')->findOneById(2);
//
//        $session->set('joueurTest', $serializer->serialize($joueurTest, 'json'));
//        $joueurEnSession = $serializer->deserialize($session->get('joueurTest'), 'MathBundle\Entity\Joueur', 'json');
//        ddump($joueurEnSession);
//
//        if ($joueurTest === $joueurEnSession){
//            die('meme instance');
//        } else {
//            die('instance différente');
//        }
//        Affiche : instance différente
        //////////////////////////////////////////////////////////

        $joueurSelectionne = $session->has('joueurMath') ? $serializer->deserialize($session->get('joueurMath'), 'MathBundle\Entity\Joueur', 'json') : null;

        return [
            'joueurSelectionne' => $joueurSelectionne,
        ];
    }

    /**
     * @Template("MathBundle::parametresPartie.html.twig")
     * @Route("/creerPartie", name="creerPartieParametres")
     * @param Request $request
     */
    public function creerPartieParametresAction(Request $request)
    {
        $partie = new Partie();

        $form = $this->createFormBuilder($partie)
            ->add('operandeMax', IntegerType::class, array('label' => 'Opérande max'))
            ->add('operandeMin', IntegerType::class, array('label' => 'Opérande min'))
            ->add('tempsParQuestion', IntegerType::class, array('label' => 'Temps par question (en seconde)'))
            ->add('quantiteQuestion', IntegerType::class, array('label' => 'Nombre total de questions dans la partie'))
            ->add('operateurs', EntityType::class, array(
                'label' => 'Opérateurs à utiliser',
                'class' => 'MathBundle:Operateur',
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true,
            ))
            ->add('save', SubmitType::class, array('label' => 'Créer une partie'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partie = $form->getData();
            $session = $this->get('session');
            $serializer = $this->get('jms_serializer');
            $joueur = $serializer->deserialize($session->get('joueurMath'), 'MathBundle\Entity\Joueur', 'json');
            $partie->setJoueur($joueur);

            $em = $this->getDoctrine()->getManager();
            $em->persist($partie);
            $em->flush();

            $this->constructionDesQuestions($partie);

            return $this->redirectToRoute('question');
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/rejouer/{idPartiePrecedente}", name="rejouer", requirements={"idPartiePrecedente"="\d+"})
     */
    public function rejouerMemeParamAction($idPartiePrecedente)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->get('session');
        $serializer = $this->get('jms_serializer');

        $joueurSelectionne = $session->has('joueurMath') ? $serializer->deserialize($session->get('joueurMath'), 'MathBundle\Entity\Joueur', 'json') : null;
        /* @var $anciennePartie Partie */
        $anciennePartie = $this->getDoctrine()->getRepository('MathBundle\Entity\Partie')->find($idPartiePrecedente);
        $partie = new Partie();
        $partie
            ->setJoueur($joueurSelectionne)
            ->setTempsParQuestion($anciennePartie->getTempsParQuestion())
            ->setOperandeMax($anciennePartie->getOperandeMax())
            ->setOperandeMin($anciennePartie->getOperandeMin())
            ->setOperateurs($anciennePartie->getOperateurs())
            ->setQuantiteQuestion($anciennePartie->getQuantiteQuestion());

        $em->persist($partie);
        $em->flush();

        $this->constructionDesQuestions($partie);

        return $this->redirectToRoute('question');
    }

    /**
     * @Template("MathBundle::question.html.twig")
     * @Route("/question", name="question")
     * @param Request $request
     */
    public function question(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $session = $this->get('session');
        $serializer = $this->get('jms_serializer');
        $partie = $serializer->deserialize($session->get('partieMath'), 'MathBundle\Entity\Partie', 'json');

        $listeQuestion = $this->getDoctrine()->getRepository('MathBundle\Entity\Question')->findBy(array('partie' => $partie));
//        $session->remove('partieMath');


        $questionsRestantes = array();
        foreach ($listeQuestion as $question) {
//            $question = $serializer->deserialize(json_encode($questionSerialized), 'MathBundle\Entity\Question', 'json');
            if ($question->getIsCorrect() === null) {
                $questionsRestantes[] = $question;
                break;
            }
        }
//        ddump($questionsRestantes);

        if (count($questionsRestantes) === 0) {
            $partie = $serializer->deserialize($session->get('partieMath'), 'MathBundle\Entity\Partie', 'json');
            $bonneReponse = 0;
            foreach ($listeQuestion as $question) {
                if ($question->getIsCorrect() === true) {
                    $bonneReponse++;
                }
            }
            $pourcentBonneReponse = round(($bonneReponse / count($listeQuestion)) * 100);
            $partie->setScore($pourcentBonneReponse);
            $em->persist($partie);
            $em->flush();
            $session->remove('partieMath');

            return $this->redirectToRoute('resultat_partie', array('idPartie' => $partie->getId()));
        }

        $currentQuestion = $questionsRestantes[0];

        $form = $this->createFormBuilder($currentQuestion)
            ->add('resultatDonne', HiddenType::class)
//            , 'disabled' => true
            ->add('tempsPasse', HiddenType::class, array('data' => '0'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $question = $form->getData();

            if ($question->getIsCorrect() != null) {
                return $this->redirectToRoute('question');
            }

            if ((string) $question->getResultatCorrect() == $question->getResultatDonne()) {
                $question->setIsCorrect(true);
            } else {
                $question->setIsCorrect(false);
            }

            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute('question');
        }
//        ddump($currentQuestion);
        return [
            'form' => $form->createView(),
            'question' => $currentQuestion,
        ];
    }

    /**
     * @Template("MathBundle::resultatPartie.html.twig")
     * @Route("/resultatPartie/{idPartie}", name="resultat_partie", requirements={"idPartie"="\d+"})
     * @param Request $request
     */
    public function resultatPartie($idPartie, Request $request)
    {
        $partie = $this->getDoctrine()->getRepository('MathBundle\Entity\Partie')->find($idPartie);

        if (!$partie) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
        }
        $listeQuestions = $this->getDoctrine()->getRepository('MathBundle\Entity\Question')->findBy(array('partie' => $partie));

        return[
            'partie' => $partie,
            'listeQuestions' => $listeQuestions,
        ];
    }

    /**
     * @Template("MathBundle::listeJoueur.html.twig")
     * @Route("/selectionJoueur", name="listeSelectionJoueur")
     * @param Request $request
     */
    public function affichageListeJoueursPourSelectionAction(Request $request)
    {
        $listeJoueurs = $this->getDoctrine()->getManager()->getRepository('MathBundle\Entity\Joueur')->findAll();

        return [
            'listeJoueurs' => $listeJoueurs,
            'action' => 'selection'
        ];
    }

    /**
     * @Template("MathBundle::listeJoueur.html.twig")
     * @Route("/historiqueJoueur", name="listeHistoriqueJoueur")
     * @param Request $request
     */
    public function affichageListeJoueursPourHistoriqueAction(Request $request)
    {
        $listeJoueurs = $this->getDoctrine()->getManager()->getRepository('MathBundle\Entity\Joueur')->findAll();

        return [
            'listeJoueurs' => $listeJoueurs,
            'action' => 'historique'
        ];
    }

    /**
     * @Template("MathBundle::listeJoueur.html.twig")
     * @Route("/gestionJoueur", name="listeGestionJoueur")
     * @param Request $request
     */
    public function affichageListeJoueursPourGestionAction(Request $request)
    {
        $listeJoueurs = $this->getDoctrine()->getManager()->getRepository('MathBundle\Entity\Joueur')->findAll();

        return [
            'listeJoueurs' => $listeJoueurs,
            'action' => 'gestion'
        ];
    }

    /**
     * @Route("/sessionJoueur/{id}", name="sessionJoueur", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function miseEnSessionDuJoueurAction($id, Request $request)
    {
        $joueur = $this->getDoctrine()->getManager()->getRepository('MathBundle\Entity\Joueur')->findOneById($id);
        $serializer = $this->get('jms_serializer');
        $session = $this->get('session');

        $session->set('joueurMath', $serializer->serialize($joueur, 'json'));

//        ddump($session->get('joueurMath'));
//       return $this->forward('MathBundle:Math:index',array($request),array($request));
        return $this->redirectToRoute('math');
    }

    /**
     * @Route("/deleteJoueur/{id}", name="deleteJoueur", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function deleteJoueurAction($id, Request $request)
    {
        $joueur = $this->getDoctrine()->getManager()->getRepository('MathBundle\Entity\Joueur')->findOneById($id);

//        ddump($joueur);
        $em = $this->getDoctrine()->getManager();
        $em->remove($joueur);
        $em->flush();

//        ddump($session->get('joueurMath'));
//       return $this->forward('MathBundle:Math:index',array($request),array($request));
        return $this->redirectToRoute('listeGestionJoueur');
    }

    /**
     * @Route("/logoutJoueur/", name="logoutJoueur")
     * @param Request $request
     */
    public function logoutJoueurAction(Request $request)
    {
//        die('ici');
        $session = $this->get('session');
//        $serializer = $this->get('jms_serializer');
        $session->remove('joueurMath');
//        ddump($session->all());
        return $this->redirectToRoute('math');
    }

    /**
     * @Template("MathBundle::formCreationJoueur.html.twig")
     * @Route("/creationJoueur", name="creationJoueur")
     * @param Request $request
     */
    public function creationJoueurAction(Request $request)
    {
        $joueur = New Joueur();
//        $form = $this->createForm('JoueurType', $joueur);
        $form = $this->get('form.factory')->create(JoueurType::class, $joueur);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($joueur);
            $em->flush();

//            ddump($joueur);
            return $this->redirectToRoute('sessionJoueur', array('id' => $joueur->getId()));
        }
        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Template("MathBundle::listePartie.html.twig")
     * @Route("/listePartie/{idJoueur}", name="listePartie", defaults={"idJoueur": null}, requirements={"idJoueur"="\d+"})
     * @param $idJoueur
     */
    public function afficherListeDesPartiesAction($idJoueur)
    {
        //si null, afficher toutes les parties jouées par ordre chrono
        if ($idJoueur === null) {
            $listePartie = $this->getDoctrine()->getRepository('MathBundle\Entity\Partie')->findAll();
        } else {
            // sinon, afficher les stats et parties pour un joueur
            $user = $this->getDoctrine()->getRepository('MathBundle\Entity\Joueur')->find($idJoueur);
            if ($user) {
                $listePartie = $this->getDoctrine()->getRepository('MathBundle\Entity\Partie')->findBy(array('joueur' => $user));
            } else {
                throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Aucun joueur avec un id : ' . $idJoueur);
            }
        }

        return array('listePartie' => $listePartie);
    }

    private function constructionDesQuestions(Partie $partie)
    {
        $em = $this->getDoctrine()->getManager();
        $serializer = $this->get('jms_serializer');
//        $listeQuestion = array();

        for ($i = 0; $i < $partie->getQuantiteQuestion(); $i++) {

            $operande1 = random_int($partie->getOperandeMin(), $partie->getOperandeMax());
            $operande2 = random_int($partie->getOperandeMin(), $partie->getOperandeMax());
            $operateur = $this->choixOperateur($partie->getOperateurs());

            if ($operateur->getId() === Operateur::DIVISION && $operande1 === 0 || $operande2 === 0) {
                if ( $operande1 === 0 ) { $operande1 = 1; }
                if ( $operande2 === 0 ) { $operande2 = 1; }
            }

            $resultat = $this->calculerResultat($operande1, $operande2, $operateur);
            $question = new Question();
            $question
                ->setPartie($partie)
                ->setOperande1($operande1)
                ->setOperande2($operande2)
                ->setOperateur($operateur)
                ->setResultatCorrect($resultat);

            $em->persist($question);
//            $listeQuestion[$i] = $question;
        }
        $em->flush();

//        ddump($listeQuestion);
        $session = $this->get('session');
        $session->set('partieMath', $serializer->serialize($partie, 'json'));
    }

    private function choixOperateur($listeOperateur)
    {
        $liste = array();
        foreach ($listeOperateur as $operateur) {
            $liste[] = $operateur->getId();
        }
        shuffle($liste);

        foreach ($listeOperateur as $operateur) {
            if ($operateur->getId() === $liste[0]) {
                return $operateur;
            }
        }
        throw new Exception('Probleme dans le choix de l\'opérateur');
    }

    private function calculerResultat($operande1, $operande2, $operateur)
    {
        switch ($operateur->getId()) {
            case Operateur::ADDITION:
                return $operande1 + $operande2;
            case Operateur::SOUSTRACTION:
                return $operande1 - $operande2;
            case Operateur::MULTIPLICATION:
                return $operande1 * $operande2;
            case Operateur::DIVISION:
                return round($operande1 / $operande2, 2);
        }
    }
}
