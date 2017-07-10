<?php

session_start();

include 'init.php';

$Art = '';

if (isset($_GET['Art'])) {

	$Art = $_GET['Art'];

} else {

	$Art = 'Art';

}

// if The Page Is Main Page

if ($Art == 'Add-News') { 

	if (isset($_SESSION['username'])) { ?>
	
		<div class="container">
			<h1 class="Page-First text-center"> خبر جديد </h1>
			<article class="row">
				<aside class="col-lg-6 Sections-Articles">
					<div class="SingUp-Page">
						<form class="form-group" action="<?php $_SERVER['PHP_SELF']; ?>" method='POST' enctype="multipart/form-data">
							<label> أسم الخبر </label>
							<input class="form-control" type="text" name="NewsName">
							<label> صورة الخبر </label>
							<input class="form-control" type="file" name="NewsImage">
							<label> تفاصيل الخبر </label>
							<input class="form-control" type="text" name="NewsDetails">
							<label>فيديو للخبر</label>
							<input class="form-control" type="text" name="NewsVideos">
							<input class="btn btn-primary" type="submit" name="AddNews" value="نشر الخبر">
						</form>
					</div>
					<?php 

						if (isset($_POST['AddNews'])) {

							$News_Name = filter_var($_POST['NewsName'], FILTER_SANITIZE_STRING);
							$News_Details = filter_var($_POST['NewsDetails'], FILTER_SANITIZE_STRING);
							$News_Video =  filter_var($_POST['NewsVideos'], FILTER_SANITIZE_URL);

							$Image_Name = $_FILES['NewsImage']['name'];
							$Image_Typy = $_FILES['NewsImage']['type'];
							$Image_Tmp = $_FILES['NewsImage']['tmp_name'];
							$Image_Size = $_FILES['NewsImage']['size'];

							$ImageAllowedExtension = array('jpg', 'jpeg', 'png', 'bmp', 'tiff', 'gif');

							$ImNa_strtolower = strtolower($Image_Name);
							$ImNaStr_explode = explode('.', $ImNa_strtolower);
							$ImNaStrEx_End = end($ImNaStr_explode);

							$NewsFormErrors = array();
							if (empty($News_Name)) {
								$NewsFormErrors[] = 'أسم الخبر يجب ان لا يكون فارغاً';
							}
							if (empty($News_Details)) {
								$NewsFormErrors[] = 'تفاصيل الخبر لا يجب أن تكون فارغه';
							}
							if (empty($News_Video)) {
								$News_Video = 'لا يوجد فيديو';
							}
							if (!empty($Image_Name) && !in_array($ImNaStrEx_End, $ImageAllowedExtension)) {
								$NewsFormErrors[] = 'أمتداد الصورة غير مسموح به أبحث عن صورة يكون أمتدادها " jpg - jpeg - png - bmp - tiff - gif "';
							}
							if ($Image_Size > 4194304) {
								$NewsFormErrors[] = 'حجم الصورة كبير جدا أضف صورة حجمها يكون أقل من 4MB';
							}

							foreach ($NewsFormErrors as $AddNewsErrors) {
								echo "<div class='alert alert-danger'>" . $AddNewsErrors . "</div>";
							}

							if (empty($NewsFormErrors)) {
								
								$Image = rand(0, 1000000) . '_' . $Image_Name;
								move_uploaded_file($Image_Tmp, 'Uploads/Images/' . $Image);

								$AddNewsStmt = $con-> prepare("INSERT INTO 
																news(News_Name, News_Image, News_Write, News_Date, News_Time, News_Details, News_Videos, alerts) 
																VALUES(:Nname, :Nimage, :Nwrite, now(), now(), :Ndetails, :Nvideos, :alerts)");
								$AddNewsStmt-> execute(array(

									'Nname' => $News_Name,
									'Nimage' => $Image,
									'Nwrite' => $_SESSION['UserID'],
									'Ndetails' => $News_Details,
									'Nvideos' => $News_Video,
									'alerts' 	=> '1'

								));

								echo "<div class='container alert alert-success'>تم أضافة الخبر بنجاح</div>";

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
		header('Location: login.php');
		exit();
	}

} elseif ($Art == 'News') { 

	$NewsID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;

	$ShowNewsStmt = $con-> prepare("SELECT news.*, users.User_Name AS UserName FROM news JOIN users ON news.News_Write = users.User_ID WHERE News_ID = ?");
	$ShowNewsStmt-> execute(array($NewsID));
	$NewsCount = $ShowNewsStmt-> rowCount();

	if ($NewsCount > 0) {

		$TheNews = $ShowNewsStmt-> fetch();

	}

?>

<div class="container">
	<h3 class="Page-First text-center">الأخبار</h3>
		<article class="row">
			<aside class="col-lg-8">
				<div class="News-box">
					<div class="media">
						<h1><?php echo $TheNews['News_Name']; ?></h1>
						<?php 

							if ($TheNews['News_Image'] == 'لا يوجد فيديو') {
								echo '<img src="Layout/Images/image.jpeg" alt="News Page" width="100%" height="400px">';
							} else {
								echo '<img src="Uploads/Images/'. $TheNews['News_Image'] .'" alt="News Page" width="100%" height="400px">';
							}

						?>
						<div> تاريخ النشر: <?php echo $TheNews['News_Date']; ?> | 
						<?php 

							if ($TheNews["News_Time"] > 12) {
								echo '<span>الساعة ';
								echo $TheNews["News_Time"] - 12 . ' مساءً';
								echo "</span>";
							} elseif ($TheNews["News_Time"] == 00) {

								echo '<span>الساعة ';
								echo $TheNews["News_Time"] + 12 . ' صباحاً';
								echo "</span>";

							} else {
								echo '<span>الساعة ';
								echo $TheNews["News_Time"] - 1 + 1 . ' صباحاً';
								echo "</span>";
							}


						?>
						<span> | بواسطة <?php echo '<a href="UserProfile.php?UserWriteID='. $TheNews['News_Write'] .'">'. $TheNews['UserName'] .'</a>'; ?></span>
						</div>
						<div class="The-News">
							<p><?php echo $TheNews['News_Details']; ?></p>
						</div>
					</div>
				</div>
			</aside>
			<aside class="col-lg-4">
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
									بواسطة <a href="#"> saleh234 </a> | بتاريخ <?php date_default_timezone_set('Asia/Riyadh'); echo date('Y d M'); ?>
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
									بواسطة <a href="#"> saleh234 </a> | بتاريخ <?php date_default_timezone_set('Asia/Riyadh'); echo date('Y d M'); ?>
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
									بواسطة <a href="#"> saleh234 </a> | بتاريخ <?php date_default_timezone_set('Asia/Riyadh'); echo date('Y d M'); ?>
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
									بواسطة <a href="#"> saleh234 </a> | بتاريخ <?php date_default_timezone_set('Asia/Riyadh'); echo date('Y d M'); ?>
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

	echo '<div class="Page-First container alert alert-danger">هذه الصفحة غير موجودة</div>';

}
?>


<?php include $TempDir . 'footer.php'; ?>