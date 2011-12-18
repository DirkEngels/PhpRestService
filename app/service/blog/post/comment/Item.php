<?php

namespace App\Service\Blog\Post\Comment;

class Item extends \PhpRestService\Resource\Item\ItemAbstract implements \PhpRestService\Resource\Item\ItemInterface {

    public function get() {
        $data = array (
            'id' => 34,
            'url' => '/task/34',
            'postId' => 1,
            'postUrl' => '/blog/post/1',
            'date' => '18-12-2011 20:34:23',
            'author' => 'Dirk Engels',
            'content' => 'This is a comment',
        );

        // Fill response
        return $data;
    }

    public function post() {
        
    }

}
