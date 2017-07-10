<?php

	session_start();

	if (isset($_SESSION['Ad-Un-SESSION'])) {

		header('Location: Admin.php');
		exit();

	}
	
	include 'init.php'; 

?>

<div class="container">
<div class="Admin-Login">
	<h1 class="Page-First text-center">Admin Login</h1>
	<form class="form-group" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
 		<label>Username</label>
			<input class="form-control" type="text" name="Admin-Username">
 		<label>Password</label>
			<input class="form-control" type="password" name="Admin-Password">
		<input class="btn btn-primary btn-block" type="submit" name="Admin-SingIn" value="دخول">
	</form>
	<?php 

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		if (isset($_POST['Admin-SingIn'])) {

			$Admin_Username = $_POST['Admin-Username'];
			$Admin_pass = $_POST['Admin-Password'];
			$Admin_password = sha1($Admin_pass);

			$AdminSingInStmt = $con-> prepare("SELECT 
												  	User_ID, User_Name, User_Password 
											    FROM 
											   		users 
											   	WHERE 
											   		User_Name = ? 
											   	AND 
											   		User_Password = ? 
											   	AND 
											   		User_Group = 3
											 ");
			$AdminSingInStmt-> execute(array($Admin_Username, $Admin_password));
			$AdminCount = $AdminSingInStmt-> rowCount();

			if ($AdminCount > 0) {
				
				$AdminInfo = $AdminSingInStmt-> fetch();
				$_SESSION['Ad-Un-SESSION'] = $AdminInfo['User_Name'];
				$_SESSION['Ad-U-ID'] = $AdminInfo['User_ID'];

				header('Location: Admin.php');
				exit();

			} else {

				echo '<p class="alert alert-danger">عفاً تأكد من أسم المستخدم والرقم السري,,, أو أنه غير مخول لك الدخول الى هذه الصفحة</p>';

			}

		}

	}

?>
</div>
</div>

<?php include $TempDir . 'footer.php'; ?>