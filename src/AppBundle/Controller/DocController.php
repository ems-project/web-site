<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DocController extends AppController
{
// 	/**
// 	 * @Route("/doc", name="doc")
// 	 */
// 	public function docAction(Request $request)
// 	{
// 		return $this->render('pages/doc.html.twig', [
// 				'page' => $this->getDataService()->getDataById('page', 'doc')
// 		]);
// 	}
	/**
	 * @Route("/doc/templates/{slug}", name="doc.templates.view")
	 */
	public function viewTemplateAction($slug, Request $request)
	{
		$data = $this->getDataService()->getDataBySlug('template', $slug);
		return $this->render('doc/templates/view.html.twig', [
				'data' => $data,
				'slug' => $slug,
		]);
	}
	
// 	/**
// 	 * @Route("/doc/templates", name="doc.templates.index")
// 	 */
// 	public function indexTemplateAction(Request $request)
// 	{
// 		$templates = $this->getDataService()->getTemplates($request->getLocale());
// 		return $this->render('doc/templates/index.html.twig', [
// 				'templates' => $templates,
// 		]);
// 	}
	
	public function listTemplatesAction($slug = false, Request $request)
	{
		$templates = $this->getDataService()->getTemplates($request->getLocale());
		return $this->render('doc/templates/list.html.twig', [
				'templates' => $templates,
				'slug' => $slug,
		]);
	}
    
}
