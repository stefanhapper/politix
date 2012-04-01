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
    
    public function myAction($name)
    {
		
		$out['name'] = $name;
		
        return $this->render('PolitikportalBundle:Default:my.html.twig', $out);
        
    }
    
    
    function getSource($source) {
    
    	$sql = 'SELECT * FROM rss_items WHERE source LIKE "' . $source . '" ORDER BY pubDate DESC LIMIT 0,10';
    	return $this->getDB($sql);
    	
    }
    
    
    function getDB($sql) {
    
    	$conn = $this->container->get('database_connection');
		return $conn->query($sql);
    
    }
    
    
}
