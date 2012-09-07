<?php

namespace Politix\PolitikportalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MainController extends Controller {
	
	var $response = FALSE;
	
	function __construct() {
		$this->response = new Response();
	  $this->response->setPublic();
 // $this->response->setMaxAge(60);
 // $this->response->setSharedMaxAge(60);
		$this->apc = function_exists('apc_fetch');
		
    $this->response->headers->set('X-UA-Compatible', 'IE=edge,chrome=1');

	}
    
  public function getHomepageAction() {
		
		if (($this->apc) && (apc_fetch('homeLastModified'))) {
			$ApcLastModified = apc_fetch('homeLastModified');
		} else {
			$ApcLastModified = time();
			if ($this->apc) apc_store('homeLastModified',time());
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
    
    $TopicModel = $this->get('TopicModel');
    $topics = $TopicModel->getHomepageTopics();	
    $out['topics'] = array();
    foreach ($topics as $topic) {
    	if ($items = $TopicModel->getTopic($topic)) {
    	  $out['topics']['topic'.$topic['id']]['items'] = $items;
    		$out['topics']['topic'.$topic['id']]['title'] = $topic['title_at'];
    		$out['topics']['topic'.$topic['id']]['url'] = $topic['topicUrl'];
    	}
    }
    
    $sources = $this->get('SourceModel');
    $out['partners'][] = $sources->getSource('wkoe',0,1);
    $this->response->setContent($this->renderView('PolitikportalBundle:Default:topics.html.twig', $out));
    return $this->response;    
  }        


  public function getImpressumAction() {
    $this->response->setContent($this->renderView('PolitikportalBundle:Default:about.html.twig'));
    return $this->response;    
  }
  
  public function getNewsAction() {
    return new RedirectResponse('http://www.google.com');
  }
    
}
