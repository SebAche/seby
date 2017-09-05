<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Ce contrôleur est en charge de gérer la page d'accueil qui permettra ensuite de rediriger vers les apps
 *
 * @author Sébastien
 */
class AccueilControler extends Controller
{
    /**
     * @Template("AppBundle:Accueil:index.html.twig")
     * @Route("/", name="accueil")
     *
     * @param \AppBundle\Controller\Request $request
     */
    public function functionName(Request $request)
    {
        if ( !$this->get('security.authorization_checker')->isGranted('ROLE_USER')){
            return $this->redirectToRoute('fos_user_security_login');
        }
        
        return array();
    }

    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @return type
     */
    public function contactAction(Request $request) {

        $request->getSession()->getFlashBag()->add('info', 'La page de contact n’est pas encore disponible, merci de revenir plus tard.');
        return $this->redirectToRoute('accueil');
    }
}
