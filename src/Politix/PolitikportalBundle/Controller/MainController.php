<?php

namespace Politix\PolitikportalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class MainController extends Controller {
    
    public function getHomepageAction() {
		
        $TopicModel = $this->get('TopicModel');
    	
    	$topics = $TopicModel->getHomepageTopics();
    	
    	$out['rows'][] = 'empty';

    	foreach ($topics as $topic) {
    	
    		$out['topics'][] = $TopicModel->getTopic($topic);
    	
    	}
    	
    	
    	$response = $this->render('PolitikportalBundle:Default:topics.html.twig', $out);
    	
    	
    	$response->setPublic();
		$response->setMaxAge(60);
		$response->setSharedMaxAge(60);

    	$lastModified = new \DateTime('yesterday');
    	
    	$response->setLastModified($lastModified);
    	$response->isNotModified($this->getRequest());

    	return $response;    	
        
    }
        
    
}
