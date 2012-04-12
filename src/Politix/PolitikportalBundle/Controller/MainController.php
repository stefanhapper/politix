<?php

namespace Politix\PolitikportalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller {

	var $response = FALSE;
	
	function __construct() {
	
		$this->response = new Response();
	
	    $this->response->setPublic();
		$this->response->setMaxAge(60);
		$this->response->setSharedMaxAge(60);
		
	}
    
    
    public function getHomepageAction() {
		
		if (apc_fetch('homeLastModified')) {
		
			$ApcLastModified = apc_fetch('homeLastModified');
			
		} else {
		
			$ApcLastModified = time();
			apc_store('homeLastModified',time());
			
		}

		$timezone = new \DateTimeZone('Europe/Brussels');
		
		$lastModified = new \DateTime('@' . $ApcLastModified);
    	$lastModified->setTimezone($timezone);
    	
    	$this->response->setLastModified($lastModified);
    	
	    $request = $this->getRequest();    	
		
    	if ($this->response->isNotModified($this->getRequest())) {
    		return $this->response;
    	}
    	
    	
    	$out['heading'] = $lastModified->format('r');

        
        /*
        
         $TopicModel = $this->get('TopicModel');
    	

    	$topics = $TopicModel->getHomepageTopics();
    	
    	foreach ($topics as $topic) {
    		$out['topics'][] = $TopicModel->getTopic($topic);
    	}
    	
    	$this->response->setContent($this->render('PolitikportalBundle:Default:topics.html.twig', $out));

		*/

    	$this->response->setContent('my content (' . $out['heading'] . ')');
		
    	return $this->response;    
    	
    }        
    
}
