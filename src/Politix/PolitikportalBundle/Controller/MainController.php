<?php

namespace Politix\PolitikportalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class MainController extends Controller {
    
    public function getHomepageAction() {
		
        $TopicModel = $this->get('TopicModel');
    	
    	$topics = $TopicModel->getHomepageTopics();
    	
    	$out['rows'][] = 'empty';

    	foreach ($topics as $topic) {
    	
    		$out['rows'][] = $TopicModel->getTopic($topic);
    	
    	}
    	
    	
    	return $this->render('PolitikportalBundle:Default:dump.html.twig', $out);
        
    }
        
    
}
