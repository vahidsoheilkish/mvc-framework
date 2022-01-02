<?php
    class Pay{

        public static function transaction($merchentCode , $amount , $callbackUrl , $orderId)
        {
            $parameters = array(
                array(
                    'webgate_id' => $merchentCode,                                            // Required
                    'amount' => $amount,                                                // Required
                    'CallbackURL' => $callbackUrl,    // Required
                    'plugin' => 'other',                                                // Required
                    'order_id' => $orderId,                                                // Optional
                    'phone' => '',                                                    // Optional
                    'email' => '',                                                    // Optional
                    'Description' => ''
                )
            );

            try {
                $client = new nusoap_client('http://startpay.ir/webservice?wsdl', 'wsdl');
                $client->soap_defencoding = 'UTF-8';
                $client->decode_utf8 = false;
                $result = $client->call('Payment', $parameters);
            } catch (Exception $e) {
                echo '<h2>Error </h2>';
                print_r($e->getMessage());
            }



            if (isset($result) && $result > 0) {
                header('Location: http://startpay.ir/?tid=' . $result);
            } else {
                echo "Error Code: " . $result;

            }

        } // end of pay function

        public static function callBackMatch($merchantCode , $oId){

            if(isset($_POST['status']))
            {
                $order_id 	= validate_input($_POST['order_id']);
                $tran_id 	= validate_input($_POST['tran_id']);
                $amount 	= validate_input($_POST['amount']);
                $status 	= validate_input($_POST['status']);
                $refcode	= validate_input($_POST['refcode']);

                $orderInfo =UserModel::fetch_callback_ma($oId);
                if($orderInfo[0]['pay'] == "fail"){

                    if($status == 'paid' && $oId == $order_id)
                    {
                        $parameters = array	(
                            'webgate_id'	=> $merchantCode,	// Required
                            'tran_id' 		=> $tran_id,	// Required
                            'amount'	 	=> $amount		// Required
                        );
                        try {
                            $client = new SoapClient('http://startpay.ir/webservice/?wsdl' , array('soap_version'=>'SOAP_1_1','cache_wsdl'=>WSDL_CACHE_NONE ,'encoding'=>'UTF-8'));
                            $result = $client->PaymentVerification($parameters);
                        }catch (Exception $e) { echo 'Error'. $e->getMessage();  }

                        if ($result == 1){
                            UserModel::setSuccessMatchPay($oId, $refcode);
							$data['title'] = "پرداخت موفق";
							$data['refcode'] = $refcode;
							$data['msg'] = "تراکنش با موفقیت انجام شد";
							echo '
							<div class="container" style="margin-top:20px;">
								<div class="row">
									<div style="text-align: center; width:50%;margin: auto;background-color: #FF5F5F; padding: 0px; color:#fff;height: auto; border-radius: 10px 10px 0px 0px;padding: 5px 3px 5px 3px;color: #313131;box-shadow: 2px 1px 5px #999;"><span style="text-align:center; color:#ffffff; font-family:sans_bold; font-size:20px;">وضعیت تراکنش</span></div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color:  #ffe186; min-height:300px; border:1px solid #555; color:#000;  padding:15px; direction:rtl; text-align: right; border-radius:9px;">
									<h4 style="font-family:sans_bold;">'.$data['msg'].'</h4>
										<div style="margin: auto; font-size:20px; margin-bottom:10px; width:100%; margin-top:120px; directon:rtl; text-align:center;">
											کد پیگیری'. $data['refcode'].'
										</div>
									</div>
								</div>
							</div>
							';
                        }
                        else{
                            $data['errCode'] = $result;
                            $data['msg'] = "پرداخت با خطا صورت گرفته است";
							echo '
							<div class="container" style="margin-top:20px;">
								<div class="row">
									<div style="text-align: center; width:50%;margin: auto;background-color: #FF5F5F; padding: 0px; color:#fff;height: auto; border-radius: 10px 10px 0px 0px;padding: 5px 3px 5px 3px;color: #313131;box-shadow: 2px 1px 5px #999;"><span style="text-align:center; color:#ffffff; font-family:sans_bold; font-size:20px;">وضعیت تراکنش</span></div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color:  #ffe186; min-height:300px; border:1px solid #555; color:#000;  padding:15px; direction:rtl; text-align: right; border-radius:9px;">
										<div style="margin: auto; font-size:20px; margin-bottom:10px; width:100%; margin-top:120px; text-align:center;">
											'.$data['msg'].'
										</div>
									</div>
								</div>
							</div>
							';
                        }
                    }
                }else{ // end of if order id
                    $data['msg'] = "این تراکنش قبلا انجام شده است";
					echo '
					<div class="container" style="margin-top:20px;">
						<div class="row">
							<div style="text-align: center; width:50%;margin: auto;background-color: #FF5F5F; padding: 0px; color:#fff;height: auto; border-radius: 10px 10px 0px 0px;padding: 5px 3px 5px 3px;color: #313131;box-shadow: 2px 1px 5px #999;"><span style="text-align:center; color:#ffffff; font-family:sans_bold; font-size:20px;">وضعیت تراکنش</span></div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color:  #ffe186; min-height:300px; border:1px solid #555; color:#000;  padding:15px; direction:rtl; text-align: right; border-radius:9px;">
								<div style="margin: auto;  font-size:20px; margin-bottom:10px; width:100%; margin-top:120px; text-align:center;">
									'.$data['msg'].'
								</div>
							</div>
						</div>
					</div>
					';
                }
            }
            else{
                $data['msg'] = "پرداخت لغو شد";
				echo '
					<div class="container" style="margin-top:20px;">
						<div class="row">
							<div style="text-align: center; width:50%;margin: auto;background-color: #FF5F5F; padding: 0px; color:#fff;height: auto; border-radius: 10px 10px 0px 0px;padding: 5px 3px 5px 3px;color: #313131;box-shadow: 2px 1px 5px #999;"><span style="text-align:center; color:#ffffff; font-family:sans_bold; font-size:20px;">وضعیت تراکنش</span></div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color:  #ffe186; min-height:300px; border:1px solid #555; color:#000;  padding:15px; direction:rtl; text-align: right; border-radius:9px;">
								<div style="margin: auto; font-size:20px; margin-bottom:10px; width:100%; margin-top:120px; text-align:center;">
									'.$data['msg'].'
								</div>
							</div>
						</div>
					</div>
				';
            }
        }

        public static function callBackClass($merchantCode , $oId){

            if(isset($_POST['status']))
            {
                $order_id 	= validate_input($_POST['order_id']);
                $tran_id 	= validate_input($_POST['tran_id']);
                $amount 	= validate_input($_POST['amount']);
                $status 	= validate_input($_POST['status']);
                $refcode	= validate_input($_POST['refcode']);

                $orderInfo = UserModel::fetch_callback_cl($oId);
                if($orderInfo[0]['pay'] == "fail"){

                    if($status == 'paid' && $oId == $order_id)
                    {
                        $parameters = array	(
                            'webgate_id'	=> $merchantCode,	// Required
                            'tran_id' 		=> $tran_id,	// Required
                            'amount'	 	=> $amount		// Required
                        );
                        try {
                            $client = new SoapClient('http://startpay.ir/webservice/?wsdl' , array('soap_version'=>'SOAP_1_1','cache_wsdl'=>WSDL_CACHE_NONE ,'encoding'=>'UTF-8'));
                            $result = $client->PaymentVerification($parameters);
                        }catch (Exception $e) { echo 'Error'. $e->getMessage();  }

                        if ($result == 1){
                            UserModel::setSuccessClassPay($oId, $refcode);
							$data['title'] = "پرداخت موفق";
							$data['refcode'] = $refcode;
                            $data['msg'] = "تراکنش با موفقیت انجام شد";
							echo '
							<div class="container" style="margin-top:20px;">
								<div class="row">
									<div style="text-align: center; width:50%;margin: auto;background-color: #FF5F5F; padding: 0px; color:#fff;height: auto; border-radius: 10px 10px 0px 0px;padding: 5px 3px 5px 3px;color: #313131;box-shadow: 2px 1px 5px #999;"><span style="text-align:center; color:#ffffff; font-family:sans_bold; font-size:20px;">وضعیت تراکنش</span></div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color:  #ffe186; min-height:300px; border:1px solid #555; color:#000;  padding:15px; direction:rtl; text-align: right; border-radius:9px;">
									<h4 style="font-family:sans_bold;">'.$data['msg'].'</h4>
										<div style="margin: auto; font-size:20px; margin-bottom:10px; width:100%; margin-top:120px; directon:rtl; text-align:center;">
											کد پیگیری'. $data['refcode'].'
										</div>
									</div>
								</div>
							</div>
							';                    
						}
                        else{
                            $data['errCode'] = $result;
                            $data['msg'] = "پرداخت با خطا صورت گرفته است";
							echo '
								<div class="container" style="margin-top:20px;">
									<div class="row">
										<div style="text-align: center; width:50%;margin: auto;background-color: #FF5F5F; padding: 0px; color:#fff;height: auto; border-radius: 10px 10px 0px 0px;padding: 5px 3px 5px 3px;color: #313131;box-shadow: 2px 1px 5px #999;"><span style="text-align:center; color:#ffffff; font-family:sans_bold; font-size:20px;">وضعیت تراکنش</span></div>
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color:  #ffe186; min-height:300px; border:1px solid #555; color:#000;  padding:15px; direction:rtl; text-align: right; border-radius:9px;">
											<div style="margin: auto; margin-bottom:10px; font-size:20px; width:100%; margin-top:120px; text-align:center;">
												'.$data['msg'].'
											</div>
										</div>
									</div>
								</div>
							';
                        }
                    }
                }else{ // end of if order id
                    $data['msg'] = "این تراکنش قبلا انجام شده است";
                echo '
					<div class="container" style="margin-top:20px;">
						<div class="row">
							<div style="text-align: center; width:50%;margin: auto;background-color: #FF5F5F; padding: 0px; color:#fff;height: auto; border-radius: 10px 10px 0px 0px;padding: 5px 3px 5px 3px;color: #313131;box-shadow: 2px 1px 5px #999;"><span style="text-align:center; color:#ffffff; font-family:sans_bold; font-size:20px;">وضعیت تراکنش</span></div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color:  #ffe186; min-height:300px; border:1px solid #555; color:#000;  padding:15px; direction:rtl; text-align: right; border-radius:9px;">
								<div style="margin: auto; margin-bottom:10px; font-size:20px; width:100%; margin-top:120px; text-align:center;">
									'.$data['msg'].'
								</div>
							</div>
						</div>
					</div>
				';
                }
            }
            else{
                $data['msg'] = "پرداخت لغو شد";
                echo '
					<div class="container" style="margin-top:20px;">
						<div class="row">
							<div style="text-align: center; width:50%;margin: auto;background-color: #FF5F5F; padding: 0px; color:#fff;height: auto; border-radius: 10px 10px 0px 0px;padding: 5px 3px 5px 3px;color: #313131;box-shadow: 2px 1px 5px #999;"><span style="text-align:center; color:#ffffff; font-family:sans_bold; font-size:20px;">وضعیت تراکنش</span></div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color:  #ffe186; min-height:300px; border:1px solid #555; color:#000;  padding:15px; direction:rtl; text-align: right; border-radius:9px;">
								<div style="margin: auto; margin-bottom:10px; font-size:20px; width:100%; margin-top:120px; text-align:center;">
									'.$data['msg'].'
								</div>
							</div>
						</div>
					</div>
				';
            }
        }

        public static function callBackPak($merchantCode , $oId){
            if(isset($_POST['status']))
            {
                $order_id 	= validate_input($_POST['order_id']);
                $tran_id 	= validate_input($_POST['tran_id']);
                $amount 	= validate_input($_POST['amount']);
                $status 	= validate_input($_POST['status']);
                $refcode	= validate_input($_POST['refcode']);

                $orderInfo = UserModel::fetch_callback_pk($oId);
                if($orderInfo[0]['pay'] == "fail"){

                    if($status == 'paid' && $oId == $order_id)
                    {
                        $parameters = array	(
                            'webgate_id'	=> $merchantCode,	// Required
                            'tran_id' 		=> $tran_id,	// Required
                            'amount'	 	=> $amount		// Required
                        );
                        try {
                            $client = new SoapClient('http://startpay.ir/webservice/?wsdl' , array('soap_version'=>'SOAP_1_1','cache_wsdl'=>WSDL_CACHE_NONE ,'encoding'=>'UTF-8'));
                            $result = $client->PaymentVerification($parameters);
                        }catch (Exception $e) { echo 'Error'. $e->getMessage();  }

                        if ($result == 1){
                            UserModel::setSuccessPakPay($oId , $refcode);
							$data['title'] = "پرداخت موفق";
							$data['refcode'] = $refcode;
							$data['msg'] = "پرداخت با موفقیت انجام شد";
							echo '
							<div class="container" style="margin-top:20px;">
								<div class="row">
									<div style="text-align: center; width:50%;margin: auto;background-color: #FF5F5F; padding: 0px; color:#fff;height: auto; border-radius: 10px 10px 0px 0px;padding: 5px 3px 5px 3px;color: #313131;box-shadow: 2px 1px 5px #999;"><span style="text-align:center; color:#ffffff; font-family:sans_bold; font-size:20px;">وضعیت تراکنش</span></div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color:  #ffe186; font-size:20px; min-height:300px; border:1px solid #555; color:#000;  padding:15px; direction:rtl; text-align: center; border-radius:9px;">
									<h4 style="font-family:sans_bold;">'.$data['msg'].'</h4>
										<div style="margin: auto; margin-bottom:10px; font-size:20px; width:100%; margin-top:120px; directon:rtl; text-align:center;">
											 کد پیگیری'.  $data['refcode'].'
										</div>
									</div>
								</div>
							</div>
							';
                        }
                        else{
                            $data['errCode'] = $result;
                            $data['msg'] = "پرداخت با خطا صورت گرفته است";
							echo '
								<div class="container" style="margin-top:20px;">
									<div class="row">
										<div style="text-align: center; width:50%;margin: auto;background-color: #FF5F5F; padding: 0px; color:#fff;height: auto; border-radius: 10px 10px 0px 0px;padding: 5px 3px 5px 3px;color: #313131;box-shadow: 2px 1px 5px #999;"><span style="text-align:center; color:#ffffff; font-family:sans_bold; font-size:20px;">وضعیت تراکنش</span></div>
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color:  #ffe186; min-height:300px; border:1px solid #555; color:#000;  padding:15px; direction:rtl; text-align: right; border-radius:9px;">
											<div style="margin: auto; font-size:20px; margin-bottom:10px; width:100%; margin-top:120px; text-align:center;">
												'.$data['msg'].'
											</div>
										</div>
									</div>
								</div>
							';
                        }
                    }
                }else{ // end of if order id
					$data['msg'] = "این تراکنش قبلا انجام شده است";
					echo '
						<div class="container" style="margin-top:20px;">
							<div class="row">
								<div style="text-align: center; width:50%;margin: auto;background-color: #FF5F5F; padding: 0px; color:#fff;height: auto; border-radius: 10px 10px 0px 0px;padding: 5px 3px 5px 3px;color: #313131;box-shadow: 2px 1px 5px #999;"><span style="text-align:center; color:#ffffff; font-family:sans_bold; font-size:20px;">وضعیت تراکنش</span></div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color:  #ffe186; min-height:300px; border:1px solid #555; color:#000;  padding:15px; direction:rtl; text-align: right; border-radius:9px;">
									<div style="margin: auto; font-size:20px; margin-bottom:10px; font-size:20px; width:100%; margin-top:120px; text-align:center;">
										'.$data['msg'].'
									</div>
								</div>
							</div>
						</div>
					';
                }
            }
            else{
                $data['msg'] = "پرداخت لغو شد";
                echo '
					<div class="container" style="margin-top:20px;">
						<div class="row">
							<div style="text-align: center; width:50%;margin: auto;background-color: #FF5F5F; padding: 0px; color:#fff;height: auto; border-radius: 10px 10px 0px 0px;padding: 5px 3px 5px 3px;color: #313131;box-shadow: 2px 1px 5px #999;"><span style="text-align:center; color:#ffffff; font-family:sans_bold; font-size:20px;">وضعیت تراکنش</span></div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color:  #ffe186; min-height:300px; border:1px solid #555; color:#000;  padding:15px; direction:rtl; text-align: right; border-radius:9px;">
								<div style="margin: auto; font-size:20px; margin-bottom:10px; width:100%; margin-top:120px; text-align:center;">
									'.$data['msg'].'
								</div>
							</div>
						</div>
					</div>
				';
            }
        }

    } // end of class
?>