<?php
namespace Models;

class Seniority extends \Phalcon\Mvc\Model
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
    public $description;
}
