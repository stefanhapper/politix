<?php

namespace Politix\PolitikportalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class NewsController extends Controller {
  
  public function getLinkAction($id) {
    $NewsModel = $this->get('NewsModel');
    $url = $NewsModel->getLink($id);
    if ($url) {
      $response = new RedirectResponse($url);
      $response->headers->set('cache-control','no-cache, no-store, must-revalidate');
    } else {
      throw $this->createNotFoundException('Der Artikel konnte nicht gefunden werden');
    }
    return $response;
  }
    
}