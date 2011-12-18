<?php

namespace App\Service\Daemon\Combined\Daemon;
use \PhpRestService\Resource\Collection;
use \PhpRestService\Resource\Item;

class Collection extends Collection\CollectionAbstract implements Collection\CollectionInterface {

    public function get() {
        $data = array(
            'pid' => 12,
            'tasks' => array(
                array (
                    'id' => 34,
                    'url' => '/task/34',
                    'name' => 'Tutorial\\Simple',
                    'manager' => 'Same',
                    'ipc' => 'None',
                ),
                array (
                    'id' => 35,
                    'url' => '/task/35',
                    'name' => 'Tutorial\\Advanced',
                    'manager' => 'Parallel',
                    'ipc' => 'DataBase',
                ),
            ),
        );

        return $data;
    }

}
