<?php 
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
    
    
    
    
    /**
     * @Route("/{token}", name="page", requirements={"token"=".+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function page()
    {
    	
    	return $this->render('pages/page.html.twig', array(
    	));
    }
}