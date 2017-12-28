<?php 
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
	/**
	 * @Route("/")
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function homepage()
    {
        return $this->render('pages/homepage.html.twig', array(
        ));
    }
}