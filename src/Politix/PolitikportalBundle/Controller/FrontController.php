<?php

namespace Politix\PolitikportalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class FrontController extends Controller
{
    
    public function indexAction($name)
    {
    
    	$q = Doctrine_Manager::getInstance()->getCurrentConnection();
		$result = $q->execute("SELECT name FROM rss_sources");
		
		$results = $q->fetchAll();  


        return $this->render('PolitikportalBundle:Default:index.html.twig', array('name' => $name,'results' => $results));
        
    }
}
