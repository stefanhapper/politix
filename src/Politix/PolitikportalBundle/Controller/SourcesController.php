<?php

namespace Politix\PolitikportalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Politix\PolitikportalBundle\Model;


class SourcesController extends Controller {
    
    public function indexAction($name) {
		
		$out['items'] = $this->getSource('tagesschau');
		$out['name'] = $name;
		
        return $this->render('PolitikportalBundle:Default:items.html.twig', $out);
        
    }
    
    
    function getSourceAction($source) {
    
    	$out['source'] = $source;
		
    	$sql = 'SELECT * FROM rss_items WHERE source LIKE "' . $source . '" ORDER BY pubDate DESC LIMIT 0,10';
    	$out['items'] = $this->getDB($sql);
		
        return $this->render('PolitikportalBundle:Default:items.html.twig', $out);    
    	
    }
    
    
    function getSourcesAction() {
    
    	$db = new SourceModel(&$this);
    	$out['sources'] = $db->getSources;
    	
    	return $this->render('PolitikportalBundle:Default:sources.html.twig', $out);

    }

    
    
    function getDB($sql) {
    
    	$conn = $this->container->get('database_connection');
		return $conn->query($sql);
    
    }
    
    
}
