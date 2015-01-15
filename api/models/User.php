<?php
namespace Models;

class User extends \Phalcon\Mvc\Model
{
    /**
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id;
    /**
     * @Column(type="string", length=80, nullable=false)
     */
    public $password;
    /**
     * @Column(type="string", length=100, nullable=false)
     */
    public $email;
    /**
     * @Column(type="integer", length=11, nullable=false)
     */
    public $points;
    /**
     * @Column(type="string", length=100, nullable=false)
     */
    public $name;
    /**
     * @Column(type="integer", length=11, nullable=true)
     */
    public $lid;

    public function initialize() {
        $this->hasOne('lid', 'Models\Location', 'id', array('alias' => 'location'));
    }
    public static function getUserByCredentials($email, $password) {
        $user = User::query()
            ->where('email = :email:')
            ->andWhere('password = :password:')
            ->bind(
                array(
                    'email' => $email,
                    'password' => $password
                )
            )
            ->execute()
            ->getFirst();

        return $user;
    }
}