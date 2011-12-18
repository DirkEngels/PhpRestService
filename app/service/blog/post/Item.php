<?php

namespace App\Service\Blog\Post;

class Item extends \PhpRestService\Resource\Item\ItemAbstract implements \PhpRestService\Resource\Item\ItemInterface {

    public function get() {
        $data = array (
            'id' => 34,
            'url' => '/task/34',
            'date' => '18-12-2011 20:34:23',
            'title' => 'First blog post',
            'content' => 'This is the blog post content',
        );

        // Fill response
        return $data;
    }

    public function post() {
        
    }

}
