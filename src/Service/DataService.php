<?php
namespace App\Service;



use EMS\ClientHelperBundle\EMSBackendBridgeBundle\Elasticsearch\ClientRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DataService
{
	
	
	/**@var ClientRequest*/
	private $clientRequest;
	
	const PAGE_TYPE = 'page';
	
	
	/**
	 * 
	 * @param ClientRequest $clientRequest
	 */
	public function __construct(ClientRequest $clientRequest) {
		$this->clientRequest = $clientRequest;
	}
	
	/**
	 * Get a page object from its url
	 * @param string $url
	 */
	public function getPageByUrl(string $url) {
		
		$locale = $this->clientRequest->getLocale();
		
		$body = sprintf('{"query":{"bool":{"must":[{"term":{"url_en":{"value":"%s","boost":1}}}]}}}', 
				'welcome-to-elasticms');
		
		try {
			$page = $this->clientRequest->searchOne(self::PAGE_TYPE, json_decode($body, true));
			return $page;
		}
		catch (\EMS\ClientHelperBundle\EMSBackendBridgeBundle\Exception\ObjectNotFoundException $e) {
			throw new NotFoundHttpException('Page not found');
		}
	}
}