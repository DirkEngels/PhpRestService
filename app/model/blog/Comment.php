<?php

namespace App\Blog\Model;

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
     * @ManyToOne(targetEntity="\App\Model\Blog\Post", inversedBy="comments")
     * @JoinColumn(name="post_id", referencedColumnName="id")
     */
    private $post;

    /**
     * @ManyToOne(targetEntity="\App\Model\Blog\Member", inversedBy="comments")
     * @JoinColumn(name="member_id", referencedColumnName="id")
     */
    private $member;

    /**
     * @Column(name="dateCreated", type="datetime")
     */
    private $dateCreated;

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

    public function getMember() {
        return $this->member;
    }

    public function setMember($member) {
        $this->member = $member;
        return $this;
    }

    public function getDateCreated() {
        return $this->dateCreated;
    }

    public function setDateCreated($dateCreated) {
        $this->dateCreated = $dateCreated;
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
