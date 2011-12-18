<?php

namespace App\Service\Daemon\Single\Daemon;

class Collection 
extends \PhpRestService\Resource\Collection\CollectionAbstract implements \PhpRestService\Resource\Collection\CollectionInterface {

    public function get() {
        $data = array(
            'pid' => 12,
            'tasks' => array(
                array (
                    'id' => 34,
                    'url' => 'http://'. $_SERVER['HTTP_HOST'] . '/task/34',
                    'name' => 'Tutorial\\Simple',
                    'manager' => 'Same',
                    'ipc' => 'None',
                ),
                array (
                    'id' => 35,
                    'url' => 'http://'. $_SERVER['HTTP_HOST'] . '/task/35',
                    'name' => 'Tutorial\\Advanced',
                    'manager' => 'Parallel',
                    'ipc' => 'DataBase',
                ),
            ),
        );

        // Fill response
        return $data;
    }

}
