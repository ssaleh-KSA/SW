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

	$ComArtInfoStmt = $con-> prepare("SELECT 
										community.*,
										users.User_Name AS UserWrite
									 FROM 
									 	community 
									 JOIN 
									 	users 
									 ON 
									 	users.User_ID = community.Com_Write
									 ORDER BY 
									 	Com_Time
									 DESC
									 ");
	$ComArtInfoStmt-> execute();
	$Count = $ComArtInfoStmt-> rowCount();

// MainPage Page Start
if ($Art == 'MainPage') { ?>

		<div class="container">
			<h1 class="Section-heading">المجتمع</h1>
			<article class="row">
				<aside class="col-lg-8 Sections-Articles">
					<div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
						<a href="Community.php?Art=Com-Add" class="btn btn-primary btn-block"> أضافة مقال <i class="fa fa-plus"></i></a>
					</div>	
<?php

	if ($Count > 0) { 

		$ArtInfo = $ComArtInfoStmt-> fetchAll(); 
	
						foreach ($ArtInfo as $Info) {

							echo '<div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">';
								echo '<a href="Articles.php?Art=Community-Articles&ArtID='. $Info['Com_ID'] .'">';
									echo '<div class="Article-box">';
										echo '<h4>' . $Info["Com_Name"] . '</h4>';
										echo '<span>كاتب المقال</span><a href="UserProfile.php?UserWriteID='. $Info['Com_Write'] .'">' . $Info["UserWrite"] . '</a><br>';
										echo '<span>تاريخ النشر</span>' . $Info["Com_Date"] . ' | ';
										if ($Info["Com_Time"] > 12) {
											echo '<span>الساعة ';
											echo $Info["Com_Time"] - 12 . ' مساءً';
											echo "</span>";
										} elseif ($Info["Com_Time"] == 00) {

											echo '<span>الساعة ';
											echo $Info["Com_Time"] + 12 . ' صباحاً';
											echo "</span>";

										} else {
											echo '<span>الساعة ';
											echo $Info["Com_Time"] - 1 + 1 . ' صباحاً';
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
// Com-Add Page Start
} elseif ($Art == 'Com-Add') {

	if (isset($_SESSION['username'])) { ?>

	<h1 class="Page-First text-center">أضافة مقال في المجتمع</h1>
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
							<option value="1">مؤثرين سعوديين</option>
							<option value="2">السكان</option>
							<option value="3">التعليم</option>
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

		$ArtComName = filter_var($_POST['Article-Name'], FILTER_SANITIZE_STRING);
		$ArtComDetails = filter_var($_POST['Article-Details'], FILTER_SANITIZE_STRING);
		$ArtComParent = $_POST['Article-Parent'];
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

		$AddArtComError = array();
		if (empty($ArtComName)) {
			$AddArtComError[] = 'أسم المقال يجب أن لا يكون فارغاً';
		}
		if (empty($ArtImageName)) {
			$AddArtComError[] = 'صورة المقال يجب أن لا تكون فارغه';
		}
		if (empty($ArtComDetails)) {
			$AddArtComError[] = 'تفاصيل المقال يجب أن لا تكون فارغه';
		}
		if ($ArtComParent == 0) {
			$AddArtComError[] = 'يجب أن تختار تصنيف المقال';
		}
		if (!empty($ArtImageName) && !in_array($ArtImNameExplodeEnd, $ImageAllwedExtension)) {
			$AddArtComError[] = 'يجب ان يكون أمتداد الصورة فقط أحدى هذه الأمتدادات " jpg - jpeg - png - bmp - tiff - gif "';
		}
		if ($ArtImageSize > 4194304) {
				$UserInfoError[] = 'حجم الصورة كبير جدا أضف صورة حجمها يكون أقل من 4MB';
		}

		foreach ($AddArtComError as $AddComError) {
			echo "<div class='container alert alert-danger'>" . $AddComError . "</div>";
		}

		if (empty($AddArtComError)) {

			$Artimage = rand(0, 100000) . '_' . $ArtImageName;
		 	move_uploaded_file($ArtImageTmp, 'Uploads/Images/' . $Artimage);

		 	if (empty($ArtVideo)) {
		 		$ArtVideo = 'لا يوجد فيديو';
		 	}

			$AddArtComStmt = $con-> prepare("INSERT INTO community(Com_Name, Com_Image, Com_Write, Com_Date, Com_Time, Com_Details, Com_Parent, Com_Videos, alerts) 
														VALUES(:ComName, :ComImage, :ComWrite, now(), now(), :ComDetails, :ComParent, :ComVideos, :alerts)");
			$AddArtComStmt-> execute(array(

				'ComName' => $ArtComName,
				'ComImage' => $Artimage,
				'ComWrite' => $_SESSION['UserID'],
				'ComDetails' => $ArtComDetails,
				'ComParent' => $ArtComParent,
				'ComVideos' => $ArtVideo,
				'alerts' 	=> '1'

			));

			echo "<div class='container alert alert-success'>تم أضافة مقالك بنجاح</div>";

		}

	}
} else {
	header('Location: login.php');
	exit();
}

// Com-Add Page End
// Com-Edit Page Start
} elseif ($Art == 'Com-Edit') {

	$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;

	$ArtEditStmt = $con-> prepare("SELECT * FROM community WHERE Com_ID = ?");
	$ArtEditStmt-> execute(array($ArtID));
	$Count = $ArtEditStmt-> rowCount();

	if ($Count > 0) {

		$ArtInfo = $ArtEditStmt-> fetch();

		if (isset($_SESSION['username'])) { ?>

			<h1 class="Page-First text-center">تعديل مقال في المجتمع</h1>
			<div class="container">
				<article class="row">
					<aside class="col-lg-8 Sections-Articles">
						<form class="input-textarea form-group" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
		   					<label>أسم المقال</label>
								<input class="form-control" type="text" name="Article-Name" required="required" value="<?php echo $ArtInfo['Com_Name'] ?>">
		   					<label>صورة المقال</label>
		   						<h5>الصورة الأصلية</h5>
		   						<div>
		   							<img src="Uploads/Images/<?php echo $ArtInfo['Com_Image'] ?>" width="100px" height="100px">
		   						</div>
		   						<h5>عدل الصورة</h5>
								<input class="form-control" type="file" name="Article-Image">
		   					<label>تفاصيل المقال</label>
		   						<div class="textarea-Edit">
		   							<h5>المقال الأصلي</h5>
		   							<?php echo $ArtInfo['Com_Details'] ?>
		   						</div>
		   						<h5>عدل المقال</h5>
								<textarea class="form-control" name="Article-Details"></textarea>
							<label>تصنيف المقال</label>
								<select class="form-control" name="Article-Parent" required="required">
									<option value="0">---</option>
									<option value="1" <?php if ($ArtInfo['Com_Parent'] == 1) {echo 'selected';} ?>>مؤثرين سعوديين</option>
									<option value="2" <?php if ($ArtInfo['Com_Parent'] == 2) {echo 'selected';} ?>>السكان</option>
									<option value="3" <?php if ($ArtInfo['Com_Parent'] == 3) {echo 'selected';} ?>>التعليم</option>
								</select>
		   					<label>فيديوهات  للمقال</label>
								<input class="form-control" type="text" name="Article-Video" value="<?php echo $ArtInfo['Com_Videos'] ?>">
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

			$ArtComName = filter_var($_POST['Article-Name'], FILTER_SANITIZE_STRING);
			$ArtComDetails = filter_var($_POST['Article-Details'], FILTER_SANITIZE_STRING);
			$ArtComParent = $_POST['Article-Parent'];
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

			$AddArtComError = array();
			if (empty($ArtComName)) {
				$AddArtComError[] = 'أسم المقال يجب أن لا يكون فارغاً';
			}
			if (empty($ArtComDetails)) {
				$ArtComDetails = $ArtInfo['Com_Details'];
			}
			if ($ArtComParent == 0) {
				$AddArtComError[] = 'يجب أن تختار تصنيف المقال';
			}
			if (!empty($ArtImageName) && !in_array($ArtImNameExplodeEnd, $ImageAllwedExtension)) {
				$AddArtComError[] = 'يجب ان يكون أمتداد الصورة فقط أحدى هذه الأمتدادات " jpg - jpeg - png - bmp - tiff - gif "';
			}
			if ($ArtImageSize > 4194304) {
					$UserInfoError[] = 'حجم الصورة كبير جدا أضف صورة حجمها يكون أقل من 4MB';
			}

			foreach ($AddArtComError as $AddComError) {
				echo "<div class='container alert alert-danger'>" . $AddComError . "</div>";
			}

			if (empty($AddArtComError)) {

				$Artimage = rand(0, 100000) . '_' . $ArtImageName;
			 	move_uploaded_file($ArtImageTmp, 'Uploads/Images/' . $Artimage);

			 	if (empty($ArtVideo)) {
			 		$ArtVideo = 'لا يوجد فيديو';
			 	}
			 	if (empty($ArtImageName)) {
				$Artimage = $ArtInfo['Com_Image'];
				}

				$AddArtComStmt = $con-> prepare("UPDATE community SET Com_Name = ?, Com_Image = ?, Com_Write = ?, Com_Details = ?, Com_Parent = ?, Com_Videos = ? WHERE Com_ID = ?");
				$AddArtComStmt-> execute(array($ArtComName, $Artimage, $_SESSION['UserID'], $ArtComDetails, $ArtComParent, $ArtVideo, $ArtID));

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

// Com-Edit Page End
// Com-Delete Page Start
} elseif ($Art == 'Com-Delete') {

	$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;

	$ArtDeleteStmt = $con-> prepare("SELECT Com_ID FROM community WHERE Com_ID = ?");
	$ArtDeleteStmt-> execute(array($ArtID));
	$Count = $ArtDeleteStmt-> rowCount();

	if ($Count > 0) {

		if (isset($_SESSION['username'])) { 

			$ArtComDelete = $con-> prepare("DELETE FROM community WHERE Com_ID = :id");
			$ArtComDelete-> bindParam(':id', $ArtID);
			$ArtComDelete-> execute();

		}

		$ArtCommentDeleteStmt = $con-> prepare("DELETE FROM comments WHERE Com_SectionName = 3 AND Art_ID = :Art_ID");
		$ArtCommentDeleteStmt-> bindParam(':Art_ID', $ArtID);
		$ArtCommentDeleteStmt-> execute();

		header('Location: Profile.php');
		exit();

	} else {

		echo "<div class='Page-First container alert alert-danger'>لا يوجد مقال بهذا الأسم</div>";

	}

// Com-Delete Page End
} else {



}

?>

<?php include $TempDir . 'footer.php'; 


?>