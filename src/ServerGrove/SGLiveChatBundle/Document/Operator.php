<?php

namespace ServerGrove\SGLiveChatBundle\Document;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ServerGrove\SGLiveChatBundle\Document\Operator\Department;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Description of Operator
 *
 * @author Ismael Ambrosi<ismael@servergrove.com>
 * @MongoDB\Document(
 * collection="operator",
 * repositoryClass="ServerGrove\SGLiveChatBundle\Document\OperatorRepository"
 * )
 * @MongoDB\InheritanceType("SINGLE_COLLECTION")
 * @MongoDB\DiscriminatorField("type")
 * @MongoDB\DiscriminatorMap({"admin"="Administrator", "operator"="Operator"})
 */
class Operator extends User implements UserInterface, PasswordEncoderInterface
{

    /**
     * @var boolean
     * @MongoDB\Field(type="boolean")
     */
    private $isOnline;

    /**
     * @var boolean
     * @MongoDB\Field(type="boolean")
     */
    private $isActive;

    /**
     * @var string
     * @MongoDB\String
     */
    private $passwd;

    /**
     * @var ServerGrove\SGLiveChatBundle\Document\Operator\Rating
     * @MongoDB\ReferenceMany(targetDocument="ServerGrove\SGLiveChatBundle\Document\Operator\Rating")
     */
    private $ratings = array();

    /**
     * @var Department[]
     * @MongoDB\ReferenceMany(targetDocument="ServerGrove\SGLiveChatBundle\Document\Operator\Department")
     */
    private $departments;

    public function addRating(Operator\Rating $rating)
    {
        $this->ratings[] = $rating;
    }

    /**
     * @return boolean $isOnline
     */
    public function getIsOnline()
    {
        return $this->isOnline;
    }

    /**
     * @param boolean $isOnline
     * @return void
     */
    public function setIsOnline($isOnline)
    {
        $this->isOnline = $isOnline;
    }

    /**
     * @return boolean $isActive
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param boolean $isActive
     * @return void
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * @return string $passwd
     */
    public function getPasswd()
    {
        return $this->passwd;
    }

    /**
     * @param string $passwd
     * @return void
     */
    public function setPasswd($passwd)
    {
        $this->passwd = $this->encodePassword($passwd, $this->getSalt());
    }

    /**
     * @return Department[] $departments
     */
    public function getDepartments()
    {
        return $this->departments;
    }

    public function addDepartment(Department $department)
    {
        $this->departments[] = $department;
    }

    public function getKind()
    {
        return 'Operator';
    }

    # -- UserInterface implementation ----------------


    /**
     * @return string
     */
    public function __toString()
    {
        return strtr('(:id) :name, :email', array(
            ':email' => $this->getEmail(),
            ':name' => $this->getName(),
            ':id' => $this->getId()));
    }

    /**
     * @param UserInterface $account
     * @return boolean
     */
    public function equals(UserInterface $account)
    {
        return $account instanceof Operator && $account->getId() == $this->getId();
    }

    public function eraseCredentials()
    {

    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->getPasswd();
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return array(
            'ROLE_USER');
    }

    public function getSalt()
    {
        return __NAMESPACE__ . '\\' . __CLASS__;
    }

    public function getUsername()
    {
        return $this->getEmail();
    }

    public function encodePassword($raw, $salt)
    {
        return md5(md5($raw) . '-' . $salt);
    }

    public function isPasswordValid($encoded, $raw, $salt)
    {
        return $encoded == $this->encodePassword($raw, $salt);
    }

}