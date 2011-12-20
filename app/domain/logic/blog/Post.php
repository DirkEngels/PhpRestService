<?php

namespace App\Domain\Logic;

class Post {

    public function write($data) {
        
    }

    public function load() {
        $entityManager = \Zend_Registry::get('entityManager');
        $posts = $entityManager->getRepository('\App\Domain\Model\Blog\Post')->findBy(array());
        return $posts;
    }

    public function find($id) {
        $entityManager = \Zend_Registry::get('entityManager');
        $post = $entityManager->find('\App\Domain\Model\Blog\Post', $id);

        if (is_null($post)) {
            throw new \Exception('Blog post not found!', 404);
        }

        return $post;
    }

    public function update($id, $data) {
        
    }

    public function delete($id) {
        
    }

}