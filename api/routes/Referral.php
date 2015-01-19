<?php
namespace Routes;

use Models\Referral as ReferralM;

class Referral extends Base
{
    public function save() {
        $success = false;
        $message = '';
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
        
        $referral = new ReferralM();
        
        $referral->assign(array_merge($_POST, array('cvPath' => $cv_path)));
        
        $success = $referral->save();
        
        if (!$success) {
            foreach ($referral->getMessages() as $message) {
              $message .= $message->getMessage();
            }
        }
        
        $this->response->setJsonContent(array('success' => $success, 'data' => $referral, 'message' => $message));
        
        return $this->response;
    }
}