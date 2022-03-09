<?php

namespace App\Entity;

use App\Core\BaseClasse\BaseEntity;
use DateTime;

class Commentary extends BaseEntity
{
    private int $id;
    private int $articleId;
    private int $userId;
    private string $content;
    private DateTime $createdAt;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
      return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
      $this->id = $id;

      return $this;
    }

    /**
     * Get the value of articleId
     */ 
    public function getArticleId()
    {
      return $this->articleId;
    }

    /**
     * Set the value of articleId
     *
     * @return  self
     */ 
    public function setArticleId($articleId)
    {
      $this->articleId = $articleId;

      return $this;
    }

    /**
     * Get the value of userId
     */ 
    public function getUserId()
    {
      return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */ 
    public function setUserId($userId)
    {
      $this->userId = $userId;

      return $this;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
      return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
      $this->content = $content;

      return $this;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
      return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt($createdAt)
    {
      $this->createdAt = $createdAt;

      return $this;
    }
}