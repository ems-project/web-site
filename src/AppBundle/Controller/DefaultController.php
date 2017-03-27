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
     * @Route("/features/{slug}", name="features")
     */
    public function featureAction($slug, Request $request)
    {
    	$index = $this->getIndex();
    	$data = $this->getDataService()->getDataBySlug($index, 'feature', $slug);
    	
    	if($data['hits']['total'] != 1){
    		throw new NotFoundHttpException();
    	}
    	
    	$features = $this->getDataService()->getFeatures($index);
    	
        return $this->render('type/feature.html.twig', [
        	'data' => $data['hits']['hits'][0],
        	'features' => $features,
        ]);
    }
}
