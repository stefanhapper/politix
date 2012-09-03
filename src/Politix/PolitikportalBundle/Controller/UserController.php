<?php

namespace Politix\PolitikportalBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller {
  
	function subscribeUserAction() {
	
    $escaper = new \Twig_Extension_Escaper(true);
    $log = $this->get('LogModel');
		$user = $this->get('UserModel');
    $request = $this->getRequest();
    $email = $request->get('email');
    	
    $back_link = '<br /><br /><a href="/">Zur Startseite</a>';
    	
    $out['type'] = '';
    	
    if (($email == '') or ($email == "Ihre Emailadresse ...")) {
	  	$out['type'] = 'warning';
			$out['title'] = "Achtung, Sie haben keine Emailadresse eingegeben!";
			$out['page'] = "Bitte versuchen Sie es erneut.";
			$log->write("[Newsletter] no email entered",1);
			return $this->render('PolitikportalBundle:Default:page.html.twig', $out);
    }
    	
    if (!$user->validEmail($email)) {
	    $out['type'] = 'warning';
			$out['title'] = "Ein Fehler ist aufgetreten";
			$out['page'] = "<strong>$email</strong> ist keine gültige Emailadresse!" . $back_link;
			$log->write("[Newsletter] invalid email entered: $email",2);
			return $this->render('PolitikportalBundle:Default:page.html.twig', $out);
    }

    if (!$user->verifyEmail($email)) {
	    $out['type'] = 'warning';
			$out['title'] = 'Ein Fehler ist aufgetreten';
			$out['page'] = "Die Emailadresse <strong>$email</strong> konnte nicht überprüft werden!<br />";
			$out['page'] .= "Wir bitten Sie, uns eine Email zu senden: <a href='mailto:info@politikportal.eu'>info@politikportal.eu</a>" . $back_link;
			$log->write("[Newsletter] Email could not be verified: $email",2);
			return $this->render('PolitikportalBundle:Default:page.html.twig', $out);
    }

		if ($user->existingEmail($email)) {
	    $out['type'] = 'warning';
			$out['title'] = "Fehler: Emailadresse bereits angemeldet!";
			$out['page']  = "Die Emailadresse <strong>$email</strong> existiert bereits in unserer Verteilerliste!<br /><br />";
			$out['page'] .= "Für eine etwaige Abbestellung des Newsletters oder sonstige Fragen zum Newsletter schreiben Sie uns bitte eine Email an <a href='mailto:info@politikportal.eu'>info@politikportal.eu</a>" . $back_link;
			$log->write("[Newsletter] tried to subscribe existing email: $email",1);
			return $this->render('PolitikportalBundle:Default:page.html.twig', $out);
		}

		if ($user->addEmail($email)) {
			$out['title'] = "Anmeldung erfolgreich";
			$out['page']  = "Vielen Dank für Ihre Anmeldung! Sie erhalten in Kürze eine Bestätigungsemail.<br /><br />";
			$out['page'] .= "Sie können sich jederzeit wieder abmelden. Eine Email an <a href='mailto:info@politikportal.eu'>info@politikportal.eu</a> genügt" . $back_link;
			$log->write("[Newsletter] new subscriber: $email",0);
			return $this->render('PolitikportalBundle:Default:page.html.twig', $out);		
		} else {
			$out['title'] = "Ein Fehler ist aufgetreten";
			$out['page']  = "Die Anmeldung war leider nicht erfolgreich.<br /><br />";
			$out['page'] .= "Wir bitten Sie, uns eine Email zu senden: <a href='mailto:info@politikportal.eu'>info@politikportal.eu</a>" . $back_link;
			$log->write("[Newsletter] could not add email to subscribers: $email",3);
			return $this->render('PolitikportalBundle:Default:page.html.twig', $out);				
		}
		
	}
        
}
