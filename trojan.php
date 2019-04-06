<?php  

/**
Project: KaraKata
Author: Tijani Mustapha
Company: Programas Hub
Date: 3, April 2019
Project Functions: 
	view/verify/ban seller
	View all transaction log
**/

	include_once 'inc/conn.php';


	function ban_seller($seller_id)
	{
		Global $conn;
		$query = $conn->query("UPDATE `user` SET `status` = 0  WHERE `user_id` = '$seller_id' ") ;
		if ($query) {
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function verify_seller($seller_id)
	{
		Global $conn;
		$query = $conn->query("UPDATE `user` SET `status` = 1  WHERE `user_id` = '$seller_id' ") ;
		if ($query) {
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}


	function fetch_sellers()
	{
		Global $conn;
		$query = $conn->query("SELECT * FROM `user` JOIN `gender` on `gender`.`gender_id` = `user`.`gender_id`
							WHERE `user_type_id` = 2 ORDER BY `user_id` DESC ") ;
		if ($query->num_rows > 0) {
			while ($row = $query->fetch_assoc()){
				$ret[] = $row;
				return $ret;
			}
		}
	}
	function fetch_transaction_log()
	{
		Global $conn;
		$query = $conn->query("SELECT * FROM `transaction_log` JOIN `user` on `user`.`user_id` = `transaction_log`.`user_id`
							JOIN `product` on `product`.`product_id` = `transaction_log`.`product_id`
							ORDER BY `transaction_id` DESC ") ;
		if ($query->num_rows > 0) {
			while ($row = $query->fetch_assoc()){
				$ret[] = $row;
				return $ret;
			}
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Trojan</title>
</head>
<body>

	<table>
		<tr>
			<th>Surname</th>
			<th>Other names</th>
			<th>Username</th>
			<th>Status</th>
		</tr>

		<?php
			foreach (fetch_sellers() as $row) {
		?>
		<tr>
			<td><?php echo $row["surname"] ?></td>
			<td><?php echo $row["othername"] ?></td>
			<td><?php echo $row["username"] ?></td>
			<td> 
				<?php if ($row["status"] == 0): ?>
					<a href="#">Activate</a>
				<?php endif ?>

				<?php if ($row["status"] == 1): ?>
					<a href="#">Ban</a>
				<?php endif ?>

			</td>
		</tr>
		<?php } var_dump(fetch_transaction_log()) ?>
</body>
</html>

