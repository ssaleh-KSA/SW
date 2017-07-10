<?php 

session_start();

if (isset($_SESSION['username'])) {

	header('Location: index.php');
	exit();

}

include 'init.php'; ?>

<?php

$userLo_Si = '';

if (isset($_GET['login'])) {

	$userLo_Si = $_GET['login'];

} else {

	$userLo_Si = 'login';

}

if ($userLo_Si == 'login') { ?>

<div class="container">
	<h1 class="Page-First text-center">تسجيل الدخول</h1>
	<article class="row">
		<aside class="col-lg-6 Sections-Articles">
			<div class="login-Page">
				<form class="form-group" action="<?php $_SERVER['PHP_SELF'] ?>" method='POST'>
					أسم المستخدم<input class="form-control" type="text" name="username" autocomplete="off">
					الرقم السري<input class="form-control" type="password" name="password">
					<input type="submit" class="btn btn-primary btn-block" name="login" value="دخول">
				</form>
			</div>
				لا تمتلك حساب سجل الأن <a href="login.php?login=SingUp" class="btn btn-primary"> مستخدم جديد</a><br>
				هل نسيت الرقم السري <a href="Profile.php?Profile=Forgot-Password"> نعم</a>
				<?php
					if ($_SERVER['REQUEST_METHOD'] == 'POST') {

						if(isset($_POST['login'])) {

							$username = $_POST['username'];
							$pass = $_POST['password'];
							$password = sha1($pass);

							$userloginStmt = $con-> prepare("SELECT User_ID, User_Name, User_Password, User_Group FROM users WHERE User_Name = ? AND User_Password = ?");
							$userloginStmt-> execute(array($username, $password));
							$info = $userloginStmt-> fetch();
							$count = $userloginStmt-> rowCount();

							if ($count > 0) {

								$_SESSION['username'] = $info['User_Name'];
								$_SESSION['UserID'] = $info['User_ID'];
								$_SESSION['User-Group'] = $info['User_Group'];
								header('Location: index.php');
								exit();

							} else {

								echo '<p class="alert alert-danger">أسم المستخدم أو كل السر غير صحيحة</p>';

							}
						}
					}
				?>
		</aside>
		<aside class="col-lg-6 left-aside">
			<div class="panel panel-success">
				<div class="panel-heading">
					أكثر المقالات مشاهدة
				</div>
				<div class="panel-body">
					<div class="panel panel-default"> 
						<div class="media">
							<div class="media-right">
								<a href="#">
									<img src="Layout/Images/image.jpeg" alt="Defualt Image" width="50px" height="60px">
								</a>
							</div>
							<div class="media-body">
								<h5>عنوان المقال</h5>
								<div>
									بواسطة <a href="Profile.php"> saleh234 </a> | بتاريخ <?php date_default_timezone_set('Asia/Riyadh'); echo date('Y d M'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-success">
				<div class="panel-heading">
					أكثر المقالات مشاهدة
				</div>
				<div class="panel-body">
					<div class="panel panel-default"> 
						<div class="media">
							<div class="media-right">
								<a href="#">
									<img src="Layout/Images/image.jpeg" alt="Defualt Image" width="50px" height="60px">
								</a>
							</div>
							<div class="media-body">
								<h5>عنوان المقال</h5>
								<div>
									بواسطة <a href="Profile.php"> saleh234 </a> | بتاريخ <?php date_default_timezone_set('Asia/Riyadh'); echo date('Y d M'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-success">
				<div class="panel-heading">
					أكثر المقالات مشاهدة
				</div>
				<div class="panel-body">
					<div class="panel panel-default"> 
						<div class="media">
							<div class="media-right">
								<a href="#">
									<img src="Layout/Images/image.jpeg" alt="Defualt Image" width="50px" height="60px">
								</a>
							</div>
							<div class="media-body">
								<h5>عنوان المقال</h5>
								<div>
									بواسطة <a href="Profile.php"> saleh234 </a> | بتاريخ <?php date_default_timezone_set('Asia/Riyadh'); echo date('Y d M'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-success">
				<div class="panel-heading">
					أكثر المقالات مشاهدة
				</div>
				<div class="panel-body">
					<div class="panel panel-default"> 
						<div class="media">
							<div class="media-right">
								<a href="#">
									<img src="Layout/Images/image.jpeg" alt="Defualt Image" width="50px" height="60px">
								</a>
							</div>
							<div class="media-body">
								<h5>عنوان المقال</h5>
								<div>
									بواسطة <a href="Profile.php"> saleh234 </a> | بتاريخ <?php date_default_timezone_set('Asia/Riyadh'); echo date('Y d M'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</aside>
	</article>
</div>

<?php

} elseif ($userLo_Si == 'SingUp') { ?>

<div class="container">
	<h1 class="Page-First text-center"> مستخدم جديد </h1>
	<article class="row">
		<aside class="col-lg-6 Sections-Articles">
			<div class="SingUp-Page">
				<form class="form-group" action="<?php $_SERVER['PHP_SELF'] ?>" method='POST' enctype="multipart/form-data">
					<label> أسم المستخدم </label>
					<input class="form-control" type="text" name="Username">
					<label> الرقم السري </label>
					<input class="form-control" type="password" name="Password">
					<label> الأيميل </label>
					<input class="form-control" type="email" name="Email">
					<label> الأسم كامل </label>
					<input class="form-control" type="text" name="FullName">
					<label> الجنسية </label>
					<input class="form-control" type="text" name="UserFrom">
					<label> العمر </label>
					<input class="form-control" type="text" name="UserAge">
					<label> الجنس </label>
					<select class="form-control" name="UserSex">
						<option value="0">---</option>
						<option value="1"> ذكر </option>
						<option value="2"> أنثى </option>
					</select>
					<label> صورة العرض </label>
					<input class="form-control" type="file" name="UserImage">
					<input class="btn btn-primary" type="submit" name="SingUp" value="تسجيل">
				</form>
			</div>
			<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		if(isset($_POST['SingUp'])) {

			// User Information Variable
			$Username 	= filter_var($_POST['Username'], FILTER_SANITIZE_STRING);
			$pass 		= filter_var($_POST['Password'], FILTER_SANITIZE_STRING);
			$Password 	= sha1($pass);
			$Email 		= filter_var($_POST['Email'], FILTER_SANITIZE_EMAIL);
			$FullName 	= filter_var($_POST['FullName'], FILTER_SANITIZE_STRING);
			$UserFrom 	= filter_var($_POST['UserFrom'], FILTER_SANITIZE_STRING);
			$UserAge 	= filter_var($_POST['UserAge'], FILTER_SANITIZE_NUMBER_INT);
			$UserSex 	= $_POST['UserSex'];

			// User Image Information
			$ImageName = $_FILES['UserImage']['name'];
			$ImageType = $_FILES['UserImage']['type'];
			$ImageTmp_Name = $_FILES['UserImage']['tmp_name'];
			$ImageSize = $_FILES['UserImage']['size'];

			// Image Extension Allowed List
			$ImageAllowedExtension = array('jpg', 'jpeg', 'png', 'bmp', 'tiff', 'gif');
			// Conversion From UpperCase To LowerCase
			$ImageToLo = strtolower($ImageName);
			// Conversion Image Name To Array With explode
			$ImageExplode = explode('.', $ImageToLo);
			// Get The End From The Image Name Array
			$ImageExplodeEnd = end($ImageExplode);

			$UserInfoError = array();

			if (strlen($Username) < 4) {
				$UserInfoError[] = 'أسم المستخدم يجب أن يكون أكبر من 4 حروف';
			}
			if (strlen($Username) > 20) {
				$UserInfoError[] = 'أسم المستخدم يجب أن لا يكون أكبر من 20 حرف';
			}
			if (empty($Username)) {
				$UserInfoError[] = 'أسم المستخدم يجب أن لا يكون فارغاً';
			}
			if (empty($Password)) {
				$UserInfoError[] = 'الرقم السري يجب أن لا يكون فارغاً';
			}
			if (empty($Email)) {
				$UserInfoError[] = 'الأيميل يجب أن لا يكون فارغاً';
			}
			if (empty($FullName)) {
				$UserInfoError[] = 'الأسم الكامل يجب أن لا يكون فارغاً';
			}
			if (empty($UserFrom)) {
				$UserInfoError[] = 'الجنسية يجب أن لا يكون فارغاً';
			}
			if (empty($UserAge)) {
				$UserInfoError[] = 'العمر يجب أن لا يكون فارغاً';
			}
			if ($UserSex == 0) {
				$UserInfoError[] = 'الجنس يجب أن لا يكون فارغاً';
			}
			if (!empty($ImageName) && !in_array($ImageExplodeEnd, $ImageAllowedExtension)) {
				$UserInfoError[] = 'أمتداد الصورة غير مسموح به أبحث عن صورة يكون أمتدادها " jpg - jpeg - png - bmp - tiff - gif "';
			}
			if ($ImageSize > 4194304) {
				$UserInfoError[] = 'حجم الصورة كبير جدا أضف صورة حجمها يكون أقل من 4MB';
			}

			foreach ($UserInfoError as $UserError) {
				echo "<div class='alert alert-danger'>" . $UserError . "</div>";
			}

			if (empty($UserInfoError)) {
				// Add Random Number To Image Name
				$Image = rand(0, 100000) . '_' . $ImageName;
				// Chang Path $_FILES['image']['tmp_name']; To My Path, "../uploads/images/" Folders I Created In admin Folder
			 	move_uploaded_file($ImageTmp_Name, 'Uploads/Images/' . $Image);

			 	$CheckUser = $con-> prepare("SELECT User_Name FROM users WHERE User_Name = ?");
			 	$CheckUser -> execute(array($Username));

			 	$Count = $CheckUser-> rowCount();

			 	if ($Count == 1) {

			 		echo "<div class='alert alert-danger'>أسم المستخدم هذا مستخدم من قبل</div>";

			 	} else {

					$UserAddStmt = $con-> prepare("INSERT INTO users(User_Name, User_Password, User_Email, User_FullName, User_Group, 												 User_From, User_Age, User_Sex, Reg_Date, User_Image, User_Following, User_Followers, Alerts)
												   VALUES (:name, :pass, :email, :fullname, 1, :userfrom, :age, :sex, now(), :image, :Followers, :Folloing, :Alerts)");
					$UserAddStmt-> execute(array(

						'name' 		=> $Username,
						'pass' 		=> $Password,
						'email' 	=> $Email,
						'fullname' 	=> $FullName,
						'userfrom' 	=> $UserFrom,
						'age' 		=> $UserAge,
						'sex' 		=> $UserSex,
						'image' 	=> $Image,
						'Followers' => '0,',
						'Folloing' 	=> '0,',
						'Alerts' 	=> '1'

					));

					echo "<div class='alert alert-success'>تم تسجيلك بنجاح مرحباً بك... <a class='btn btn-primary' href='login.php'> سجل دخولك </a></div>";

			 	}

			}

		}

	}
	?>
		</aside>
		<aside class="col-lg-6 left-aside">
			<div class="panel panel-success">
				<div class="panel-heading">
					أكثر المقالات مشاهدة
				</div>
				<div class="panel-body">
					<div class="panel panel-default"> 
						<div class="media">
							<div class="media-right">
								<a href="#">
									<img src="Layout/Images/image.jpeg" alt="Defualt Image" width="50px" height="60px">
								</a>
							</div>
							<div class="media-body">
								<h5>عنوان المقال</h5>
								<div>
									بواسطة <a href="Profile.php"> saleh234 </a> | بتاريخ <?php date_default_timezone_set('Asia/Riyadh'); echo date('Y d M'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-success">
				<div class="panel-heading">
					أكثر المقالات مشاهدة
				</div>
				<div class="panel-body">
					<div class="panel panel-default"> 
						<div class="media">
							<div class="media-right">
								<a href="#">
									<img src="Layout/Images/image.jpeg" alt="Defualt Image" width="50px" height="60px">
								</a>
							</div>
							<div class="media-body">
								<h5>عنوان المقال</h5>
								<div>
									بواسطة <a href="Profile.php"> saleh234 </a> | بتاريخ <?php date_default_timezone_set('Asia/Riyadh'); echo date('Y d M'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-success">
				<div class="panel-heading">
					أكثر المقالات مشاهدة
				</div>
				<div class="panel-body">
					<div class="panel panel-default"> 
						<div class="media">
							<div class="media-right">
								<a href="#">
									<img src="Layout/Images/image.jpeg" alt="Defualt Image" width="50px" height="60px">
								</a>
							</div>
							<div class="media-body">
								<h5>عنوان المقال</h5>
								<div>
									بواسطة <a href="Profile.php"> saleh234 </a> | بتاريخ <?php date_default_timezone_set('Asia/Riyadh'); echo date('Y d M'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-success">
				<div class="panel-heading">
					أكثر المقالات مشاهدة
				</div>
				<div class="panel-body">
					<div class="panel panel-default"> 
						<div class="media">
							<div class="media-right">
								<a href="#">
									<img src="Layout/Images/image.jpeg" alt="Defualt Image" width="50px" height="60px">
								</a>
							</div>
							<div class="media-body">
								<h5>عنوان المقال</h5>
								<div>
									بواسطة <a href="Profile.php"> saleh234 </a> | بتاريخ <?php date_default_timezone_set('Asia/Riyadh'); echo date('Y d M'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</aside>
	</article>
</div>

<?php

} else {

	header('Location: index.php');
	exit();

}

?>

<?php

?>

<?php include $TempDir . 'footer.php'; ?>