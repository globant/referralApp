<?php
namespace Routes;

use \Models\Positions as PositionsM;

class Positions extends Base
{
    public function get()
    {
        //using PHQL instead of model::query because of the following bug with multiple joins
        //http://forum.phalconphp.com/discussion/1479/multiple-joins-in-oo-notation-fail
        
        $phql = 'Select Models\Positions.id, name, isHot, l.description as location,  s.description as seniority
                 from Models\Positions
                 left join Models\Location l on location = l.id
                 left join Models\Seniority s on seniority = s.id';
        
        $filters = $this->request->getQuery();
        $pageNum = $this->request->get('pageNum', 'int');
        $pageSize = $this->request->get('pageSize', 'int');
        
        unset($filters['_url']);
        unset($filters['pageNum']);
        unset($filters['pageSize']);
        
        $queryString = '?';
        $first = true;
        $placeholders = array();
        $columns = array('id' => 'id',
                         'name' => 'name',
                         'isHot' => 'isHot',
                         'location' => 'l.description',
                         'seniority' => 's.description');
        
        foreach ($filters as $filterKey => $filterValue) {
            switch ($filterKey) {
                case 'id':
                case 'name':
                case 'isHot':
                case 'location':
                case 'seniority':
                    if ($first) {
                        $phql .= " WHERE $columns[$filterKey] = :$filterKey:";
                        $first = false;
                    }
                    else {
                        $phql .= " AND $columns[$filterKey] = :$filterKey:";
                    }
                    $placeholders[$filterKey] = $filterValue;
                    break;
                default:
                    break;
            }
            $queryString .= $filterKey . '=' . $filterValue . '&';
        }
        
        //if we received pageSize, paginate results and send pager related info in the response.
        if (!empty($pageSize)) {
            $offSet = $pageNum*$pageSize;
            $phql .= " LIMIT $pageSize OFFSET $offSet";
            $totalRecords = PositionsM::count();
            
            $lastPage = ceil($totalRecords / $pageSize) - 1;
            $firstPage = 0;
            $nextPage = $pageNum + 1;
            $previousPage = $pageNum - 1;
            
            $uri = '//' . $_SERVER['HTTP_HOST'] . $_GET['_url'];
            $lastLink = $uri . $queryString . "pageNum=$lastPage&pageSize=$pageSize";
            $firstLink = $uri . $queryString . "pageNum=$firstPage&pageSize=$pageSize";
            $nextPageLink = ($nextPage <= $lastPage) ? $uri . $queryString . "pageNum=$nextPage&pageSize=$pageSize" : null;
            $previousPageLink = ($previousPage >= $firstPage) ? $uri . $queryString . "pageNum=$previousPage&pageSize=$pageSize" : null;
            
            $links = array('first' => $firstLink, 'previous' => $previousPageLink, 'next' => $nextPageLink, 'last' => $lastLink);
            
            $pager = array('total' => $totalRecords, 'pageSize' => $pageSize, 'links' => $links);
            $response['pagination'] = $pager;
        }
        
        $query = $this->modelsManager->createQuery($phql);
        $response['data'] = $query->execute($placeholders)->toArray();
        
        $this->response->setJsonContent($response);

        return $this->response;
    }
}