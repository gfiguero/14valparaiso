<?php

namespace Unisystem\AdminBundle\Entity;

use Symfony\Component\HttpFoundation\File\File;
/**
 * MainPhotography
 */
class MainPhotography
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $caption;

    /**
     * @var string
     */
    private $photography;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \DateTime
     */
    private $deletedAt;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return MainPhotography
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set caption
     *
     * @param string $caption
     *
     * @return MainPhotography
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * Get caption
     *
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * Set photography
     *
     * @param string $photography
     *
     * @return MainPhotography
     */
    public function setPhotography($photography)
    {
        $this->photography = $photography;

        return $this;
    }

    /**
     * Get photography
     *
     * @return string
     */
    public function getPhotography()
    {
        return $this->photography;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return MainPhotography
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return MainPhotography
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return MainPhotography
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @var File $file
     */

    private $file;

    public function setFile(File $file = null)
    {
        $this->file = $file;
        if ($file) { $this->updatedAt = new \DateTime('now'); }
        return $this;
    }

    public function getFile()
    {
        if ($this->file) { return $this->file; }
        else 'default';
    }

}

