<?php

namespace AppBundle\Controller;

use AppBundle\Service\DataService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Elasticsearch\Client;

class AppController extends Controller
{
	/**
	 * @return DataService
	 */
	public function getDataService(){
		return $this->get('app.data');
	}
	
	/**
	 * @return Client
	 */
	public function getClient(){
		return $this->get('app.elasticsearch');
	}
}
