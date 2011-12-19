<?php

namespace App\Service\Blog\Member;

class Collection extends \PhpRestService\Resource\Collection\CollectionAbstract implements \PhpRestService\Resource\Collection\CollectionInterface {

    public function get() {
        $data = array(
            array (
                'id' => 1,
                'url' => 'http://'. $_SERVER['HTTP_HOST'] . '/blog/member/1',
                'username' => 'Dirk Engels',
                'email' => 'd.engels@dirkengels.com',
                'comments' => array(
                    array(
                        'id' => 1,
                        'url' => 'http://'. $_SERVER['HTTP_HOST'] . '/blog/post/1/comment/1',
                        'title' => 'Dirk Engels',
                        'date' => '18-12-2011 20:34:23',
                    ),
                ),
            ),
        );

        // Fill response
        return $data;
    }

}
