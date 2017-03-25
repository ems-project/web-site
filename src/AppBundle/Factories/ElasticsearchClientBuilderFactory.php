<?php

namespace AppBundle\Factories;

use Elasticsearch\ClientBuilder;
use Elasticsearch\Client;

/**
 * elasticSearch Factory.
 */
class ElasticsearchClientBuilderFactory

{	

	/**
     * @return Client
	 */
	public static function build($hosts){
		$params = [];
		
		if (isset($hosts)){
			$params['hosts'] = $hosts;
		}
		
		
		return ClientBuilder::fromConfig($params);
	}
}