<?php

namespace Politix\PolitikportalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class FrontController extends Controller
{
    
    public function indexAction($name)
    {
		
		$out['items'] = _getSource('tagesschau');
		$out['name'] = $name;
		
        return $this->render('PolitikportalBundle:items.html.twig', $out);
        
    }
    
    
    function _getSource($source) {
    
    	$sql = 'SELECT * FROM rss_items WHERE source LIKE "' . $source . '"';
    	return _getDB($sql);
    	
    }
    
    
    function _getDB($sql) {
    
    	$conn = $this->container->get('database_connection');
		return $conn->query($sql);
    
    }
    
    
}
