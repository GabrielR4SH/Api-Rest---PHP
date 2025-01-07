<?php 

class UserController extends BaseController
{
    public function listAction(){
        
        $erroDescription = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $stringParamsArray = $this->getStringParams();

        if(strtoupper($requestMethod) == 'GET'){
            try{
                $userModel = new UserModel();
                
                $initLimit = 10;
                if(isset($stringParamsArray['limit']) && $stringParamsArray['limit']){
                    $initLimit = $stringParamsArray['limit'];
                }

                $usersArray = $userModel->getUsers($initLimit);
                $responseData = json_encode($usersArray);
            } catch(Error $e){
                $errorDescription = $e->getMessage().'Something went wrong! Please contact support';
                $errorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $errorDescription = "Method not supported";
            $errorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        //send output
        if (!$erroDescription){
            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 Ok'));
        } else {
            $this->sendOutput(json_encode(array('error' => $errorDescription)),
            array('Content-Type: application/json', $errorHeader));
        }

    }


}