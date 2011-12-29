<?php

namespace App\Domain\Logic;

class Post {

    protected function _setAttribute($object, $key, $value) {
        $method = 'set' . $key;
        if (method_exists($object, $method)) {
            $object->$method($value);
        }
        return $object;
    }

    public function write($data) {
        $blogPost = new \App\Domain\Model\Blog\Post();
        foreach($data as $key => $value) {
            $blogPost = $this->_setAttribute($blogPost, $key, $value);
        }

        $entityManager = \Zend_Registry::get('entityManager');
        $entityManager->persist($blogPost);
        return $entityManager->flush();
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
        $post = $this->find($id);
        foreach($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($post, $method)) {
                $post->$method($value);
            }
        }
        $entityManager = \Zend_Registry::get('entityManager');
        $entityManager->persist($post);
        return $entityManager->flush();
    }

    public function delete($id) {
        $post = $this->find($id);
        $entityManager = \Zend_Registry::get('entityManager');
        $entityManager->remove($post);
        return $entityManager->flush();
    }

}