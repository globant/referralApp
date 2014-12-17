<?php
namespace Models;

class User extends \Phalcon\Mvc\Model
{
    /**
     * @var integer
     */
    public $id;
    /**
     * @var string
     */
    public $password;
    /**
     * @var string
     */
    public $email;
    /**
     * @var integer
     */
    public $points;
    /**
     * @var string
     */
    public $name;
    
    public static function getByEmailPass($email, $password) {
        $user = User::query()
                ->addWhere('email = :email:')
                ->andWhere('password = :password:')
                ->bind(array('email' => $email, 'password' => $password))
                ->execute()
                ->getFirst();
        
        return $user;
    }
}