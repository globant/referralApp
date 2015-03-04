<?php
namespace Routes;

use \Models\Location as LocationM;

class Location extends Base
{
    public function get()
    {
        $locations = LocationM::find();
        
        $this->response->setJsonContent($locations->toArray());
        
        return $this->response;
    }
}