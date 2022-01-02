<div id="admin_login_container" class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
	<h4 style="padding:10px; margin:0; background-color:#909090; border-radius:10px; color:#f1f1f1; text-align:l;">Administrator Login</h4>
	<form action="<?=baseUri()?>/admin/confirm" method="POST">
		<table class="table">
			<tr>
				<td>Username</td>
				<td><input type="text" name="admin_username" class="form-control" /></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="password" name="admin_password" class="form-control" /></td>
			</tr>
			<tr>
				<td><input type="submit" name="btn_submit" value="Login" class="btn btn-primary" /></td>
				<td style="vertical-align:bottom; text-align:right;"><a href="<?=baseUri()?>/" style="color:#000 !important; text-align:right;"><i class="fa fa-home" style="margin:0 3px;"></i>Back to home</a></td>
			</tr>
		</table>
	</form>
</div>