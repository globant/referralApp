<?php
namespace Models;

class EnglishProficiency extends \Phalcon\Mvc\Model
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
    
    public function getSource() {
        return 'english_proficiency';
    }
}