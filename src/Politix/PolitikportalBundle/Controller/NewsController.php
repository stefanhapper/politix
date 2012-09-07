<?php

namespace Politix\PolitikportalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class NewsController extends Controller {
  
  public function getLinkAction($id) {
    $NewsModel = $this->get('NewsModel');
    $url = $NewsModel->getLink($id);	
    return new RedirectResponse($url);
  }
    
}