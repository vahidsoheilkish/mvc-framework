<?php
    class UserController{
        function index(){
            $data['title'] = "home";
            if( empty($_SESSION['user']) ){
                $data['user'] = '';
            }else{
                $result = UserModel::get_user_wallet($_SESSION['user']);
                $data['wallet'] = $result[0]['wallet'];
                $data['user'] = $_SESSION['user'];
            }
            View::render("user/home" , $data);
        }

        function login(){
            $username = $_POST['username'];
            $password = $_POST['password'];
            if($username == "" || $password == ""){
				$msg = array(
                    'status' => 'Please enter username and password first'
                );
                echo json_encode($msg);
                return false;
            }
            $result = UserModel::login($username , $password);
            if($result){
                $_SESSION['user'] = $username;
                $msg = array(
                    'status' => true ,
                    'user' => $_SESSION['user']
                );
                echo json_encode($msg);
            }else{
                $msg = array(
                    'status' => false ,
                );
                echo json_encode($msg);
            }

        }

        function register(){
            $username = $_POST['username'];
            $password = $_POST['password'];
            $password2 = $_POST['password2'];
            $err = [];

            if($username == ""){
                array_push($err , "Please enter username first") ;
            }

            if($password == "" || $password2 == ""){
                array_push($err ,  "Please enter password first" );
            }else if($password != $password2){
                array_push($err ,  "Password is not match" );
            }
            if($err){print_r($err); return false;}
            $result = UserModel::register($username , $password);
            if($result){
                echo "Register done";
            }
        }

        function change_password(){
            $old = $_POST['old'];
            $new1 = $_POST['new1'];
            $new2 = $_POST['new2'];
            $err = [];
            if($old == "" || $new1 == "" || $new2 == ""){
                array_push($err , "Please enter fields") ;
            }
            if($new1 != $new2){
                array_push($err , "Password is not match") ;
            }

            if($err){print_r($err); return false;}
            $res = UserModel::checkOldPassword($_SESSION['user'] , $old);
            if($res){
                $result = UserModel::changePassword($_SESSION['user'] , $new1);
                if($result){
                    unset($_SESSION['user']);
                    echo "ok";
                }
            }else{
                echo "Old password is wrong";
            }
        }

        function logout(){
            unset($_SESSION['user']);
            header("Location: http://localhost/homework/");
        }

        function buyTicket(){
            $data['title'] = 'buy ticket';
            if( empty($_SESSION['user']) ){
                $data['user'] = '';
            }else{
                $result = UserModel::get_user_wallet($_SESSION['user']);
				$data['flights'] = UserModel::flights();
                $data['wallet'] = $result[0]['wallet'];
                $data['user'] = $_SESSION['user'];
            }
            View::render('user/buy_ticket' , $data);
        }
		
		function passenger_ticket(){
			$flight_id = $_POST['flight_id'];
			$user_info = UserModel::get_user_wallet($_SESSION['user']);
			$flight_price = UserModel::get_flight_pirce($flight_id);
			$user_id = $user_info[0]['id'];
			$user_wallet_value = $user_info[0]['wallet'];
			$flight_price_value = $flight_price[0]['price'];
			$new_wallet = (int)$user_wallet_value - (int)$flight_price_value;
			if($new_wallet < 0 ){
				echo "Wallet is not enough";
				return false;
			}
			$dec_wallet = UserModel::minus_wallet($user_id , $new_wallet);
			if($dec_wallet == 1){
				$buy_result = UserModel::buy_ticket($user_id , $flight_id , $_POST['name'] , $_POST['last_name'] , $_POST['age'] );
				echo $buy_result;
			}
		}
    }
?>