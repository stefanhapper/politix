<?php

namespace Politix\PolitikportalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller {
    
    public function getHomepageAction() {
		
		$lastModified = new \DateTime();
    	$lastModified->createFromFormat('U',apc_fetch('homeLastModified'));

    	
    	$response = new Response();
    
    	$response->setPublic();
		$response->setMaxAge(60);
		$response->setSharedMaxAge(60);
    	
    	$response->setLastModified($lastModified);
    	
    	$request = $this->getRequest();
    	
    	$out['rows'][] = $response->__toString();
    	$out['rows'][] = $request->__toString();
    	
    	$this->render('PolitikportalBundle:Default:dump.html.twig', $out);


    	// if ($response->isNotModified($this->getRequest())) return $response;
    	
    	

    	// $out['heading'] = $lastModified->format('r');

        // $TopicModel = $this->get('TopicModel');
    	
/*
    	$topics = $TopicModel->getHomepageTopics();
    	
    	$out['rows'][] = 'empty';

    	foreach ($topics as $topic) {
    	
    		$out['topics'][] = $TopicModel->getTopic($topic);
    	
    	}
    	
    	$response->setContent($this->render('PolitikportalBundle:Default:topics.html.twig', $out));

    	return $response;    	
*/
        
    }
    
	
	public function testCacheAction() {
	
		$response = new Response(date('r'));

		$response->setPublic();

		$response->setMaxAge(60);
		$response->setSharedMaxAge(60);

		return $response;
	
	}
        
    
}
