<?php

namespace AppBundle\Service;

use Elasticsearch\Client;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * DataService.
 */
class DataService

{	
	/**@var Client */
	private $client;
	
	/**@var RequestStack*/
	protected $requestStack;
	
	function __construct(Client $client, RequestStack $requestStack, $indexPrefix) {
		$this->client = $client;
		$this->requestStack = $requestStack;
		$this->indexPrefix = $indexPrefix;
	}
	
	
	public function getFeatures(){
		
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
			'index' => $this->getIndex(),
			'body' => $body,
		]);
	}
	
	
	
	
	public function getTemplates(){
		
		$body = '{
				"sort": {
			      "short_title_'.$this->requestStack->getCurrentRequest()->getLocale().'.raw": {
			         "order": "asc",
			         "missing": "_last"
			      }
			   }
			}';
		
		return $this->client->search([
				'size' => 100,
				'type' => 'template',
				'index' => $this->getIndex(),
				'body' => $body,
		]);
	}
	
	public function getByOuuid($type, $ouuid) {
		try {
			$result = $this->client->get([
					'id' => $ouuid,
					'index' => $this->getIndex(),
					'type' => $type,
			]);		
			return $result['_source'];
		}
		catch (\Exception $e) {
			throw new NotFoundHttpException($type.' not found');
		}
	}
	
	public function getDataById($type, $id){
		
		$body = '{
			   "query": {
			      "bool": {
			         "must": [
			            {
			               "term": {
			                  "id": {
			                     "value": '.json_encode($id).',
			                     "boost": 1
			                  }
			               }
			            }
			         ]
			      }
			   }
			}';
		
		$data = $this->client->search([
				'size' => 1,
				'type' => $type,
				'index' => $this->getIndex(),
				'body' => $body,
		]);
		
		if($data['hits']['total'] != 1){
			throw new NotFoundHttpException($type.' not found');
		}
		
		return $data['hits']['hits'][0]['_source'];
	}
	
	public function getIndex() {
		return $this->indexPrefix.$this->getContext();
	}
	
	public function getContext() {
		// 		dump($this->requestStack->getCurrentRequest()->getHost());
		return 'preview';
	}
	
	public function getDataBySlug($type, $slug){
		
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
		
		$data = $this->client->search([
				'size' => 1,
				'type' => $type,
				'index' => $this->getIndex(),
				'body' => $body,
		]);
		
		if($data['hits']['total'] != 1){
			throw new NotFoundHttpException($type.' not found');
		}
		
		return $data['hits']['hits'][0]['_source'];
	}
	
	
}