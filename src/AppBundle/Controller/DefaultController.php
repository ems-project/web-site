<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class DefaultController extends AppController
{
    
    /**
     * @Route("/presentation/{slug}", name="presentation")
     */
    public function presentationAction($slug, Request $request)
    {	
        return $this->render('type/presentation.html.twig', [
        		'data' => $this->getDataService()->getDataBySlug('presentation', $slug),
        ]);
    }
    
    
    /**
     * @Route("/features/{slug}", name="feature")
     */
    public function featureAction($slug, Request $request)
    {
    	$data = $this->getDataService()->getDataBySlug('feature', $slug);
    	
        return $this->render('features/view.html.twig', [
        	'data' => $data,
        ]);
    }
    
    
//     /**
//      * @Route("/features", name="features")
//      */
//     public function featuresAction(Request $request)
//     {
//     	return $this->render('features/index.html.twig', [
//     		'features' => $this->getDataService()->getFeatures(),
//         ]);
//     }
    
    public function listFeaturesAction($slug = false, $marketing=false, Request $request)
    {
    	$features = $this->getDataService()->getFeatures();
    	return $this->render($marketing?'features/marketing.html.twig':'features/list.html.twig', [
    			'features' => $features,
    			'slug' => $slug,
    	]);
    }
    
    /**
     * @Route("/downloads/{sha1}/{mimetype}/{filename}", name="download")
     */
    public function downloadAction($sha1, $mimetype, $filename, Request $request) {
    	$path = $this->getParameter('storage_path').'/'.substr($sha1, 0, 3).'/'.$sha1;
    	$response = new BinaryFileResponse($path);
    	$response->headers->set('Content-Type', $mimetype);
    	$response->setContentDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $filename);
    	return $response;
    }
}
