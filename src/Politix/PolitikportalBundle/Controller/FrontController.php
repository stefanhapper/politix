<?php

namespace Politix\PolitikportalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class FrontController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('PolitikportalBundle:Default:index.html.twig', array('name' => $name));
    }
}
