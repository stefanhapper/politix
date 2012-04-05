<?php

namespace Politix\PolitikportalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class TopicController extends Controller {
    
    public function getTopicsAction() {
		
        $topics = $this->get('TopicModel');
    	
    	$out['rows'] = $topics->getHomepageTopics();
    	
    	return $this->render('PolitikportalBundle:Default:dump.html.twig', $out);
        
    }
    
    

        
    
}
