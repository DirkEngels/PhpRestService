<?php

namespace App\Service\Blog\Post\Comment;

class Collection extends \PhpRestService\Resource\Collection\CollectionAbstract implements \PhpRestService\Resource\Collection\CollectionInterface {

    public function get() {
        $data = array(
            array (
                'id' => 2,
                'url' => 'http://'. $_SERVER['HTTP_HOST'] . '/blog/post/2/comment/2',
                'author' => 'Anonymous',
                'date' => '19-12-2011 18:34:23',
            ),
            array (
                'id' => 1,
                'url' => 'http://'. $_SERVER['HTTP_HOST'] . '/blog/post/1/comment/1',
                'title' => 'Dirk Engels',
                'date' => '18-12-2011 20:34:23',
            ),
        );

        // Fill response
        return $data;
    }

}
