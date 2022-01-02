<style>
	#dashboard_container{
		background-color:#eaeaea;
		min-height:400px;
		margin:auto;
		padding:0;
	}
	#header{
		background-color:#ccc;
		padding:5px;
		margin:0;
	}
	#list_header{
		margin:20px;
	}
	#tbl th{
		background-color:#60a7af;
		text-align:center;
	}
	#tbl td{
		text-align:center;
	}
	
</style>
<a href="<?=baseUri()?>/admin/users" style="color:black;">Users list</a>
<div class="container-fluid	">
	<div class="row">
		<div id="dashboard_container" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div id="header">
				<span style="font-size:26px;">Welcome to dashboard <i class="badge badge-secondary"><?= $admin ?></i></span>
				<span style="float:right;"><a href="<?=baseUri()?>/admin/logout"><button class="btn btn-sm btn-danger">Logout</button></span></a>
			</div>
			
			<div id="list_header">
				<h3>User list :</h3>
				<table id="tbl" class="table table-hover">
					<tr>
						<th>#</th>
						<th>Username</th>
						<th>Password</th>
						<th>Wallet</th>
					</tr>
					<? if($users == null )  $users = array()  ?>
					<? foreach($users as $user) : ?>
						<tr>
							<td><?= $user['id'] ?></td>
							<td><?= $user['username'] ?></td>
							<td><?= $user['password'] ?></td>
							<td class="table-success"><b><?= $user['wallet'] ?></b><button onclick="send(this)" id="id_<?=$user['id']?>_<?=$user['wallet']?>" data-toggle="modal" data-target=".change_wallet" style="float:right;" class="btn btn-sm btn-info">Edit</button> </td>
						</tr>
					<? endforeach ?>
				</table>
			</div>
			
			<div id="list_header">
				<h3>Ticket list :</h3>
				<table id="tbl" class="table table-hover">
					<tr>
						<th>#</th>
						<th>User id</th>
						<th>Passenger Name</th>
						<th>Passenger lastname</th>
						<th>Passenger age</th>
						<th>Flight from</th>
						<th>Flight Destination</th>
						<th>Flight date</th>
						<th>Flight time</th>
						<th>Flight price</th>
					</tr>
					<? foreach($tickets as $ticket) : ?>
						<tr>
							<td class="badge" style="line-height:2.5 !important;"><?= $ticket[0] ?></td>
							<td id="user_info_area" onclick="show_user_info(this);" onmouseleave="hide_user_info(this);">
								<span class="user_info">
									<pre id="set_userData"></pre>
								</span>
								<button class="btn btn-dark" title="click to show detail"><?= $ticket['user_id'] ?></button>
							</td>
							<td><?= $ticket['name'] ?></td>
							<td><?= $ticket['family'] ?></td>
							<td><?= $ticket['age'] ?></td>
							<td><?= $ticket['from'] ?></td>
							<td><?= $ticket['to'] ?></td>
							<td><?= $ticket['date'] ?></td>
							<td><?= $ticket['time'] ?></td>
							<td><?= $ticket['price'] ?></td>
						</tr>
					<? endforeach ?>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- Change Wallet -->
    <div class="modal fade change_wallet" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="padding:10px;">
                <h4 style="color:#222; padding:10px;">Change Wallet Value </h4>
				<table class="table">
					<tr>
						<td style="vertical-align:middle;">Wallet Value : </td>
						<td> <input type="text" id="wallet_value" class="form-control" /></td>
						<td style="vertical-align:middle; font-size:24px;">$</td>
						<td><input type="hidden" id="user_id" class="" /></td>
					</tr>
					<tr>
						<td><button id="btn_change_wallet" class="btn btn-success">Submit</button></td>
						<td></td>
					</tr>
				</table>
            </div>
        </div>
    </div>
	
	<script>
		function send(data){
			let str_id = $(data).attr('id');
			let str_arr = str_id.split('_');
			$("#user_id").val(str_arr[1]);
			$("#wallet_value").val(str_arr[2]);
		}
		
		$("#btn_change_wallet").click(function(){
			let id = $("#user_id").val();
			let wallet = $("#wallet_value").val();
			$.ajax({
				type : 'POST' ,
				url  : 'http://localhost/homework/admin/update_wallet' , 
				data : { id : id , wallet : wallet} ,
				success : function(data){
					if( data == 1){
						location.reload();
					}
				}
			});
		});
		
		function show_user_info(data){
			
			let id = $(data).children("button").html();
			$.ajax({
				'url' : 'http://localhost/homework/admin/get_userInfo' , 
				'type' : 'POST' , 
				'data' : { 'id' : id} ,
				'dataType' : 'json' ,
				'success' : function(res){
                    $(data).children("span").html("Username : " +res.username + "<br/>" + "Password : " + res.password + "<br/>" + "Wallet : " + res.wallet);
                    $(data).children("span").css("padding" , "5px");
                    $(data).children("span").fadeIn(1000);

				}
			});
			
		}
		
		function hide_user_info(data){
		    setTimeout(function(){
                $(data).children("span").slideUp(2000);
            },500);
		}
	</script>

