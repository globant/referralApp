<?php
namespace Models;

class Referral extends \Phalcon\Mvc\Model
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
    public $name;
    /**
     * @Column(type="string", length=100, nullable=false)
     */
    public $email;
    /**
     * @Column(type="string", length=80, nullable=true)
     */
    public $linkedin;
    /**
     * @Column(type="string", length=100, nullable=true)
     */
    public $portfolio;
    /**
     * @Column(type="string", length=100, nullable=false)
     */
    public $technology;
    /**
     * @Column(type="integer", length=11, nullable=false)
     */
    public $eid;
    /**
     * @Column(type="string", length=100, nullable=false)
     */
    public $country;
    /**
     * @Column(type="string", length=100, nullable=false)
     */
    public $city;
    /**
     * @Column(type="string", length=100, nullable=true)
     */
    public $whyGoodReferral;
    /**
     * @Column(type="string", length=100, nullable=true)
     */
    public $cvPath;
    
    public function initialize() {
        $this->hasOne('eid', 'Models\EnglishProficiency', 'id', array('alias' => 'englishProficiency'));
    }
    
    public function columnMap() {
        return array(
            'id' => 'id',
            'name' => 'name',
            'email' => 'email',
            'linkedin' => 'linkedin',
            'portfolio' => 'portfolio',
            'technology' => 'technology',
            'eid' => 'eid',
            'country' => 'country',
            'city' => 'city',
            'why_good_referral' => 'whyGoodReferral',
            'cv_path' => 'cvPath',
        );
    }
}

?>
