<?php

namespace Politix\PolitikportalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class FrontController extends Controller
{
    
    public function indexAction($name)
    {
    
    	// $q = Doctrine_Manager::getInstance()->getCurrentConnection();
		// $result = $q->execute("SELECT name FROM rss_sources");
		
		// $results = $q->fetchAll(); 
		

		
		$conn = $this->container->get('database_connection');
		$sql = 'SELECT name FROM rss_sources';
		$sources = $conn->query($sql);


        return $this->render('PolitikportalBundle:Default:index.html.twig', array('name' => $name,'sources' => $sources));
        
    }
}
