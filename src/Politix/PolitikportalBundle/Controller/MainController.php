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
    	
    	
    	return $this->render('PolitikportalBundle:Default:topics.html.twig', $out);
        
    }
        
    
}
