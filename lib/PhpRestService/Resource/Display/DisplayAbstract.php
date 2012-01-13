<?php

namespace PhpRestService\Resource\Display;
use \PhpRestService\Resource\Component;
use \PhpRestService\Logger;

abstract class DisplayAbstract extends Component\ComponentAbstract {

    protected $_url;

    public function getUrl() {
        if (is_null($this->_url)) {
            $this->_url = $_SERVER['REQUEST_URI'];
        }
        return $this->_url;
        
    }

    public function setUrl($url) {
        if (!preg_match('/^http:\/\//', $url)) {
            $url = 'http://' . $url;
        }
        if (substr($url, -1) == '/') {
            $url = substr($url, 0, strlen($url)-1);
        }

        $this->_url = $url;
        return $this;
    }

    public function dataUrl($object) {
        $data = array();
        if (method_exists($object, 'getId')) {
            $id = $object->getId();
            $url = $this->getUrl();
            if (!preg_match('/http:\/\//', $url)) {
                $url = 'http://' . $_SERVER['SERVER_NAME'] . $url;
            }

            if (isset($id)) {
                $url .= '/' . $id;
                $data = array (
                    'id' => $object->getId(),
                    'url' => $url,
                );
            }
        }
        return $data;
    }

    public function displayItem($object, $extended = false) {
        // Basic data
        $data = $this->dataBasic($object);

        if ($extended) {
            $data = array_merge($data, $this->dataExtended($object));
        } else {
            $data = array_merge($data, $this->dataUrl($object));
        }

        return $data;
    }

    public function dataExtended($object) {
        return array();
    }

    public function displayCollection($objects, $extended = false) {
        $data = array();
        if (is_array($objects)) {
            foreach($objects as $object) {
                $data[] = $this->displayItem($object, $extended);
            }
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

    public function handle($inputData = array(), $extended = NULL) {
        if ($this->getId()) {
            $extended = (!is_null($extended)) ? $extended : TRUE;
            $display = $this->displayItem($inputData, $extended);
        } else {
            $extended = (!is_null($extended)) ? $extended : FALSE;
            $display = $this->displayCollection($inputData, $extended);
        }
        return $display;
    }

}
