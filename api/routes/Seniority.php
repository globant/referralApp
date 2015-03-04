<?php
namespace Routes;

use Models\Seniority as SeniorityM;

class Seniority extends Base
{
    public function get()
    {
        $seniorities = SeniorityM::find();
        
        $this->response->setJsonContent($seniorities->toArray());
        
        return $this->response;
    }
}