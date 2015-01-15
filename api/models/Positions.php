<?php
namespace Models;

class Positions extends \Phalcon\Mvc\Model
{
    /**
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id;
    /**
     * @Column(type="string", length=48, nullable=false)
     */
    public $name;
    /**
     * @Column(type="string", length=48, nullable=false)
     */
    public $location;
    /**
     * @Column(type="string", length=24, nullable=false)
     */
    public $seniority;
    /**
     * @Column(type="boolean", length=1, nullable=false)
     */
    public $is_hot;

    public function columnMap()
    {
        return array(
            'id' => 'id',
            'name' => 'name',
            'location' => 'location',
            'seniority' => 'seniority',
            'is_hot' => 'isHot',
        );
    }
}