<?php
namespace AppBundle\Translation;

use Elasticsearch\Client;
use Symfony\Component\Translation\Loader\LoaderInterface;
use Symfony\Component\Translation\MessageCatalogue;

class ElasticLoader implements LoaderInterface
{
	/** @var Client $client*/
	protected $client;
	protected $type;
	protected $index;
	
	public function __construct(Client $client, $type, $prefix){
		$this->client = $client;
		$this->type = $type;
		$this->prefix = $prefix;
	}
	
	
	public function load($resource, $locale, $domain = 'messages'){
		
		$catalogue = new MessageCatalogue($locale);
		
// 		echo 'Load translation for domain: '.$domain.' and language '.$locale;
		
		$pageSize = 100;
		
		$param = [
			'preference' => '_primary', //http://stackoverflow.com/questions/10836142/elasticsearch-duplicate-results-with-paging
			'from' => 0,
			'size' => 0,
			'index' => $this->prefix.$domain,
			'type' => $this->type,
		];
		
		
// 		$messages = ['environment' => $keys[1]];
// 		if($keys[1] == 'live'){
// 			$messages['title_prefix'] = '';
// 		}
// 		else {
// 			$messages['title_prefix'] = '!!!'.strtoupper($keys[1]).'!!!';
// 		}
// 		$catalogue->add($messages, $domain);
		

		$result = $this->client->search($param);
		$total = $result["hits"]["total"];
		
		$param['size'] = $pageSize;
		while($param['from'] < $total){
			$result = $this->client->search($param);
			$messages = [];
			foreach ($result["hits"]["hits"] as $data){
				if(isset($data['_source']['label_'.$locale])){
					$messages[$data['_source']['id']] = $data['_source']['label_'.$locale];				
				}
			}
			$catalogue->add($messages, $domain);
			$param['from'] += $pageSize;
		}
		
		return $catalogue;
	}
}