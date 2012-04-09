<?php

namespace Politix\PolitikportalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller {
    
    public function getHomepageAction() {
		
        $TopicModel = $this->get('TopicModel');
    	
    	$topics = $TopicModel->getHomepageTopics();
    	
    	$out['rows'][] = 'empty';
    	$out['heading'] = date('r');

    	foreach ($topics as $topic) {
    	
    		$out['topics'][] = $TopicModel->getTopic($topic);
    	
    	}
    	
    	
    	$response = $this->render('PolitikportalBundle:Default:topics.html.twig', $out);
    	
    	
    	$response->setPublic();
		$response->setMaxAge(60);
		$response->setSharedMaxAge(60);

    	$lastModified = new \DateTime();
    	$lastModified->createFromFormat('U',apc_fetch('homeLastModified'));
    	
    	$response->setLastModified($lastModified);
    	$response->isNotModified($this->getRequest());

    	return $response;    	
        
    }
    
	
	public function testCacheAction() {
	
		$response = new Response(date('r'));

		$response->setPublic();

		$response->setMaxAge(60);
		$response->setSharedMaxAge(60);

		return $response;
	
	}
        
    
}
