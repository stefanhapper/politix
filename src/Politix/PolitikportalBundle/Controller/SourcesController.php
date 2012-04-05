<?php

namespace Politix\PolitikportalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// use Politix\PolitikportalBundle\Model;


class SourcesController extends Controller {
        
    
    function getSourceAction($source) {
    
    	$out['source'] = $source;
		
    	$sql = 'SELECT * FROM rss_items WHERE source LIKE "' . $source . '" ORDER BY pubDate DESC LIMIT 0,10';
    	$out['items'] = $this->getDB($sql);
		
        return $this->render('PolitikportalBundle:Default:items.html.twig', $out);    
    	
    }
    
    
    function getSourcesAction($page = 1) {
        	
    	$db = $this->get('SourceModel');
    	
    	$out['sources'] = $db->getSources($page);
    	$out['pages'] = $db->getPages($page);
    	$out['page'] = $page;
    	
    	return $this->render('PolitikportalBundle:Default:sources.html.twig', $out);

    }
    
    
}
