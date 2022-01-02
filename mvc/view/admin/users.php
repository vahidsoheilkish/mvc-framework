
<table class="table table-dark" style="width:85%; margin:10px auto; text-align:center;">
	<tr style="background-color:tomato;">
		<th>Username</th>
		<th>Password</th>
		<th>Wallet</th>
	</tr>
	<? foreach($users as $user): ?>
		<tr>
			<td><?= $user['username'] ?></td>
			<td><?= $user['password'] ?></td>
			<td><?= $user['wallet'] ?></td>
			<td><a href="<?=baseUri()?>/admin/user_edit/<?= $user['id'] ?>">Edit</a></td>
		</tr>
	<? endforeach ?>
</table>