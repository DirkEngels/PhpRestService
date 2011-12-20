<?php

namespace App\Domain\Model\Blog;

/**
 * @Entity
 * @Table(name="blog_post")
 */
class Member {
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Column(name="dateCreated", type="datetime")
     */
    private $dateCreatedCreated;

    /** @Column(name="username" type="string", length=200) */
    private $username;

    /** @Column(name="password" type="string", length=200) */
    private $password;

    /** @Column(name="email" type="string", length=200) */
    private $email;

//    /** @OneToMany(targetEntity="Comment", mappedBy="member") */
//    private $comments;

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

//    public function getComments() {
//        return $this->comments;
//    }

    /**
     * @PrePersist
     */
    function onPrePersist() {
        $this->date = new \DateTime('now');
    }

}
