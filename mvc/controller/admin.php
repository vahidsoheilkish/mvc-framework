<?php
    class AdminController{
		
        function login(){
			$data['title'] = "Admin login";
			View::renderAdmin("admin/login");
		}
		
		function users(){
			$result = AdminModel::users();
			$data['users'] = $result;
			View::renderAdmin("admin/users" , $data);
		}
		
		function user_edit($id){
			$result = AdminModel::findUserById($id[0]);
			$data['user'] = $result;
			View::renderAdmin("admin/user_edit" , $data);
		}
		function editUser(){
			$id = $_POST['txt_id'];
			$username = $_POST['txt_username'];
			$password = $_POST['txt_password'];
			$wallet = $_POST['txt_wallet'];
			$result = AdminModel::updateUser($id , $username , $password , $wallet);
			if($result){
				header("Location: http://localhost/homework/admin/users");
			}else{
				echo "update fail. back to users list <a href='http://localhost/homework/admin/users'></a>";
			}
			
		}
		function confirm(){
			if(isset($_POST['btn_submit'])){
				$username = $_POST['admin_username'];
				$password = $_POST['admin_password'];
				if($username == "" || $password == ""){
					$data['title'] = "Warning";
					$data['msg'] = "Please enter username and password";
					$data['err_type'] = "bg-warning";
					View::renderAdmin("admin/message" , $data);
					return false;
				}
				$result = AdminModel::login($username , $password);
				if($result){
					if($result[0]['permission'] == 1 ){
						$_SESSION['admin'] = $username;
						$data['title'] = "Admin dashboard";
						$data['admin'] = $_SESSION['admin'];
						$data['users'] = AdminModel::get_all_user();
						$data['tickets'] = AdminModel::get_all_ticket();
						View::renderAdmin("admin/dashboard" , $data);
					}else{
						$data['title'] = "Error";
						$data['msg'] = "Access denied";
						$data['err_type'] = "bg-danger";
						View::renderAdmin("admin/message" , $data);
						return false;
					}
				}else{
					$data['title'] = "Error";
					$data['msg'] = "Invalid username and password";
					$data['err_type'] = "bg-danger";
					View::renderAdmin("admin/message" , $data);
					return false;
				}
			}else{
				header("Location: http://localhost/homework/admin/login");
			}
		}
		
		function logout(){
			unset($_SESSION['admin']);
			header("Location: http://localhost/homework/admin/login");
		}
		
		function update_wallet(){
			$this->auth();
			$id = $_POST['id'];
			$wallet = $_POST['wallet'];
			$result = AdminModel::update_wallet($id , $wallet);
			echo $result;
		}
		
		function fake_flight(){
			$this->auth();
			$from = array ( "Tehran" , "Shiraz" , "Tabriz" , "Mashhad" , "Kerman" , "Ahwaz" , "Yazd" , "Rasht" );
			$to = array ( "Baise" , "Burbank" , "Bago" , "Brasilia" , "Brescia" , "Brighton" , "Bryansk" , "Burgos" );
			$result = AdminModel::fake_flight($from , $to);
			echo $result;
		}
		
		function get_userInfo(){
			$result = AdminModel::get_user_info($_POST['id']);
			//$result[0]['username'] . "<br/>" . " Password : " . $result[0]['password'] . " Wallet : " . $result[0]['wallet'];
			echo json_encode($result[0]);
		}
		
		function auth(){
			if( !isset($_SESSION['admin']) ){
				header("Location: http://localhost/homework/admin/login");
				return false;
			}
		}
		
		function test(){
			$this->auth();
		}
    }
?>