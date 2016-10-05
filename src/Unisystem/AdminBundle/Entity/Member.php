<?php

namespace Unisystem\AdminBundle\Entity;

use Symfony\Component\HttpFoundation\File\File;
/**
 * Member
 */
class Member
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $code;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $email;

    /**
     * @var \DateTime
     */
    private $birth_date;

    /**
     * @var \DateTime
     */
    private $admission_date;

    /**
     * @var boolean
     */
    private $enabled;

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
     * @var \Unisystem\AdminBundle\Entity\MemberRole
     */
    private $role;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $courses;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $previous_roles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->courses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->previous_roles = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return Member
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set code
     *
     * @param integer $code
     *
     * @return Member
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return integer
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Member
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Member
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return Member
     */
    public function setBirthDate($birthDate)
    {
        $this->birth_date = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birth_date;
    }

    /**
     * Set admissionDate
     *
     * @param \DateTime $admissionDate
     *
     * @return Member
     */
    public function setAdmissionDate($admissionDate)
    {
        $this->admission_date = $admissionDate;

        return $this;
    }

    /**
     * Get admissionDate
     *
     * @return \DateTime
     */
    public function getAdmissionDate()
    {
        return $this->admission_date;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Member
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Member
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
     * @return Member
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
     * @return Member
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
     * Set role
     *
     * @param \Unisystem\AdminBundle\Entity\MemberRole $role
     *
     * @return Member
     */
    public function setRole(\Unisystem\AdminBundle\Entity\MemberRole $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \Unisystem\AdminBundle\Entity\MemberRole
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Add course
     *
     * @param \Unisystem\AdminBundle\Entity\MemberCourse $course
     *
     * @return Member
     */
    public function addCourse(\Unisystem\AdminBundle\Entity\MemberCourse $course)
    {
        $this->courses[] = $course;

        return $this;
    }

    /**
     * Remove course
     *
     * @param \Unisystem\AdminBundle\Entity\MemberCourse $course
     */
    public function removeCourse(\Unisystem\AdminBundle\Entity\MemberCourse $course)
    {
        $this->courses->removeElement($course);
    }

    /**
     * Get courses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * Add previousRole
     *
     * @param \Unisystem\AdminBundle\Entity\MemberRole $previousRole
     *
     * @return Member
     */
    public function addPreviousRole(\Unisystem\AdminBundle\Entity\MemberRole $previousRole)
    {
        $this->previous_roles[] = $previousRole;

        return $this;
    }

    /**
     * Remove previousRole
     *
     * @param \Unisystem\AdminBundle\Entity\MemberRole $previousRole
     */
    public function removePreviousRole(\Unisystem\AdminBundle\Entity\MemberRole $previousRole)
    {
        $this->previous_roles->removeElement($previousRole);
    }

    /**
     * Get previousRoles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPreviousRoles()
    {
        return $this->previous_roles;
    }
    /**
     * @var string
     */
    private $photography;


    /**
     * Set photography
     *
     * @param string $photography
     *
     * @return Member
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
     * @var File $file
     */
    private $file;

    public function setFile(File $file = null)
    {
        dump($file);
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
