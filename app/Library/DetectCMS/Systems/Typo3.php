<?php
namespace App\Library\DetectCMS\Systems;

use App\Library\DetectCMS\DetectCMS;

class Typo3 extends DetectCMS {

    public $identifier  = 'typo3';

	public $methods = array(
		"generator_header",
		"description",
		"scripts"
	);

	public $home_html = "";
        public $home_headers = array();
	public $url = "";

        function __construct($home_html, $home_headers, $url) {
                $this->home_html = $home_html;
                $this->home_headers = $home_headers;
                $this->url = $url;
        }


	/**
	 * Check for Generator header
	 * @return [boolean]
	 */
	public function generator_header() {

		if(is_array($this->home_headers)) {

			foreach($this->home_headers as $line) {

				if(strpos($line, "X-Generator") !== FALSE) {

					return strpos($line, "Typo3") !== FALSE;

				}

			}

		}

		return FALSE;

	}

    /**
     * Check for Typo3 Description
     * @return [boolean]
     */
    public function description() {

        if($this->home_html) {

            require_once(dirname(__FILE__)."/../thirdparty/simple_html_dom.php");

            if($html = str_get_html($this->home_html)) {

                if (strpos($html, 'This website is powered by TYPO3') !==FALSE)
                    return true;

            }

        }

        return FALSE;

    }

    /**
     * Check for Typo3 Core scripts
     * @return [boolean]
     */
    public function scripts() {

        if($this->home_html) {

            require_once(dirname(__FILE__)."/../thirdparty/simple_html_dom.php");

            if($html = str_get_html($this->home_html)) {

                foreach($html->find('link') as $element) {
                    if (strpos($element->src, 'typo3temp') !==FALSE)
                        return true;
                }

                foreach($html->find('img') as $element) {
                    if (strpos($element->src, 'typo3temp') !==FALSE)
                        return true;
                }

            }

        }

        return FALSE;

    }

}
