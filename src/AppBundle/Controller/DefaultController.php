<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends AppController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', [
            'features' => $this->getDataService()->getFeatures($this->getIndex()),
        ]);
    }
    
    
    /**
     * @Route("/{type}/{slug}", name="data")
     */
    public function dataAction($type, $slug, Request $request)
    {
    	$data = $this->getDataService()->getDataBySlug($this->getIndex(), $type, $slug);
    	
    	if($data['hits']['total'] != 1){
    		throw new NotFoundHttpException();
    	}
    	
        return $this->render('type/'.$type.'.html.twig', [
        	'data' => $data['hits']['hits'][0],
        ]);
    }
}
