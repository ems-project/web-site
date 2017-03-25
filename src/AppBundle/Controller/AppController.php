<?php

namespace AppBundle\Controller;

use AppBundle\Service\DataService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppController extends Controller
{
	/**
	 * @return DataService
	 */
	public function getDataService(){
		return $this->get('app.data');
	}
	
	public function getIndex() {
		return 'emseu_preview';
	}
}
