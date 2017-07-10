<?php include 'init.php'; ?>

<div class="container">
<h3 class="Page-First text-center">الأخبار</h3>
	<article class="row">
		<aside class="col-lg-8 Sections-Articles">
			<a href="NewsArt.php?Art=Add-News" class="btn btn-primary btn-block">أضافة خبر</a>
			<div class="panel panel-primary">
				<div class="panel-body">
					<?php 

						$ShowNewsStmt = $con-> prepare("SELECT news.*, users.User_Name AS UserName FROM news JOIN users ON news.News_Write = users.User_ID");
						$ShowNewsStmt-> execute();
						$NewsCount = $ShowNewsStmt-> rowCount();

						if ($NewsCount > 0) {

							$TheNews = $ShowNewsStmt-> fetchAll();

							foreach($TheNews as $News) {

								echo '<div class="News-box">';
									echo '<div class="media">';
										echo '<div class="media-right">';
											if ($News['News_Image'] == 'لا يوجد فيديو') {
												echo '<img src="Layout/Images/image.jpeg" alt="News Page" width="250px" height="200px">';
											} else {
												echo '<img src="Uploads/Images/'. $News['News_Image'] .'" alt="News Page" width="250px" height="200px">';
											}
										echo "</div>";
										echo '<div class="media-body">';
											echo '<div class="News-Title">'. $News['News_Name'] .'</div>';
											echo '<div class="News-Date"><span> التاريخ </span>'. $News['News_Date'];
											echo ' | بواسطة <a href="UserProfile.php?UserWriteID='. $News['News_Write'] .'">'. $News['UserName'] .'</a></div>';
											echo "<hr>";
											echo '<a href="NewsArt.php?Art=News&ArtID='. $News['News_ID'] .'" class="btn btn-primary pull-left">أقرا</a>';
										echo "</div>";
									echo "</div>";
								echo "</div>";

							}

						}

					?>
					
				</div>
			</div>
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

<?php include $TempDir . 'footer.php'; ?>