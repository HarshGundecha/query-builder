<?php
	require_once("controller.php");
?>
<html>
	<head>
		<title></title>
	</head>
	<body>

		<?php
			if($userData == 0 || $userData == 1)
			{
				echo 'no data found';
			}
			else
			{
		?>

				<table>
					<tr>
						<td>Username</td>
						<td>Password</td>
					</tr>

		<?php
				foreach ($userData as $key)
				{
		?>
					<tr>
						<td><?php echo $key->username; ?></td>
						<td><?php echo $key->password; ?></td>
					</tr>
		<?php
				}
			}
		?>
		</table>
	</body>
</html>