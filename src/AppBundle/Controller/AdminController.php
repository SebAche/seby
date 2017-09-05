<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of AdminController
 *
 * @author Sébastien
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Template("AppBundle:Admin:index.html.twig")
     * @Route("/", name="homepageAdmin")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return [];
    }
}
