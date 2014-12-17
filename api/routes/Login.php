<?php
namespace Routes;

use \Models\User;

class Login extends Base
{
    const CLIENT_ID = '229737568035-t0isieq89rkd65av2uvebo4iu2jrju43.apps.googleusercontent.com';
    const CLIENT_SECRET = 'Kfy5Tj5KFho0N62Ykoc8dtt_';

    public $client;

    protected function _init()
    {
        $client = new \Google_Client();
        $client->setClientId(self::CLIENT_ID);
        $client->setClientSecret(self::CLIENT_SECRET);
        $client->setRedirectUri('postmessage');
        $this->client = $client;

        return parent::_init();
    }

    public function login()
    {
        $token = $this->session->token;

        if (empty($token)) {
            $code = $this->request->getRawBody();
            $this->client->authenticate($code);
            $token = json_decode($this->client->getAccessToken());

            $tokenValidation = $this->_validateToken($token);

            if (!isset($tokenValidation['error'])) {
                $this->session->token = json_encode($token);
            }

            $this->response->setStatusCode($tokenValidation['status_code'], $tokenValidation['status_message']);
            $response = array(
                'success' => $tokenValidation['success'],
                'message' => $tokenValidation['message'],
            );
        } else {
            $response = array(
                'success' => true,
                'message' => 'Already connected',
            );
        }
        $this->response->setJsonContent($response);

        return $this->response;
    }

    public function logout()
    {
        $token = json_decode($this->session->token);

        if (!empty($token)) {
            $this->client->revokeToken($token->access_token);
            $this->session->remove('token');

            $response = array(
                'reload' => true,
            );
        } else {
            $response = array(
                'reload' => false,
            );
        }
        $this->response->setJsonContent($response);

        return $this->response;

    }

    public function local_login() {
        $email = $this->request->getPost('usr_email');
        $password = md5($this->request->getPost('pass'));

        $user = User::getUserByCredentials($email, $password);
        if (!empty($user)) {
            $response = array(
                'success' => true,
                'message' => 'Authenticated'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Invalid username/password'
            );
        }
        $this->response->setJsonContent($response);

        return $this->response;
    }
    /**
     * Returns false if token is ok
     * @param object $token
     * @return boolean
     */
    private function _validateToken($token)
    {
        $url = 'https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=' . $token->access_token;
        $req = new \Google_Http_Request($url);

        $tokenInfo = json_decode($this->client->getIo()->makeRequest($req)->getResponseBody());

        if (isset($tokenInfo->error)) {
            $validation = array(
                'status_code' => 500,
                'status_message' => $tokenInfo->error,
                'success' => false,
                'message' => $tokenInfo->error,
            );
        } elseif ($tokenInfo->audience != self::CLIENT_ID) {
            $validation = array(
                'status_code' => 401,
                'status_message' => 'Client ID mismatch',
                'success' => false,
                'message' => 'Client ID mismatch',
            );
        } else {
            $validation = array(
                'status_code' => 200,
                'status_message' => 'OK',
                'success' => true,
                'message' => 'Successfully connected',
            );
        }

        return $validation;
    }
}