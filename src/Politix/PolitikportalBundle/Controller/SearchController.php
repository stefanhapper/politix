<?php

namespace Politix\PolitikportalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller {
    
  public function queryAction() {
    $request = $this->getRequest();
    $q = $request->query->get('q');
    $this->model = $this->get('SearchModel');
    $query = '+' . implode(' +',explode(' ',$q));
    $out['topic']['items'] = $this->model->searchNews($query);
    $out['topic']['url'] = '';
    $out['topic']['title'] = $this->formatTitle(count($out['topic']['items']));
    $out['heading'] = count($out['topic']['items']) . $query;
    $sources = $this->get('SourceModel');
    $out['partners'][] = $sources->getSource('wkoe',0,1);
    return $this->render('PolitikportalBundle:Default:topic.html.twig', $out);   
  }
  
  public function formatTitle($count) {
    if ($count > 500) return 'Mehr als 500 Suchergebnisse';
    if ($count == 0) return '0 Suchergebnisse';
    if ($count == 1) return '1 Suchergebnis';
    return $count . ' Suchergebnisse';
  }

}