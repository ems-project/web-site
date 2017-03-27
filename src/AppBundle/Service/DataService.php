<?php

namespace AppBundle\Service;

use Elasticsearch\Client;

/**
 * DataService.
 */
class DataService

{	
	/**@var Client */
	private $client;

	
	function __construct(Client $client) {
		$this->client = $client;
	}
	
	
	public function getFeatures($index){
		
		$body = '{
			   "query": {
			      "bool": {
			         "must": [
			            {
			               "term": {
			                  "promoted": {
			                     "value": "true",
			                     "boost": 1
			                  }
			               }
			            }
			         ]
			      }
			   },
			   "sort": {
			      "weight": {
			         "order": "asc",
			         "missing": "_last"
			      }
			   }
			}';
		
		return $this->client->search([
			'size' => 100,
			'type' => 'feature',
			'index' => $index,
			'body' => $body,
		]);
	}
	
	
	public function getDataBySlug($index, $type, $slug){
		
		$body = '{
			   "query": {
			      "bool": {
			         "must": [
			            {
			               "term": {
			                  "slug": {
			                     "value": '.json_encode($slug).',
			                     "boost": 1
			                  }
			               }
			            }
			         ]
			      }
			   }
			}';
		
		return $this->client->search([
			'size' => 1,
			'type' => $type,
			'index' => $index,
			'body' => $body,
		]);
	}
	
	
}