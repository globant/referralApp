<?php
class Routes
{
    /**
     * @var \Phalcon\Http\Response
     */
    public $response;

    public function __construct()
    {
        $this->response = new \Phalcon\Http\Response();
    }

    public function pull($id = null)
    {
        if ($id) {
            $response = \Models\Testing::query()
                ->where('id = :id:')
                ->bind(
                    array(
                        'id' => $id,
                    )
                )
                ->execute()
                ->getFirst()
                ->toArray();
        } else {
            $response = \Models\Testing::query()
                ->execute()
                ->toArray();
        }

        $this->response->setJsonContent($response);

        return $this->response;
    }
}