<?php
    class AdminModel{
        public static function login($username , $password){
            $db = Db::getConnect();
            $result = $db->query("SELECT * FROM admin WHERE username = :username AND password = :password" , array(
                'username' => $username ,
                'password' => $password
            ));
            return $result;
        }
		
		public static function get_all_user(){
            $db = Db::getConnect();
            $result = $db->query("SELECT * FROM user" , array());
            return $result;
        }
		
		public static function users(){
            $db = Db::getConnect();
            $result = $db->query("SELECT * FROM user" , array());
            return $result;
        }
		
		public static function updateUser($id , $username , $password , $wallet){
            $db = Db::getConnect();
            $result = $db->modify("UPDATE user SET wallet = :wallet , username = :username , password = :password WHERE id = :id " , array(
				'id' => $id ,
				'username' => $username ,
				'password' => $password ,
				'wallet' => $wallet
			));
            return $result;
        }
		
		public static function findUserById($id){
            $db = Db::getConnect();
            $result = $db->query("SELECT * FROM user WHERE id = :id" , array(
				'id' => $id
			));
            return $result;
        }
		
		public static function get_all_ticket(){
            $db = Db::getConnect();
            $result = $db->query("SELECT * FROM ticket INNER JOIN flight ON ticket.flight_id = flight.id" , array());
            return $result;
        }
		
		public static function update_wallet($id , $wallet){
            $db = Db::getConnect();
            $result = $db->modify("UPDATE user SET wallet = :wallet WHERE id = :id " , array(
				'id' => $id ,
				'wallet' => $wallet
			));
            return $result;
        }
		
		public static function get_user_info($id){
            $db = Db::getConnect();
            $result = $db->query("SELECT * FROM user WHERE id = :id" , array(
				'id' => $id
			));
            return $result;
        }
		
		
		public static function fake_flight($from , $to){	
			for($i = 0; $i<10 ; $i++){
				$db = Db::getConnect();
				$f = rand(0 , ( count($from) -1 ) );
				$t = rand(0 , ( count($to) -1) );
				$hour = rand(0 , 23);
				$min =  rand(0 , 58);
				$day = rand(1 , 30);
				$month = rand(1 , 12);
				$price = rand(100 , 5000) ;
				
				$db->insert("INSERT INTO flight (`from`, `to` , date , time , price) VALUES (:from , :to , :date , :time , :price)" , array(
					'from' => $from[$f] ,
					'to' => $to[$t] ,
					'date' =>  "2018-".$month."-".$day ,
					'time' => $hour.':'.$min ,
					'price' => $price ,
				));
				echo $i + 1 . " record add" . "<br/>";
			}
			
        }
    }
?>