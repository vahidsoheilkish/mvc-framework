<html>
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" type="text/css" href="<?= baseUri(); ?>/asset/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="<?= baseUri(); ?>/asset/css/fontawesome-all.css"/>
    <link rel="stylesheet" type="text/css" href="<?= baseUri() ?>/asset/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?= baseUri() ?>/asset/bootstrap/css/bootstrap-grid.min.css"/>
    <script src="<?= baseUri() ?>/asset/js/jquery-1.11.3.min.js"></script>
    <script src="<?=baseUri()?>/asset/js/index.js"></script>
    <script src="<?=baseUri()?>/asset/js/fontawesome-all.js"></script>
    <script src="<?= baseUri() ?>/asset/bootstrap/js/bootstrap.min.js"></script>
    <title>
        <?php
            if(isset($title)){
                echo $title;
            }
        ?>
    </title>

</head>
<body>
<a href="<?=baseUri()?>/admin/login" id="home_icon"><i class="fa fa-1x fa-user"></i><i style="margin:0 3px;">Admin Panel</i></a>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-8 col-xs-12 mt-10">
                <a href="<?=baseUri()?>" id="home_icon"><i class="fa fa-3x fa-home"></i><i style="margin:0 3px;">Home</i></a>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
            </div>
            <div id="menu_container" class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mt-10">
                <?php if( !$user ){ ?>
                    <span style="padding:0 10px; margin:0 5px;">
                        <span class="fa fa-arrow-right"></span>
                        <a href="#" data-toggle="modal" data-target=".login_btn">Login</a>
                    </span>
                    <span style="padding:0 10px;  margin:0 5px;">
                        <span class="fa fa-user-plus"></span>
                        <a href="#" data-toggle="modal" data-target="#register_btn">Register</a>
                    </span>
                <?php }else{ ?>
                    <span style="padding:0 10px; margin:0 5px;">
                        <span class="fa fa-arrow-left"></span>
                            <a href="<?=baseUri()?>/user/logout">Sign out</a>
                        </span>
                    <span style="padding:0 10px;  margin:0 5px;">
                        <span class="fa fa-chalkboard"></span>
                        <a id="panel" href="#">Panel</a>
                        <ul id="user_submenu">
                            <li style="border-bottom:1px solid #fff;">Wallet: <b style="color:#25ffb5"><?= $wallet ?></b> $</li>
                            <li><a href="<?=baseUri()?>/user/buyTicket"><strong>Buy ticket</strong></a></li>
                            <li><a href="#" data-toggle="modal" data-target=".change_password_btn">Change Password</a></li>
                            <li><a href="<?=baseUri()?>/user/logout">Sign out</a></li>
                        </ul>
                    </span>
                <?php } ?>
            </div>
        </div>

        <div class="row">
            <?= $content ?>
        </div>
    </div>

<!--    <button data-toggle="modal" data-target=".err_btn" style="display: block;">err</button>-->
    <!-- Err Modal -->
    <div class="modal fade err_btn" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div id="err_modal" class="modal-dialog modal-sm">
            <div class="modal-content" style="padding:10px;">
                <h4 id="err_message" style="color:#222"></h4>
            </div>
        </div>
    </div>

<!-- Login Modal -->
    <div class="modal fade login_btn" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" style="padding:10px;">
                <h4 style="color:#222">Login</h4>
                <table class="table table-responsive">
                    <tr>
                        <td class="black" style="width: 10%;">Username</td>
                        <td><input type="text" class="form-control" id="login_username"/></td>
                    </tr>
                    <tr>
                        <td class="black" style="width: 10%;">Password</td>
                        <td><input type="password" class="form-control" id="login_password"/></td>
                    </tr>
                    <tr>
                        <td><button type="button" id="btn_login" class="btn btn-success">Login</button></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade change_password_btn" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="padding:10px;">
                <h4 style="color:#222">Change password</h4>
                <table class="table table-responsive">
                    <tr>
                        <td class="black" style="width: 30%;">Old password</td>
                        <td><input type="text" class="form-control" id="change_pwd_old"/></td>
                    </tr>
                    <tr>
                        <td class="black" style="width: 30%;">New password</td>
                        <td><input type="password" class="form-control" id="change_pwd_new"/></td>
                    </tr>
                    <tr>
                        <td class="black" style="width: 30%;">Confirm new password</td>
                        <td><input type="password" class="form-control" id="change_pwd_new2"/></td>
                    </tr>
                    <tr>
                        <td><button type="button" id="btn_change_password" class="btn btn-warning">Change password</button></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade" id="register_btn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel" style="color:#222;">Register</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <table class="table table-responsive">
                  <tr>
                      <td class="black" style="width: 20%;">Username</td>
                      <td><input type="text" class="form-control" id="reg_username"/></td>
                  </tr>
                  <tr>
                      <td class="black" style="width: 20%;">Password</td>
                      <td><input type="password" class="form-control" id="reg_password"/></td>
                  </tr>
                  <tr>
                      <td class="black" style="width: 20%;">Confirm password</td>
                      <td><input type="password" class="form-control" id="reg_password2"/></td>
                  </tr>
              </table>
          </div>
          <div class="modal-footer">
              <button type="button" id="btn_register" class="btn btn-primary">Register</button>
          </div>
        </div>
      </div>
    </div>

    <script>
        $(document).ready(function(){
            $("#panel").mouseenter(function(){
                $("#user_submenu").css('display' , 'block');
            });

            $("#menu_container").mouseleave(function(){
                $("#user_submenu").css('display' , 'none');
            });
        });

        $("#btn_login").click(function(){
            let username = $("#login_username").val();
            let password = $("#login_password").val();
            $.ajax({
                type : 'POST' ,
                url : "http://localhost/homework/user/login" ,
                data : {username : username , password : password} ,
                dataType : 'json' ,
                success: function(data){
                    if(data.status === true){
                        location.reload();
                    }else{
                        alert("Invalid username and password");
                    }
                }
            });
        });

        $("#btn_change_password").click(function(){
            let old = $("#change_pwd_old").val();
            let new1 = $("#change_pwd_new").val();
            let new2 = $("#change_pwd_new2").val();
            $.ajax({
                type : 'POST' ,
                url : "http://localhost/homework/user/change_password" ,
                data : {old : old , new1 : new1 , new2 : new2 } ,
                success: function(data){
                    if(data === "ok"){
                        alert("Password changed");
                        location.reload();
                    }else{
                        alert(data);
                    }
                }
            });
        });

        $("#btn_register").click(function(){
            let username = $("#reg_username").val();
            let password = $("#reg_password").val();
            let password2 = $("#reg_password2").val();
            $.ajax({
                type : 'POST' ,
                url : "http://localhost/homework/user/register" ,
                data : {username : username , password : password , password2 : password2} ,
                success: function(data){
                    alert(data);
                }
            });
        });
    </script>
</body>
</html>