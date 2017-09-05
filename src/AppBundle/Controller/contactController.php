<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of contactController
 *
 * @author Sébastien
 * @Route("/contact")
 */
class contactController extends Controller
{
    /**
     * @Template("AppBundle:Contact:list.html.twig")
     * @Route("/", name="listingContact")
     */
    public function listAction(Request $request)
    {
        $repoContact = $this->getDoctrine()->getManager()->getRepository('AppBundle:Contact');
        $listeContact = $repoContact->findAll();
        return array('listContact' => $listeContact);
    }
}
