<?php
namespace Routes;

use \Models\Positions as PositionsM;

class Positions extends Base
{
    public function get()
    {
        $positions = PositionsM::query();

        $filters = $this->request->getQuery();
        unset($filters['_url']);
        foreach ($filters as $filterKey => $filterValue) {
            $positions->andWhere($filterKey . ' = :' . $filterKey . ':');
        }
        $positions->bind($filters);

        $this->response->setJsonContent($positions->execute()->toArray());

        return $this->response;
    }
}