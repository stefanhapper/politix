<?php

namespace Politix\PolitikportalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;

class NewsController extends Controller {
  
  var $id;
  var $url;
  var $querystring;
  var $subscriber;
  var $request;
  var $cookie;
  var $model;
  
  function __construct() {
    $this->request = Request::createFromGlobals();
    if ($this->request->cookies->get('i')) {
      $subscriber = $this->request->cookies->get('i');
    }
  }
  
  public function gotoNewsAction($querystring) {
    $this->model = $this->get('NewsModel');
    $this->querystring = $querystring;
    $this->getQueryParams();
    $this->setSubscriberCookie();
    $this->getLink();
    return $this->createResponse();
  }
  
  public function getQueryParams() {
    if (strstr($this->querystring,'O')) {
      $queryParams = explode('O',$this->querystring);
      $this->subscriber = $queryParams[0];
      $this->id = $queryParams[1];
    } else {
      $this->id = $this->querystring;
    }
  }
  
  public function setSubscriberCookie() {
    if ($this->subscriber) {
      $this->cookie = new Cookie('i',$this->subscriber,time()+60*60*24*999,'/','.politikportal.eu');
    }
  }
  
  public function getLink() {
    $this->url = $this->model->getLink($this->id);
  }
   
  public function createResponse() {
    if ($this->url) {
      $p = 0;
      $this->model->saveClick($this->id,$this->url,$this->subscriber,$p,0);
      $response = new RedirectResponse($this->url);
      if ($this->cookie) $response->headers->setCookie($this->cookie);
      $response->headers->set('cache-control','no-cache, no-store, must-revalidate');
    } else {
      throw $this->createNotFoundException('Der Artikel konnte nicht gefunden werden');
    }
    return $response;
  }
   
}