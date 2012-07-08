<?php

namespace Politix\PolitikportalBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TopicController extends Controller {
    
  public function getTopicsAction() {
    $topics = $this->get('TopicModel');
    $out['rows'] = $topics->getHomepageTopics();
    return $this->render('PolitikportalBundle:Default:dump.html.twig', $out);
  }
  
  public function getTopicAction($topic) {
    $topics = $this->get('TopicModel');
    $topics->setPeriod(365);
    $id = $topics->getId($topic);
            
    $options['order'] = 'date';
    $options['parent'] = false;
     
    $out['topic']['items'] = $topics->getTopic($id, $options);
    $out['topic']['url'] = '';
    $out['topic']['title'] = $out['topic']['items'][0]['topicTitle'];
    
    $sources = $this->get('SourceModel');
    $out['partners'][] = $sources->getSource('wkoe',0,1);

    $out['heading'] = 'extra';

    return $this->render('PolitikportalBundle:Default:topic.html.twig', $out);
  }
    
}
