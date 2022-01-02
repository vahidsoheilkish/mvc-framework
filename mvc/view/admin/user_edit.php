<h2>Edit user</h2>
<form action="<?=baseUri()?>/admin/editUser" method="post">
	<input type="hidden" value="<?= $user[0]['id']?>" name="txt_id" />
	<table class="table table-light" style="width:85%; margin:10px auto; text-align:center;">
		<tr style="background-color:#f6f6f6;">
			<th>Username</th>
			<th>Password</th>
			<th>Wallet</th>
		</tr>
			<tr>
				<td><input type="text" name="txt_username" value="<?= $user[0]['username'] ?>" class="form-control" /></td>
				<td><input type="text" name="txt_password" value="<?= $user[0]['password'] ?>" class="form-control" /></td>
				<td><input type="text" name="txt_wallet" value="<?= $user[0]['wallet'] ?>" class="form-control" /></td>
			</tr>
		
	</table>
	<div style="text-align:center"><button type="submit" class="btn btn-success" style="margin-left:40px auto;">Update</button></div>
</form>