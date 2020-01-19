<?php
    namespace App\Controllers;

    use App\Services\UserService;
    use Core\Controller;

    class UserController extends Controller{
        public function login() {
    
            if(!empty($_POST)){
                
                $error = null;
    
                $username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_SPECIAL_CHARS);
                $password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_SPECIAL_CHARS);
    
                $userService = new UserService();
    
                $validationResult = $userService->validateUserPassword($username,$password);
    
                if($validationResult['status']) {
                    $_SESSION['username'] = $username;
                }
    
                echo \json_encode($validationResult);
                
            } else {
                $this->render("login.html",[]);
            }
            
        }
    
        public function logout(){
    
            unset($_SESSION['username']);
        }
    
        public function profile() {

            $userService= new UserService();

            $username = $_SESSION['username'];

            $data = $userService->getProfileData($username);

            $this->render("profile.html",['data'=>$data['data']]);
        }
    }
?>