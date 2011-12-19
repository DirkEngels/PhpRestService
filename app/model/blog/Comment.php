<?php

namespace App\Blog\Comment;

/**
 * @Entity
 * @Table(name="blog_comment")
 * @HasLifeCycleCallbacks
 */
class Comment extends AbstractClass {
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="\App\Model\Blog\Post", inversedBy="posts")
     * @JoinColumn(name="post_id", referencedColumnName="id")
     */
    private $post;

    /**
     * @Column(name="date", type="datetime")
     */
    private $date;

    /** @Column(name="author", type="string", length=100) */
    private $author;

    /** @Column(type="text") */
    private $content;

    public function getId() {
        return $this->id;
    }

    public function getPost() {
        return $this->post;
    }

    public function setPost($post) {
        $this->post = $post;
        return $this;
    }

    public function getDate() {
    	return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function setAuthor($author) {
        $this->author = $author;
        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    /**
     * @PrePersist
     */
    function onPrePersist() {
        $this->date = new \DateTime('now');
    }

}
