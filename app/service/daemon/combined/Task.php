<?php

namespace App\Service\Daemon\Combined\Task;
use \PhpRestService\Resource\Item;

class Item extends Item\ItemAbstract implements Item\ItemInterface {

    public function get() {
        $data = array (
            'id' => 34,
            'url' => '/task/34',
            'name' => 'Tutorial\\Adnvaced',
            'manager' => 'Parallel',
            'ipc' => 'None',
            'mem' => 65535,
            'statistics' => array(
                'done' => 12,
                'failed' => 0,
                'queued' => 2,
                'loaded' => 3,
            ),
            'executors' => array(
                array(
                    'id' => 56,
                    'url' => '/job/56',
                    'memory' => 65535,
                    'percentage' => 0,
                    'message' => 'Initializing task',
                ),
                array(
                    'id' => 57,
                    'url' => '/job/57',
                    'memory' => 65535,
                    'percentage' => 90,
                    'message' => 'Almost done',
                ),
            ),
        );

        return $data;
    }

    public function post() {
    }

}
