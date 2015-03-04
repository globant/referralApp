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
     * @Column(type="integer", length=11, nullable=false)
     */
    public $seniority;
    /**
     * @Column(type="integer", length=11, nullable=false)
     */
    public $location;    
    /**
     * @Column(type="boolean", length=1, nullable=false)
     */
    public $isHot;

    public function initialize() {
        $this->hasOne('location', 'Models\Location', 'id', array('alias' => 'Location'));
        $this->hasOne('seniority', 'Models\Seniority', 'id', array('alias' => 'Seniority'));
    }
    public function columnMap()
    {
        return array(
            'id' => 'id',
            'name' => 'name',
            'lid' => 'location',
            'sid' => 'seniority',
            'is_hot' => 'isHot',
        );
    }
}