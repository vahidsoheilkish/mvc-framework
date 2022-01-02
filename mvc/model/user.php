<?php
    class UserModel{
        public static function register($username , $password){
            $db = Db::getConnect();
            $result = $db->insert("INSERT INTO user (username , password) VALUES (:username , :password)" , array(
                'username' => $username ,
                'password' => $password
            ));
            return $result;
        }

        public static function login($username , $password){
            $db = Db::getConnect();
            $result = $db->query("SELECT username,password FROM user WHERE username = :username AND password = :password" , array(
                'username' => $username ,
                'password' => $password
            ));
            return $result;
        }

        public static function checkOldPassword($username , $password){
            $db = Db::getConnect();
            $result = $db->query("SELECT username,password FROM user WHERE username = :username AND password = :password" , array(
                'username' => $username,
                'password' => $password
            ));
            return $result;
        }
		
		public static function flights(){
            $db = Db::getConnect();
            $result = $db->query("SELECT * FROM flight" , array());
            return $result;
        }

        public static function changePassword($username , $password){
            $db = Db::getConnect();
            $result = $db->modify("UPDATE user set password = :password WHERE username = :username" , array(
                'username' => $username,
                'password' => $password
            ));
            return $result;
        }

        public static function get_user_wallet($username){
            $db = Db::getConnect();
            $result = $db->query("SELECT id,username,wallet FROM user WHERE username = :username" , array(
                'username' => $username
            ));
            return $result;
        }
		
		public static function get_flight_pirce($id){
            $db = Db::getConnect();
            $result = $db->query("SELECT price FROM flight WHERE id = :id" , array(
                'id' => $id
            ));
            return $result;
        }
		
		public static function minus_wallet($user_id , $new_wallet){
            $db = Db::getConnect();
            $result = $db->modify("UPDATE user SET wallet = :wallet WHERE id = :id" , array(
                'id' => $user_id,
				'wallet' => $new_wallet
            ));
            return $result;
        }
		
		
		public static function buy_ticket($id , $flight_id ,  $name , $family , $age){
            $db = Db::getConnect();
            $result = $db->insert("INSERT INTO ticket (user_id , flight_id , name , family , age) VALUES (:user_id , :flight_id  ,  :name , :family , :age)" , array(
                'user_id' => $id ,
                'flight_id' => $flight_id ,
                'name' => $name ,
                'family' => $family ,
                'age' => $age ,
            ));
            return $result;
        }
		
		
		
		
    }
?>