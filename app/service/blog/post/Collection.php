<?php

namespace App\Service\Blog\Post;

class Collection extends \PhpRestService\Resource\Collection\CollectionAbstract implements \PhpRestService\Resource\Collection\CollectionInterface {

    public function get() {
        $data = array(
            array (
                'id' => 2,
                'url' => 'http://'. $_SERVER['HTTP_HOST'] . '/blog/post/2',
                'title' => 'Second blog post',
                'date' => '19-12-2011 18:34:23',
            ),
            array (
                'id' => 1,
                'url' => 'http://'. $_SERVER['HTTP_HOST'] . '/blog/post/1',
                'title' => 'First blog post',
                'date' => '18-12-2011 20:34:23',
            ),
        );

        // Fill response
        return $data;
    }

}
