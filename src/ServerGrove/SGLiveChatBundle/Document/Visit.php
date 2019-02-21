<?php

namespace ServerGrove\SGLiveChatBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
/**
 * @author Ismael Ambrosi<ismael@servergrove.com>
 * @MongoDB\Document(
 * collection="visit",
 * repositoryClass="ServerGrove\SGLiveChatBundle\Document\VisitRepository"
 * )
 */
class Visit
{

    /**
     * @MongoDB\Id
     */
    private $id;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Visitor")
     */
    private $visitor;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $key;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $remoteAddr;

    /**
     * @var string
     * @MongoDB\Field(type="date")
     */
    private $createdAt;

    /**
     * @var string
     * @MongoDB\Field(type="date")
     */
    private $updatedAt;

    /**
     * @var int
     * @MongoDB\Field(type="int")
     */
    private $localTime;

    /**
     * @MongoDB\EmbedMany(targetDocument="VisitHit")
     */
    private $hits;

    public function getHits()
    {
        return $this->hits;
    }

    public function addHit(VisitHit $hit)
    {
        $this->hits[] = $hit;
    }

    /**
     * @MongoDB\PrePersist
     */
    public function registerCreatedDate()
    {
        $this->setCreatedAt(date('Y-m-d H:i:s'));
        $this->registerUpdatedDate();
    }

    /**
     * @MongoDB\PreUpdate
     */
    public function registerUpdatedDate()
    {
        $this->setUpdatedAt(date('Y-m-d H:i:s'));
    }

    /**
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Visitor $visitor
     */
    public function getVisitor()
    {
        return $this->visitor;
    }

    /**
     * @return string $key
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return string $remoteAddr
     */
    public function getRemoteAddr()
    {
        return $this->remoteAddr;
    }

    /**
     * @return string $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return string $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return int $localTime
     */
    public function getLocalTime()
    {
        return $this->localTime;
    }

    /**
     * @param field_type $visitor
     * @return void
     */
    public function setVisitor(Visitor $visitor)
    {
        $this->visitor = $visitor;
        $visitor->addVisit($this);
    }

    /**
     * @param string $key
     * @return void
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @param string $remoteAddr
     * @return void
     */
    public function setRemoteAddr($remoteAddr)
    {
        $this->remoteAddr = $remoteAddr;
    }

    /**
     * @param string $createdAt
     * @return void
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param string $updatedAt
     * @return void
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param int $localTime
     * @return void
     */
    public function setLocalTime($localTime)
    {
        $this->localTime = $localTime;
    }

}