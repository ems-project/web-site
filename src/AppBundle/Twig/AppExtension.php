<?php
namespace AppBundle\Twig;

use AppBundle\Service\DataService;
use Elasticsearch\Client;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AppExtension extends \Twig_Extension
{
	/**@var DataService $data */
	private $data;
	/**@var Router $router*/
	private $router;
	/**@var \Twig_Environment $twig*/
	private $twig;
	/**@var RequestStack*/
	protected $requestStack;
	
	public function __construct(DataService $data, Router $router, \Twig_Environment $twig, RequestStack $requestStack) {
		$this->data = $data;
		$this->router = $router;
		$this->twig = $twig;
		$this->requestStack = $requestStack;
	}

	public function getName() {
		return 'app_extension';
	}
	
	public function getFilters() {
		return array(
				new \Twig_SimpleFilter('internal_links', array($this, 'internalLinks')),
				new \Twig_SimpleFilter('page', array($this, 'page')),
				new \Twig_SimpleFilter('page_by_slug', array($this, 'page_by_slug')),
		);
	}
	
	public function getFunctions() {
		return array(
				new \Twig_SimpleFunction('domain', array($this, 'domain')),
				new \Twig_SimpleFunction('data', array($this, 'data')),
				new \Twig_SimpleFunction('i18n', array($this, 'i18n')),
		);
	}
	
	function i18n($object, $key){
		if(isset($object[$key.'_'.$this->requestStack->getCurrentRequest()->getLocale()])){
			return $object[$key.'_'.$this->requestStack->getCurrentRequest()->getLocale()];
		}
		return $object[$key.'_en'];
	}
	function data($type, $key){
		return $this->data->getByOuuid($type, $key);
	}
	
	function internalLinks($input) {
		$out = $input;
		
		$out = preg_replace_callback( '/ems:\/\/object:page:([-_A-Za-z0-9]*)/i',
				function ($matches) {
					try {
						$result = $this->data->getByOuuid('page', $matches[1]);
						return $this->router->generate('page', ['slug' => $result['slug']]);
					}
					catch(\Exception $e){
						return $this->router->generate('page');
					}
				}, $out);
		
		$out = preg_replace_callback( '/ems:\/\/object:presentation:([-_A-Za-z0-9]*)/i',
				function ($matches) {
					try {
						$result = $this->data->getByOuuid('presentation', $matches[1]);
						return $this->router->generate('presentation', ['slug' => $result['slug']]);
					}
					catch(\Exception $e){
						return $this->router->generate('page');
					}
				}, $out);
		

		return $out;
	}
	
	function page($id) {
		try {
			return $this->data->getDataById('page', $id);
		}
		catch (NotFoundHttpException $e){
			return false;
		}
	}
	
	function domain() {
		return $this->data->getContext();
	}
	
	function page_by_slug($slug) {
		try {
			return $this->data->getDataBySlug('page', $slug);
		}
		catch (NotFoundHttpException $e){
			return false;
		}
	}
	
}