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

	$PolArtInfoStmt = $con-> prepare("SELECT 
										politics.*,
										users.User_Name AS UserWrite
									 FROM 
									 	politics 
									 JOIN 
									 	users 
									 ON 
									 	users.User_ID = politics.Pol_Write
									 ORDER BY 
									 	Pol_Time
									 DESC
									 ");
	$PolArtInfoStmt-> execute();
	$Count = $PolArtInfoStmt-> rowCount();

// MainPage Page Start
if ($Art == 'MainPage') { ?>

	<div class="container">
			<h1 class="Section-heading">السياسة</h1>
			<article class="row">
				<aside class="col-lg-8 Sections-Articles">
					<div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
							<a href="Politics.php?Art=Pol-Add" class="btn btn-primary btn-block"> أضافة مقال <i class="fa fa-plus"></i></a>
					</div>	
<?php

	if ($Count > 0) { 

		$ArtInfo = $PolArtInfoStmt-> fetchAll();

						foreach ($ArtInfo as $Info) {

							echo '<div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">';
								echo '<a href="Articles.php?Art=Politics-Articles&ArtID='. $Info['Pol_ID'] .'">';
									echo '<div class="Article-box">';
										echo '<h4>' . $Info["Pol_Name"] . '</h4>';
										echo '<span>كاتب المقال</span><a href="UserProfile.php?UserWriteID='. $Info['Pol_Write'] .'">' . $Info["UserWrite"] . '</a><br>';
										echo '<span>تاريخ النشر</span>' . $Info["Pol_Date"] . ' | ';
										if ($Info["Pol_Time"] > 12) {
											echo '<span>الساعة ';
											echo $Info["Pol_Time"] - 12 . ' مساءً';
											echo "</span>";
										} elseif ($Info["Pol_Time"] == 00) {

											echo '<span>الساعة ';
											echo $Info["Pol_Time"] + 12 . ' صباحاً';
											echo "</span>";

										} else {
											echo '<span>الساعة ';
											echo $Info["Pol_Time"] - 1 + 1 . ' صباحاً';
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
// Pol-Add Page Start
} elseif ($Art == 'Pol-Add') {

	if (isset($_SESSION['username'])) { ?>

	<h1 class="Page-First text-center">أضافة مقال في السياسة</h1>
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

		$ArtPolName = filter_var($_POST['Article-Name'], FILTER_SANITIZE_STRING);
		$ArtPolDetails = filter_var($_POST['Article-Details'], FILTER_SANITIZE_STRING);

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

		$AddArtPolError = array();
		if (empty($ArtPolName)) {
			$AddArtPolError[] = 'أسم المقال يجب أن لا يكون فارغاً';
		}
		if (empty($ArtImageName)) {
			$AddArtPolError[] = 'صورة المقال يجب أن لا تكون فارغه';
		}
		if (empty($ArtPolDetails)) {
			$AddArtPolError[] = 'تفاصيل المقال يجب أن لا تكون فارغه';
		}
		if (!empty($ArtImageName) && !in_array($ArtImNameExplodeEnd, $ImageAllwedExtension)) {
			$AddArtPolError[] = 'يجب ان يكون أمتداد الصورة فقط أحدى هذه الأمتدادات " jpg - jpeg - png - bmp - tiff - gif "';
		}
		if ($ArtImageSize > 4194304) {
				$UserInfoError[] = 'حجم الصورة كبير جدا أضف صورة حجمها يكون أقل من 4MB';
		}

		foreach ($AddArtPolError as $AddPolError) {
			echo "<div class='container alert alert-danger'>" . $AddPolError . "</div>";
		}

		if (empty($AddArtPolError)) {

			$Artimage = rand(0, 100000) . '_' . $ArtImageName;
		 	move_uploaded_file($ArtImageTmp, 'Uploads/Images/' . $Artimage);

		 	if (empty($ArtVideo)) {
		 		$ArtVideo = 'لا يوجد فيديو';
		 	}

			$AddArtPolStmt = $con-> prepare("INSERT INTO politics(Pol_Name, Pol_Image, Pol_Write, Pol_Date, Pol_Time, Pol_Details, Pol_Videos, alerts) 
														VALUES(:PolName, :PolImage, :PolWrite, now(), now(), :PolDetails, :PolVideos, :alerts)");
			$AddArtPolStmt-> execute(array(

				'PolName' => $ArtPolName,
				'PolImage' => $Artimage,
				'PolWrite' => $_SESSION['UserID'],
				'PolDetails' => $ArtPolDetails,
				'PolVideos' => $ArtVideo,
				'alerts' 	=> '1'

			));

			echo "<div class='container alert alert-success'>تم أضافة مقالك بنجاح</div>";

		}

	}
} else {
	header('Location: login.php');
	exit();
}

// Pol-Add Page End
// Pol-Edit Page Start
} elseif ($Art == 'Pol-Edit') {

$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;

	$ArtEditStmt = $con-> prepare("SELECT * FROM politics WHERE Pol_ID = ?");
	$ArtEditStmt-> execute(array($ArtID));
	$Count = $ArtEditStmt-> rowCount();

	if ($Count > 0) {

		$ArtInfo = $ArtEditStmt-> fetch();

		if (isset($_SESSION['username'])) { ?>

			<h1 class="Page-First text-center">تعديل مقال في التاريخ</h1>
			<div class="container">
				<article class="row">
					<aside class="col-lg-8 Sections-Articles">
						<form class="input-textarea form-group" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
		   					<label>أسم المقال</label>
								<input class="form-control" type="text" name="Article-Name" required="required" value="<?php echo $ArtInfo['Pol_Name'] ?>">
		   					<label>صورة المقال</label>
		   						<h5>الصورة الأصلية</h5>
		   						<div>
		   							<img src="Uploads/Images/<?php echo $ArtInfo['Pol_Image'] ?>" width="100px" height="100px">
		   						</div>
		   						<h5>عدل الصورة</h5>
								<input class="form-control" type="file" name="Article-Image">
		   					<label>تفاصيل المقال</label>
		   						<div class="textarea-Edit">
		   							<h5>المقال الأصلي</h5>
		   							<?php echo $ArtInfo['Pol_Details'] ?>
		   						</div>
		   						<h5>عدل المقال</h5>
								<textarea class="form-control" name="Article-Details"></textarea>
		   					<label>فيديوهات  للمقال</label>
								<input class="form-control" type="text" name="Article-Video" value="<?php echo $ArtInfo['Pol_Videos'] ?>">
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

			$ArtPolName = filter_var($_POST['Article-Name'], FILTER_SANITIZE_STRING);
			$ArtPolDetails = filter_var($_POST['Article-Details'], FILTER_SANITIZE_STRING);
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

			$AddArtPolError = array();
			if (empty($ArtPolName)) {
				$AddArtPolError[] = 'أسم المقال يجب أن لا يكون فارغاً';
			}
			if (empty($ArtPolDetails)) {
				$ArtPolDetails = $ArtInfo['Pol_Details'];
			}
			if (!empty($ArtImageName) && !in_array($ArtImNameExplodeEnd, $ImageAllwedExtension)) {
				$AddArtPolError[] = 'يجب ان يكون أمتداد الصورة فقط أحدى هذه الأمتدادات " jpg - jpeg - png - bmp - tiff - gif "';
			}
			if ($ArtImageSize > 4194304) {
					$UserInfoError[] = 'حجم الصورة كبير جدا أضف صورة حجمها يكون أقل من 4MB';
			}

			foreach ($AddArtPolError as $AddPolError) {
				echo "<div class='container alert alert-danger'>" . $AddPolError . "</div>";
			}

			if (empty($AddArtPolError)) {

				$Artimage = rand(0, 100000) . '_' . $ArtImageName;
			 	move_uploaded_file($ArtImageTmp, 'Uploads/Images/' . $Artimage);

			 	if (empty($ArtVideo)) {
			 		$ArtVideo = 'لا يوجد فيديو';
			 	}
			 	if (empty($ArtImageName)) {
				$Artimage = $ArtInfo['Pol_Image'];
				}

				$AddArtPolStmt = $con-> prepare("UPDATE politics SET Pol_Name = ?, Pol_Image = ?, Pol_Write = ?, Pol_Details = ?, Pol_Videos = ? WHERE Pol_ID = ?");
				$AddArtPolStmt-> execute(array($ArtPolName, $Artimage, $_SESSION['UserID'], $ArtPolDetails, $ArtVideo, $ArtID));

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

// Pol-Edit Page End
// Pol-Delete Page Start
} elseif ($Art == 'Pol-Delete') {

	$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;

	$ArtDeleteStmt = $con-> prepare("SELECT Pol_ID FROM politics WHERE Pol_ID = ?");
	$ArtDeleteStmt-> execute(array($ArtID));
	$Count = $ArtDeleteStmt-> rowCount();

	if ($Count > 0) {

		if (isset($_SESSION['username'])) { 

			$ArtPolDelete = $con-> prepare("DELETE FROM politics WHERE Pol_ID = :id");
			$ArtPolDelete-> bindParam(':id', $ArtID);
			$ArtPolDelete-> execute();

		}

		$ArtCommentDeleteStmt = $con-> prepare("DELETE FROM comments WHERE Com_SectionName = 9 AND Art_ID = :Art_ID");
		$ArtCommentDeleteStmt-> bindParam(':Art_ID', $ArtID);
		$ArtCommentDeleteStmt-> execute();

		header('Location: Profile.php');
		exit();

	} else {

		echo "<div class='Page-First container alert alert-danger'>لا يوجد مقال بهذا الأسم</div>";

	}

// Pol-Delete Page End
} else {



}

?>

<?php include $TempDir . 'footer.php'; 


?>