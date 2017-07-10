<?php

	session_start();

	include 'init.php'; 

?>

<?php 

$Art = '';

if (isset($_GET['Art'])) {

	$Art = $_GET['Art'];

} else {

	$Art = 'MainPage';

}

	$CulArtInfoStmt = $con-> prepare("SELECT 
										culture.*,
										users.User_Name AS UserWrite
									 FROM 
									 	culture 
									 JOIN 
									 	users 
									 ON 
									 	users.User_ID = culture.Cul_Write
									 ORDER BY 
									 	Cul_Time
									 DESC
									 ");
	$CulArtInfoStmt-> execute();
	$Count = $CulArtInfoStmt-> rowCount();

// MainPage Page Start
if ($Art == 'MainPage') { ?>

	<div class="container">
			<h1 class="Section-heading">الثقافة</h1>
			<article class="row">
				<aside class="col-lg-8 Sections-Articles">
					<div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
						<a href="culture.php?Art=Cul-Add" class="btn btn-primary btn-block"> أضافة مقال <i class="fa fa-plus"></i></a>
					</div>
<?php

	if ($Count > 0) { 

		$ArtInfo = $CulArtInfoStmt-> fetchAll(); 

						foreach ($ArtInfo as $Info) {

							echo '<div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">';
								echo '<a href="Articles.php?Art=Culture-Articles&ArtID='. $Info['Cul_ID'] .'">';
									echo '<div class="Article-box">';
										echo '<h4>' . $Info["Cul_Name"] . '</h4>';
										echo '<span>كاتب المقال</span><a href="UserProfile.php?UserWriteID='. $Info['Cul_Write'] .'">' . $Info["UserWrite"] . '</a><br>';
										echo '<span>تاريخ النشر</span>' . $Info["Cul_Date"] . ' | ';
										if ($Info["Cul_Time"] > 12) {
											echo '<span>الساعة ';
											echo $Info["Cul_Time"] - 12 . ' مساءً';
											echo "</span>";
										} elseif ($Info["Cul_Time"] == 00) {

											echo '<span>الساعة ';
											echo $Info["Cul_Time"] + 12 . ' صباحاً';
											echo "</span>";

										} else {
											echo '<span>الساعة ';
											echo $Info["Cul_Time"] - 1 + 1 . ' صباحاً';
											echo "</span>";
										}
									echo '</div>';
								echo '</a>';
							echo '</div>';

						}

	} else {

		echo "<div class='col-lg-12 container alert alert-warning'>لا يوجد مقالات</div>";

	}

?>
				</aside>
				<aside class="col-lg-4 left-aside">
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
// MainPage Page Start
// Cul-Add Page Start
} elseif ($Art == 'Cul-Add') {

	if (isset($_SESSION['username'])) { ?>

	<h1 class="Page-First text-center">أضافة مقال في الثقافة</h1>
	<div class="container">
		<article class="row">
			<aside class="col-lg-8 Sections-Articles">
				<form class="input-textarea form-group" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
   					<label>أسم المقال</label>
						<input class="form-control" type="text" name="Article-Name" required="required">
   					<label>صورة المقال</label>
						<input class="form-control" type="file" name="Article-Image" required="required">
   					<label>تفاصيل المقال</label>
						<textarea class="form-control" name="Article-Details"></textarea required="required">
   					<label>تصنيف المقال</label>
						<select class="form-control" name="Article-Parent" required="required">
							<option value="0">---</option>
							<option value="1">المسرح والسينما</option>
							<option value="2">الموسيقى</option>
							<option value="3">الأدب والفنون</option>
							<option value="4">المتاحف والمهرجانات</option>
							<option value="5">الإعلام</option>
							<option value="6">المطبخ</option>
						</select>
   					<label>فيديوهات  للمقال</label>
						<input class="form-control" type="text" name="Article-Video">
						<input class="btn btn-primary btn-block" type="submit" name="send" value="أضافة المقال">
					</form>
			</aside>
			<aside class="col-lg-4 left-aside">
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



	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$ArtCulName = filter_var($_POST['Article-Name'], FILTER_SANITIZE_STRING);
		$ArtCulDetails = filter_var($_POST['Article-Details'], FILTER_SANITIZE_STRING);
		$ArtCulParent = $_POST['Article-Parent'];
		// Article Image Varicabls
		$ArtImageName = $_FILES['Article-Image']['name'];
		$ArtImageType = $_FILES['Article-Image']['type'];
		$ArtImageTmp = $_FILES['Article-Image']['tmp_name'];
		$ArtImageSize = $_FILES['Article-Image']['size'];

		// Videos Variable
		$ArtVideo = filter_var($_POST['Article-Video'], FILTER_SANITIZE_URL);

		$ImageAllwedExtension = array('jpg', 'jpeg', 'png', 'bmp', 'tiff', 'gif');
		// Article Image Varicabls For Uplode
		$ArtImNameToLo = strtolower($ArtImageName);
		$ArtImNameExplode = explode('.', $ArtImNameToLo);
		$ArtImNameExplodeEnd = end($ArtImNameExplode);

		$AddArtCulError = array();
		if (empty($ArtCulName)) {
			$AddArtCulError[] = 'أسم المقال يجب أن لا يكون فارغاً';
		}
		if (empty($ArtImageName)) {
			$AddArtCulError[] = 'صورة المقال يجب أن لا تكون فارغه';
		}
		if (empty($ArtCulDetails)) {
			$AddArtCulError[] = 'تفاصيل المقال يجب أن لا تكون فارغه';
		}
		if ($ArtCulParent == 0) {
			$AddArtCulError[] = 'يجب أن تختار تصنيف المقال';
		}
		if (!empty($ArtImageName) && !in_array($ArtImNameExplodeEnd, $ImageAllwedExtension)) {
			$AddArtCulError[] = 'يجب ان يكون أمتداد الصورة فقط أحدى هذه الأمتدادات " jpg - jpeg - png - bmp - tiff - gif "';
		}
		if ($ArtImageSize > 4194304) {
				$UserInfoError[] = 'حجم الصورة كبير جدا أضف صورة حجمها يكون أقل من 4MB';
		}

		foreach ($AddArtCulError as $AddCulError) {
			echo "<div class='container alert alert-danger'>" . $AddCulError . "</div>";
		}

		if (empty($AddArtCulError)) {

			$Artimage = rand(0, 100000) . '_' . $ArtImageName;
		 	move_uploaded_file($ArtImageTmp, 'Uploads/Images/' . $Artimage);

		 	if (empty($ArtVideo)) {
		 		$ArtVideo = 'لا يوجد فيديو';
		 	}

			$AddArtCulStmt = $con-> prepare("INSERT INTO culture(Cul_Name, Cul_Image, Cul_Write, Cul_Date, Cul_Time, Cul_Details, Cul_Parent, Cul_Videos, alerts) 
														VALUES(:CulName, :CulImage, :CulWrite, now(), now(), :CulDetails, :CulParent, :CulVideos, :alerts)");
			$AddArtCulStmt-> execute(array(

				'CulName' => $ArtCulName,
				'CulImage' => $Artimage,
				'CulWrite' => $_SESSION['UserID'],
				'CulDetails' => $ArtCulDetails,
				'CulParent' => $ArtCulParent,
				'CulVideos' => $ArtVideo,
				'alerts' 	=> '1'

			));

			echo "<div class='container alert alert-success'>تم أضافة مقالك بنجاح</div>";

		}

	}
} else {
	header('Location: login.php');
	exit();
}

// Cul-Add Page End
// Cul-Edit Page Start
} elseif ($Art == 'Cul-Edit') {

	$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;

	$ArtEditStmt = $con-> prepare("SELECT * FROM culture WHERE Cul_ID = ?");
	$ArtEditStmt-> execute(array($ArtID));
	$Count = $ArtEditStmt-> rowCount();

	if ($Count > 0) {

		$ArtInfo = $ArtEditStmt-> fetch();

		if (isset($_SESSION['username'])) { ?>

			<h1 class="Page-First text-center">تعديل مقال في الثقافة</h1>
			<div class="container">
				<article class="row">
					<aside class="col-lg-8 Sections-Articles">
						<form class="input-textarea form-group" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
		   					<label>أسم المقال</label>
								<input class="form-control" type="text" name="Article-Name" required="required" value="<?php echo $ArtInfo['Cul_Name'] ?>">
		   					<label>صورة المقال</label>
		   						<h5>الصورة الأصلية</h5>
		   						<div>
		   							<img src="Uploads/Images/<?php echo $ArtInfo['Cul_Image'] ?>" width="100px" height="100px">
		   						</div>
		   						<h5>عدل الصورة</h5>
								<input class="form-control" type="file" name="Article-Image">
		   					<label>تفاصيل المقال</label>
		   						<div class="textarea-Edit">
		   							<h5>المقال الأصلي</h5>
		   							<?php echo $ArtInfo['Cul_Details'] ?>
		   						</div>
		   						<h5>عدل المقال</h5>
								<textarea class="form-control" name="Article-Details"></textarea>
							<label>تصنيف المقال</label>
								<select class="form-control" name="Article-Parent" required="required">
									<option value="0">---</option>
									<option value="1" <?php if ($ArtInfo['Cul_Parent'] == 1) {echo 'selected';} ?>>المسرح والسينما</option>
									<option value="2" <?php if ($ArtInfo['Cul_Parent'] == 2) {echo 'selected';} ?>>الموسيقى</option>
									<option value="3" <?php if ($ArtInfo['Cul_Parent'] == 3) {echo 'selected';} ?>>الأدب والفنون</option>
									<option value="4" <?php if ($ArtInfo['Cul_Parent'] == 4) {echo 'selected';} ?>>المتاحف والمهرجانات</option>
									<option value="5" <?php if ($ArtInfo['Cul_Parent'] == 5) {echo 'selected';} ?>>الإعلام</option>
									<option value="6" <?php if ($ArtInfo['Cul_Parent'] == 6) {echo 'selected';} ?>>المطبخ</option>
								</select>
		   					<label>فيديوهات  للمقال</label>
								<input class="form-control" type="text" name="Article-Video" value="<?php echo $ArtInfo['Cul_Videos'] ?>">
								<input class="btn btn-primary btn-block" type="submit" name="send" value="أضافة المقال">
							</form>
					</aside>
					<aside class="col-lg-4 left-aside">
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
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$ArtCulName = filter_var($_POST['Article-Name'], FILTER_SANITIZE_STRING);
			$ArtCulDetails = filter_var($_POST['Article-Details'], FILTER_SANITIZE_STRING);
			$ArtCulParent = $_POST['Article-Parent'];
			// Article Image Varicabls
			$ArtImageName = $_FILES['Article-Image']['name'];
			$ArtImageType = $_FILES['Article-Image']['type'];
			$ArtImageTmp = $_FILES['Article-Image']['tmp_name'];
			$ArtImageSize = $_FILES['Article-Image']['size'];

			// Videos Variable
			$ArtVideo = filter_var($_POST['Article-Video'], FILTER_SANITIZE_URL);

			$ImageAllwedExtension = array('jpg', 'jpeg', 'png', 'bmp', 'tiff', 'gif');
			// Article Image Varicabls For Uplode
			$ArtImNameToLo = strtolower($ArtImageName);
			$ArtImNameExplode = explode('.', $ArtImNameToLo);
			$ArtImNameExplodeEnd = end($ArtImNameExplode);

			$AddArtCulError = array();
			if (empty($ArtCulName)) {
				$AddArtCulError[] = 'أسم المقال يجب أن لا يكون فارغاً';
			}
			if (empty($ArtCulDetails)) {
				$ArtCulDetails = $ArtInfo['Cul_Details'];
			}
			if ($ArtCulParent == 0) {
				$AddArtCulError[] = 'يجب أن تختار تصنيف المقال';
			}
			if (!empty($ArtImageName) && !in_array($ArtImNameExplodeEnd, $ImageAllwedExtension)) {
				$AddArtCulError[] = 'يجب ان يكون أمتداد الصورة فقط أحدى هذه الأمتدادات " jpg - jpeg - png - bmp - tiff - gif "';
			}
			if ($ArtImageSize > 4194304) {
					$UserInfoError[] = 'حجم الصورة كبير جدا أضف صورة حجمها يكون أقل من 4MB';
			}

			foreach ($AddArtCulError as $AddCulError) {
				echo "<div class='container alert alert-danger'>" . $AddCulError . "</div>";
			}

			if (empty($AddArtCulError)) {

				$Artimage = rand(0, 100000) . '_' . $ArtImageName;
			 	move_uploaded_file($ArtImageTmp, 'Uploads/Images/' . $Artimage);

			 	if (empty($ArtVideo)) {
			 		$ArtVideo = 'لا يوجد فيديو';
			 	}
			 	if (empty($ArtImageName)) {
				$Artimage = $ArtInfo['Cul_Image'];
				}

				$AddArtCulStmt = $con-> prepare("UPDATE culture SET Cul_Name = ?, Cul_Image = ?, Cul_Write = ?, Cul_Details = ?, Cul_Parent = ?, Cul_Videos = ? WHERE Cul_ID = ?");
				$AddArtCulStmt-> execute(array($ArtCulName, $Artimage, $_SESSION['UserID'], $ArtCulDetails, $ArtCulParent, $ArtVideo, $ArtID));

				echo "<div class='container alert alert-success'>تم تعديل مقالك بنجاح</div>";
				
			}

		}

		// if Not isset $_SESSION
		} else {
		header('Location: login.php');
		exit();
		}

	} else {

		echo "<div class='Page-First container alert alert-danger'>لا يوجد مقال بهذا الأسم</div>";

	}

// Cul-Edit Page End
// Cul-Delete Page Start
} elseif ($Art == 'Cul-Delete') {

	$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;

	$ArtDeleteStmt = $con-> prepare("SELECT Cul_ID FROM culture WHERE Cul_ID = ?");
	$ArtDeleteStmt-> execute(array($ArtID));
	$Count = $ArtDeleteStmt-> rowCount();

	if ($Count > 0) {

		if (isset($_SESSION['username'])) { 

			$ArtCulDelete = $con-> prepare("DELETE FROM culture WHERE Cul_ID = :id");
			$ArtCulDelete-> bindParam(':id', $ArtID);
			$ArtCulDelete-> execute();

		}

		$ArtCommentDeleteStmt = $con-> prepare("DELETE FROM comments WHERE Com_SectionName = 2 AND Art_ID = :Art_ID");
		$ArtCommentDeleteStmt-> bindParam(':Art_ID', $ArtID);
		$ArtCommentDeleteStmt-> execute();

		header('Location: Profile.php');
		exit();

	} else {

		echo "<div class='Page-First container alert alert-danger'>لا يوجد مقال بهذا الأسم</div>";

	}

// Cul-Delete Page End
} else {



}

?>

<?php include $TempDir . 'footer.php'; 


?>