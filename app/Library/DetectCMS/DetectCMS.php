<?php
namespace App\Library\DetectCMS;

use App\Library\DetectCMS\Systems\Drupal;
use App\Library\DetectCMS\Systems\ExpressionEngine;
use App\Library\DetectCMS\Systems\Joomla;
use App\Library\DetectCMS\Systems\Liferay;
use App\Library\DetectCMS\Systems\Magento;
use App\Library\DetectCMS\Systems\Sitecore;
use App\Library\DetectCMS\Systems\Typo3;
use App\Library\DetectCMS\Systems\vBulletin;
use App\Library\DetectCMS\Systems\Wordpress;

class DetectCMS {

	public $systems = array(
	    "App\Library\DetectCMS\Systems\Drupal",
        "App\Library\DetectCMS\Systems\Wordpress",
        "App\Library\DetectCMS\Systems\Joomla",
        "App\Library\DetectCMS\Systems\Liferay",
        "App\Library\DetectCMS\Systems\VBulletin",
        "App\Library\DetectCMS\Systems\Magento",
        "App\Library\DetectCMS\Systems\ExpressionEngine",
        "App\Library\DetectCMS\Systems\Sitecore",
        "App\Library\DetectCMS\Systems\Typo3"
    );

	private $common_methods = array("generator_header","generator_meta");

	public $home_html = "";

	public $home_headers = array();

	public $url = "";
	
	public $result = FALSE;

	function __construct($url) {
		$this->url = $url;
		list($this->home_headers, $this->home_html) = $this->fetchBodyAndHeaders();
		$this->result = $this->check($url);
	}

	public function check() {

		/*
		 * Common, easy way first: check for Generator metatags or Generator headers
		 */
				
		foreach($this->systems as $system_name) {

			$system = new $system_name($this->home_html, $this->home_headers, $this->url);

			foreach($this->common_methods as $method) {

				if(method_exists($system,$method)) {

					if($system->$method()) {
                        return $system->identifier;
                    }
				}

			}

		}

		/*
		 * Didn't find it yet, let's just use regular tricks
		 */

		foreach($this->systems as $system_name) {

            $system = new $system_name($this->home_html, $this->home_headers, $this->url);

			foreach($system->methods as $method) {

				if(!in_array($method,$this->common_methods)) {

					if($system->$method()) {
						return $system->identifier;
					}

				}

			}

		}

		return FALSE;

	}

	public function getResult() {

        header('Content-Type: application/json');

        $id     = null;
        $name   = null;
        if ($this->result) {
            $id     = $this->result;
            $name   = config('constants.cms')[$this->result];
        }

        $return     = [
            'cms'   => $name,
            'id'    => $id,
            'url'   => $this->url
        ];

        return      json_encode($return);
	}

	protected function fetch($url=null) {

		$ch = curl_init();

		if($url==null) {
			$url = $this->url;
		}
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);

		$return = curl_exec($ch);

		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if($httpCode == 404) {
			curl_close($ch);
			return FALSE;
		}

		curl_close($ch);
	
		return $return;

	}

	protected function fetchBodyAndHeaders() {

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_HEADER, 1);

		$response = curl_exec($ch);

		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if($httpCode == 404) {
	    curl_close($ch);
	    return FALSE;
		}

		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($response, 0, $header_size);
		$body = substr($response, $header_size);

		$header_array = array();

		foreach (explode("\r\n", $header) as $i => $line) {
			if ($i === 0) {
			$header_array['http_code'] = $line;
	    } else {
	    	@list ($key, $value) = explode(': ', $line);
	     	$header_array[$key] = $value;
	    }

		}

		curl_close($ch);

		return array($header_array, $body);		

	}

}
