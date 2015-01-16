<?php
namespace Routes;

use Models\Referral as ReferralM;

class Referral extends Base
{
    public function insert() {
        $success = false;
        $message = '';
        
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $linkedin = $this->request->getPost('linkedin');
        $portfolio = $this->request->getPost('portfolio');
        $technology = $this->request->getPost('tech');
        $english = $this->request->getPost('english');
        $country = $this->request->getPost('country');
        $city = $this->request->getPost('city');
        $whyGoodReferral = $this->request->getPost('reason');
        $cv_path = '';
        if ($this->request->hasFiles()) {
            foreach ($this->request->getUploadedFiles() as $file) {
                $destination = $this->config->filesystem->files_folder . '/' . $file->getName();
                $tmp_path = $file->getTempName();
                
                if ($file->moveTo($destination)) {
                    $cv_path = $destination;
                } else {
                    $message .= "Error moving the file. Destination: $destination. Temp path: $tmp_path";
                }
            }
        } else {
            $message .= 'No files received. ';
        }
        

        $phql = "INSERT INTO Models\Referral VALUES (NULL, '$name', '$email', '$linkedin', '$portfolio', '$technology', $english, '$country', '$city', '$whyGoodReferral', '$cv_path')";
        $q = $this->modelsManager->createQuery($phql);
        $r = $q->execute();
        if ($r->success() == false) {
            foreach ($r->getMessages as $message) {
              $message .= $message->getMessage();
            }
        } else {
            $success = true;
            $data = $r->getModel();
        }
        
        $this->response->setJsonContent(array('success' => $success, 'data' => $data, 'message' => $message));
        
        return $this->response;
    }
}