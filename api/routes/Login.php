<?php
namespace Routes;

use \Models\User;

class Login extends Base
{
    public $client;
    protected function _init()
    {
        $client = new \Google_Client();
        $client->setClientId($this->config->googleSignon->clientId);
        $client->setClientSecret($this->config->googleSignon->clientSecret);
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

    public function localLogin() {
        $sess_user = json_decode($this->session->user);
        
        //if there's a user in session already, let the caller know and stop.
        if (!empty($sess_user)) {
            $response = array(
                'success' => false,
                'message' => "There's already a user with its session opened. Close it to be able to open a new one.",
            );
        } else {
            $email = $this->request->getPost('usr_email');
            $password = md5($this->request->getPost('pass'));

            $user = User::getUserByCredentials($email, $password);
            if (!empty($user)) {
                //adding the user to session, blank the pass from the object
                $user->password = '';
                $this->session->set('user', json_encode($user));
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
        
        }
        $this->response->setJsonContent($response);

        return $this->response;
    }
    
    public function getCurrentUser() {
        $user = json_decode($this->session->user);
        
        if (!empty($user)) {
            $response = array(
                'success' => true,
                'message' => 'Ok',
                'data' => $user,
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'No user logged in',
                'data' => null,
            );
        }
        $this->response->setJsonContent($response);

        return $this->response;
    }

    public function localLogout() {
        $sess_user = json_decode($this->session->user);
        
        if (!empty($sess_user)) {
            $this->session->remove('user');
            $response = array(
                'success' => true,
                'message' => 'User logged out',
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'There is no user logged in.',
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
        $url = $this->config->googleSignon->validateTokenUrl . $token->access_token;
        $req = new \Google_Http_Request($url);

        $tokenInfo = json_decode($this->client->getIo()->makeRequest($req)->getResponseBody());

        if (isset($tokenInfo->error)) {
            $validation = array(
                'status_code' => 500,
                'status_message' => $tokenInfo->error,
                'success' => false,
                'message' => $tokenInfo->error,
            );
        } elseif ($tokenInfo->audience != $this->config->googleSignon->clientId) {
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