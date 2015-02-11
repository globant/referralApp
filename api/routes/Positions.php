<?php
namespace Routes;

use \Models\Positions as PositionsM;

class Positions extends Base
{
    public function get()
    {
        $positions = PositionsM::query();

        $filters = $this->request->getQuery();
        $pageNum = $this->request->get('pageNum', 'int');
        $pageSize = $this->request->get('pageSize', 'int');
        
        unset($filters['_url']);
        unset($filters['pageSize']);
        unset($filters['pageNum']);
        
        $queryString = '?';
        foreach ($filters as $filterKey => $filterValue) {
            $positions->andWhere($filterKey . ' = :' . $filterKey . ':');
            $queryString .= $filterKey . '=' . $filterValue . '&';
        }
        
        //if we received pageSize, paginate results and send pager related info in the response.
        if (!empty($pageSize)) {
            $positions->limit($pageSize, $pageNum*$pageSize);
            
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
        
        $positions->bind($filters);
        $response['data'] = $positions->execute()->toArray();
        
        $this->response->setJsonContent($response);

        return $this->response;
    }
}