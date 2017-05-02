<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ZeController extends AppController
{
    
    /**
     * @Route("/{slug}", defaults={"slug": "home"}, requirements={"slug": ".+"}, name="page")
     */
    public function pageAction($slug, $_locale, Request $request)
    {
    	if($_locale != 'en' and $_locale != ""){
    		return $this->render('pages/missing.html.twig', [
    				'data' => $this->getDataService()->getDataBySlug('page', $slug),
    		]);
    	}
    	return $this->render('pages/page.html.twig', [
    			'data' => $this->getDataService()->getDataBySlug('page', $slug),
        ]);
    }
}
