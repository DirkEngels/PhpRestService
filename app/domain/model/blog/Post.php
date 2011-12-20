<?php

namespace App\Domain\Model\Blog;

/**
 * @Entity
 * @Table(name="blog_post")
 */
class Post {
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Column(name="dateCreated", type="datetime")
     */
    private $dateCreated;

    /** @Column(name="title", type="string", length=100) */
    private $title;

    /** @Column(type="text") */
    private $content;

    /** @OneToMany(targetEntity="Comment", mappedBy="post") */
    private $comments;

    public function getId() {
        return $this->id;
    }

    public function getDateCreated() {
        return $this->dateCreated;
    }

    public function setDateCreated($dateCreated) {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function getComments() {
        return $this->comments;
    }

    /**
     * @PrePersist
     */
    function onPrePersist() {
        $this->date = new \DateTime('now');
    }

}
