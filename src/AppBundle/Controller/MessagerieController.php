<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of MessagerieController
 *
 * @author Sébastien
 * @Route("/messagerie")
 */
class MessagerieController extends Controller
{
   /**
     * @Template("AppBundle:Messagerie:index.html.twig")
     * @Route("/", name="messagerie")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return [];
    }
}
