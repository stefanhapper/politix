<?php

namespace Politix\PolitikportalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class FrontController extends Controller
{
    
    public function indexAction($name)
    {
		
		$out['items'] = $this->getSource('tagesschau');
		$out['name'] = $name;
		
        return $this->render('PolitikportalBundle:Default:items.html.twig', $out);
        
    }
    
    
    function getSource($source) {
    
    	$sql = 'SELECT * FROM rss_items WHERE source LIKE "' . $source . '"';
    	return $this->getDB($sql);
    	
    }
    
    
    function getDB($sql) {
    
    	$conn = $this->container->get('database_connection');
		return $conn->query($sql);
    
    }
    
    
}
