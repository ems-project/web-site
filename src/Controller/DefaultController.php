<?php 
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\DataService;

class DefaultController extends Controller
{
	
	/**
	 * @Route("/", name="homepage")
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function homepage()
    {
        return $this->render('pages/homepage.html.twig', array(
        ));
    }
    
    
    public function menu($depth, DataService $dataService)
    {
    	return $this->render('elements/navbar.html.twig', array(
    			'menu' => $dataService->getMenu($depth),
    	));
    }
    
    
    
    /**
     * @Route("/{token}", name="page", requirements={"token"=".+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function page($token, DataService $dataService)
    {
    	return $this->render('pages/page.html.twig', array(
    			'page' => $dataService->getPageByUrl($token),
    	));
    }
}