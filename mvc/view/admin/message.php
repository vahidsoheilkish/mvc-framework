<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin:20px auto; text-align:center;">
	<h4 class="bg <?=$err_type ?>" style="padding:10px;">
		<?= $msg ?>
		<button onclick="redirect();" class="btn btn-primary">Back</button>
	</h4>
</div>
<script>
	function redirect(){
		window.location.href = "http://localhost/homework/admin/login";
	}
</script>