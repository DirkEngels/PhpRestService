<?php

namespace PhpRestService\Resource\Display;

use PhpRestService\Config;

use \PhpRestService\Resource\Component;
use \PhpRestService\Logger;

abstract class DisplayAbstract extends Component\ComponentAbstract {

    const URL = '';

    protected $_url;

    public function getUrl() {
        $class = get_class( $this );
        if ( is_null( $this->_url ) && $class::URL != '' ) {
            $this->_url = 'http://' . $_SERVER['HTTP_HOST'] . $class::URL;
        }
        if (is_null($this->_url)) {
            $this->setUrl('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        }
        return $this->_url;
        
    }

    public function setUrl($url) {
        // Strip last slash
        if (substr($url, -1) == '/') {
            $url = substr($url, 0, strlen($url)-1);
        }
        // Verify absolute path
        if (substr($url, 0, 1) == '/') {
            $url = $_SERVER['HTTP_HOST'] . $url;
        }
        // Verify begins with http://
        if (!preg_match('/^http:\/\//', $url)) {
            $url = 'http://' . $url;
        }

        $this->_url = $url;
        return $this;
    }

    public function dataUrl($object, $url = NULL) {
        if (!is_null($url)) {
            $this->setUrl($url);
        }
        $url = $this->getUrl();

        // Remove everything after the '?'.
        if ( strpos( $url , '?' ) ) {
            $url = substr( $url, 0, strpos( $url , '?' ) );
        }

        $data = array();
        if (method_exists($object, 'getId')) {
            $id = $object->getId();
            if (isset($id)) {
                $url .= '/' . $id;
                $data = array (
                    'id' => $object->getId(),
                    'link' => $url,
                );
            }
        }
        return $data;
    }

    /**
     * 
     * @param Object $object
     * @param boolena $extended
     * @param string $url
     * @return array
     */
    public function displayItem($object, $extended = false, $url = true) {
        // Basic data
        $data = $this->dataBasic($object);

        if (is_array($data)) {
            if ($extended) {
                $data = array_merge($data, $this->dataExtended($object));
            }

            if ($url) {
                $data = array_merge($data, $this->dataUrl($object));
            }
        }

        return $data;
    }

    public function dataExtended($object) {
        return array();
    }

    public function displayCollection($objects, $extended = false, $url = NULL) {
        $data = array();

        if ( is_array($objects) || get_class($objects) == 'Doctrine\ORM\PersistentCollection') {
            foreach($objects as $key => $object) {
                if ( ! method_exists($object, 'getId')) {
                    $msg = "Displaying item: " . get_class($object) . ' without ID';
                } else {
                    $msg = "Displaying item: " . get_class($object) . ' => ' . $object->getId();
                }
                Logger::log( $msg, \Zend_Log::DEBUG );

                if ( preg_match( '/[a-zA-Z0-9]+/', $key ) ) {
                    $data[ $key ] = $this->displayItem($object, $extended, $url);
                } else {
                    array_push($data, $this->displayItem($object, $extended, $url) );
                }
            }
        } elseif ( is_object( $objects ) ) {
            $data = $this->displayItem( $objects );
        } else {
            Logger::log("Error display items", \Zend_Log::DEBUG);
        }
        return $data;
    }

    public function dataRelation($displayClass, $objects, $url = NULL) {
        $data = array();
        $display = new $displayClass();
        if (!is_null($url)) {
            $display->setUrl($url);
        }
        foreach($objects as $object) {
            // Verify that these objects are indeed objects!
            if (!is_object($object)) {
                continue;
            }

            $dataBasic = $display->dataBasic($object);
            $dataUrl = (!is_null($url)) ? $display->dataUrl($object) : array();
            $data[] = array_merge($dataUrl, $dataBasic);
        }
        return $data;
    }


    public function dataMeta( $object ) {
        return ( $_REQUEST['meta'] == 1 ) ? $this->dataMeta() : array();
    }


    public function handle($inputData = array(), $extended = NULL) {
        $display = $this->dataMeta();

        if ($this->getId()) {
            $extended = (!is_null($extended)) ? $extended : TRUE;
            $display = $this->displayItem($inputData, $extended);
        } else {
            $extended = (!is_null($extended)) ? $extended : FALSE;
            $display = $this->displayCollection($inputData, $extended);
        }
        return $display;
    }

    protected function _isObject( $object ) {
        if (!is_object($object)) {
            throw new \Exception('Display input is not an object!', 404);
        }
    }

}

