<?php if ( $user !== '')  { 	?>
	<div id="tickets" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div id="tickets_header" class="">
			<i class="fa fa-check"></i>
			Reserve ticket
		</div>
		<table class="table table-hover" id="tbl_reserve">
			<tr>
				<th>From</th>
				<th>To</th>
				<th>Date</th>
				<th>Time</th>
				<th>Price</th>
				<th>Option</th>
			</tr>
			<? if($flights == null ) $flights = array()  ?>
			<? foreach($flights as $flight) : ?>
				<tr>
					<td><?= $flight['from'] ?></td>
					<td><?= $flight['to'] ?></td>
					<td><?= $flight['date'] ?></td>
					<td><?= $flight['time'] ?></td>
					<td><?= $flight['price'] ?></td>
					<td><button data-toggle="modal" onclick="send(this)" data-value="<?= $flight['id'] ?>" data-target=".reserve_ticket" class="btn btn-sm btn-primary">Reserve</button</td>
				</tr>
			<? endforeach ?>
		</table>
	</div>
<?php }else{ ?>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:150px;">
		<div id="tickets_header_err" class="tac">
			<i class="fa fa-exclamation-triangle"></i>
			<span>Error, you should login first...</span>
		</div>
	</div>
<?php } ?>

<!-- Reserve Ticket -->
    <div class="modal fade reserve_ticket" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="padding:10px;">
                <h4 style="color:#222; padding:10px;">Passenger info : </h4>
				<table class="table">
					<tr>
						<td style="width:10%;"><label class="black">Name</label></td>
						<td><input type="text" id="passenger_name" class="form-control" /></td>
					</tr>
					<tr>
						<td style="width:10%;"><label  class="black">Family</label></td>
						<td><input type="text" id="passenger_lastname" class="form-control" /></td>
					</tr>
					<tr>
						<td style="width:10%;"><label  class="black">Age</label></td>
						<td><input type="text" id="passenger_age" class="form-control" /></td>
						<td><input type="hidden" id="flight_id" class="form-control" /></td>
					</tr>
					<tr>
						<td><button id="btn_submit_passenger" class="btn btn-success">Reserve</button></td>
						<td></td>
					</tr>
				</table>
            </div>
        </div>
    </div>
	
	<script>
		function send(row){
			let flight_id = $(row).attr('data-value');
			$("#flight_id").val(flight_id);
		}
		
		$("#btn_submit_passenger").click(function(){
			let name = $("#passenger_name").val();
			let last_name = $("#passenger_lastname").val();
			let age = $("#passenger_age").val();
			let flight_id = $("#flight_id").val();
			if(name == "" || last_name == "" || age == "") {
				alert("Error, enter all fields correctly...");
				return false;
			}
			if( age < 0 || age > 90){
				alert("Invalid age value");
				return false;
			}
			
			$.ajax( {
				"url" : "http://localhost/homework/user/passenger_ticket" ,
				"type" : "POST" ,
				"data" : { flight_id : flight_id , "name" : name , "last_name" : last_name , "age" : age } ,
				success : function(data){
					if(data == 1){
						alert("Ticket paid");
						location.reload();
					}
				}
			} );
		});
	</script>