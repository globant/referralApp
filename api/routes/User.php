<?php
namespace Routes;

use Models\User as UserM;

class User extends Base
{
    public function get() {
        $sortByPoints = $this->request->getQuery('sortByPoints', 'int', 0);
        
        $userQuery = UserM::query();
        $userQuery->leftJoin('Models\Location', 'Models\User.lid = l.id', 'l');
        
        $columns = array('Models\User.id', 'email', 'name', 'points','l.description as location');
        $userQuery->columns($columns);
        
        if ($sortByPoints) {
            $userQuery->orderBy('points DESC');
        }
        
        $this->response->setJsonContent($userQuery->execute()->toArray());
        
        return $this->response;
    }
}
