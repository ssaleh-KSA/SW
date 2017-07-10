<?php 

/*
	==============================================================================================================================================
	== Articles => [ MainPage | History-Articles | Culture-Articles | Community-Articles | Tourism-Articles | Sport-Articles |
							   Websites-Articles | SecurityAndDefense-Articles | Economy-Articles | Politics-Articles ]
	==============================================================================================================================================

*/

include 'init.php';

$Art = '';

if (isset($_GET['Art'])) {

	$Art = $_GET['Art'];

} else {

	$Art = 'MainPage';

}

// Add The Pages

if ($Art == 'MainPage') {
// Main Page Start

	// Main Pagee
	echo '<div class="Page-First container alert alert-success">مرحباً بك في صفحة ال MainPage</div>';

// Main Page End
} elseif ($Art == 'History-Articles') {
// History-Articles Page Start

	$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;

	$HisArtStmt = $con-> prepare("SELECT 
									history.*, 
									users.User_Name AS UserName 
								  FROM 
								  	history 
								  JOIN 
								  	users 
								  ON 
								  	users.User_ID = history.His_Write
								  WHERE 
								  	His_ID = ?
								  ");
	$HisArtStmt-> execute(array($ArtID));
	$Count = $HisArtStmt-> rowCount();

	if ($Count > 0) {
// if $Count > 0
		$HisArticles = $HisArtStmt-> fetch(); ?>

			<div class="container Artcle-Page">
				<h1 class="Page-First text-center">التاريخ</h1>
				<article class="row">
					<aside class="col-lg-8">
						<h1 class="Article-heading"><?php echo $HisArticles['His_Name']; ?></h1>
						<img src="Uploads/Images/<?php echo $HisArticles['His_Image']; ?>" alt="Article Image" height="300px" width="100%">
						<div class="panel panel-info">
							<div class="panel-heading">
								بواسطة: <a href="UserProfile.php?UserWriteID=<?php echo $HisArticles['His_Write']; ?>"> <?php echo $HisArticles['UserName']; ?> </a> |
								بتاريخ: <?php echo $HisArticles['His_Date']; ?>
								<?php 
									if ($HisArticles["His_Time"] > 12) {
										echo '<span>الساعة ';
										echo $HisArticles["His_Time"] - 12 . ' مساءً';
										echo "</span>";
									} elseif ($HisArticles["His_Time"] == 00) {

										echo '<span>الساعة ';
										echo $HisArticles["His_Time"] + 12 . ' صباحاً';
										echo "</span>";

									} else {
										echo '<span>الساعة ';
										echo $HisArticles["His_Time"] - 1 + 1 . ' صباحاً';
										echo "</span>";
									}

								?>
							</div>
							<div class="panel-body">
								<?php echo $HisArticles['His_Details']; ?>
							</div>
						</div>
						<div class="panel panel-success">
							<div class="panel-heading"> أترك تعليقك </div>
							<div class="panel-body">
								<form class="input-textarea form-group" action="AddComments.php" method="POST">
									<?php 

										if ($_GET['Art'] === 'History-Articles') {

											echo '<input type="hidden" name="ComSectionName" value="1">';
											echo '<input type="hidden" name="GETName" value="History-Articles">';

										}

									?>
									<input type="hidden" name="ArtID" value="<?php echo $ArtID; ?>">
									<label>تعليق</label>
									<textarea class="form-control" name="user-Comment"></textarea>
									<input class="btn btn-primary" type="submit" name="AddComment">
								</form>
							</div>
						</div>
						<hr>
						<?php 

							$ShowComment = $con-> prepare("SELECT 
																	comments.*, 
																	users.User_Name AS UserName,
																	users.User_Image AS UserImage
															   	FROM 
															   		comments 
															   	JOIN 
															   		users 
															   	ON 
															   		users.User_ID = comments.Com_UserName 
															   	WHERE 
															   		Com_SectionName = 1 
															   	AND 
															   		Art_ID = ?
															   	ORDER BY 
															   		Com_Date 
															   	DESC
															   	");

							$ShowComment-> execute(array($ArtID));
							$Count = $ShowComment-> rowCount();

						?>
						<div class="panel panel-info">
							<div id="Comments" class="panel-heading">التعليقات: <?php echo $Count; ?></div>
							<div class="panel-body">
							<?php 

								if ($Count > 0) {

									$ComShow = $ShowComment-> fetchAll();
									date_default_timezone_set('Asia/Riyadh');
									$DayTody = date('Y-m-d');
									foreach($ComShow as $TheComments) {

									echo '<div class="panel panel-default">';
										echo '<div class="media">';
											echo '<div class="media-right">';
												echo '<a href="UserProfile.php?UserWriteID='. $TheComments['Com_UserName'] .'">';
													echo '<img src="Uploads/Images/'. $TheComments['UserImage'] .'" alt="Defualt Image" width="50px" height="60px">';
												echo '</a>';
											echo '</div>';
											echo '<div class="media-body">';
												echo '<h5>' . $TheComments['Com_Comments'] . '</h5>';
												echo '<div>';
													echo 'بواسطة <a href="UserProfile.php?UserWriteID='. $TheComments['Com_UserName'] .'">' . $TheComments['UserName'] . '</a> |';
													if ($DayTody === $TheComments['Com_Date']) {
													echo ' اليوم';
													} else {
														echo ' بتاريخ ' . $TheComments['Com_Date'];
													}
												echo '</div>';
											echo '</div>';
										echo '</div>';
									echo '</div>';

									}

								} else {

									echo "لا يوجد تعليقات";

								}
							
							?>
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
					</aside>
				</article>
			</div>


<?php		
// if $Count != 0
	} else {

		echo "<div class='Page-First container alert alert-danger'>لا يوجد مقال بهذا الأسم</div>";

	}
// History-Articles Page End
} elseif ($Art == 'Culture-Articles') {
// Culture-Articles Page Start

	$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;

	$CulArtStmt = $con-> prepare("SELECT 
									culture.*, 
									users.User_Name AS UserName 
								  FROM 
								  	culture 
								  JOIN 
								  	users 
								  ON 
								  	users.User_ID = culture.Cul_Write
								  WHERE 
								  	Cul_ID = ?
								  ");
	$CulArtStmt-> execute(array($ArtID));
	$Count = $CulArtStmt-> rowCount();

	if ($Count > 0) {
// if $Count > 0
		$CulArticles = $CulArtStmt-> fetch(); ?>

			<div class="container Artcle-Page">
				<h1 class="Page-First text-center">الثقافة</h1>
				<article class="row">
					<aside class="col-lg-8">
						<h1 class="Article-heading"><?php echo $CulArticles['Cul_Name']; ?></h1>
						<img src="Uploads/Images/<?php echo $CulArticles['Cul_Image']; ?>" alt="Article Image" height="300px" width="100%">
						<div class="panel panel-info">
							<div class="panel-heading">
								بواسطة: <a href="UserProfile.php?UserWriteID=<?php echo $CulArticles['Cul_Write']; ?>"> <?php echo $CulArticles['UserName']; ?> </a> |
								بتاريخ: <?php echo $CulArticles['Cul_Date']; ?>
								<?php 
									if ($CulArticles["Cul_Time"] > 12) {
										echo '<span>الساعة ';
										echo $CulArticles["Cul_Time"] - 12 . ' مساءً';
										echo "</span>";
									} elseif ($CulArticles["Cul_Time"] == 00) {

										echo '<span>الساعة ';
										echo $CulArticles["Cul_Time"] + 12 . ' صباحاً';
										echo "</span>";

									} else {
										echo '<span>الساعة ';
										echo $CulArticles["Cul_Time"] - 1 + 1 . ' صباحاً';
										echo "</span>";
									}

								?>
							</div>
							<div class="panel-body">
								<?php echo $CulArticles['Cul_Details']; ?>
							</div>
						</div>
						<div class="panel panel-success">
							<div class="panel-heading"> أترك تعليقك </div>
							<div class="panel-body">
								<form class="input-textarea form-group" action="AddComments.php" method="POST">
									<?php 

										if ($_GET['Art'] === 'Culture-Articles') {

											echo '<input type="hidden" name="ComSectionName" value="2">';
											echo '<input type="hidden" name="GETName" value="Culture-Articles">';

										}

									?>
									<input type="hidden" name="ArtID" value="<?php echo $ArtID; ?>">
									<label>تعليق</label>
									<textarea class="form-control" name="user-Comment"></textarea>
									<input class="btn btn-primary" type="submit" name="AddComment">
								</form>
							</div>
						</div>
						<hr>
						<?php 

							$ShowComment = $con-> prepare("SELECT 
																	comments.*, 
																	users.User_Name AS UserName,
																	users.User_Image AS UserImage
															   	FROM 
															   		comments 
															   	JOIN 
															   		users 
															   	ON 
															   		users.User_ID = comments.Com_UserName 
															   	WHERE 
															   		Com_SectionName = 2 
															   	AND 
															   		Art_ID = ?
															   	ORDER BY 
															   		Com_Date 
															   	DESC
															   	");

							$ShowComment-> execute(array($ArtID));
							$Count = $ShowComment-> rowCount();

						?>
						<div class="panel panel-info">
							<div id="Comments" class="panel-heading">التعليقات: <?php echo $Count; ?></div>
							<div class="panel-body">
							<?php 

								if ($Count > 0) {

									$ComShow = $ShowComment-> fetchAll();
									date_default_timezone_set('Asia/Riyadh');
									$DayTody = date('Y-m-d');
									foreach($ComShow as $TheComments) {

									echo '<div class="panel panel-default">';
										echo '<div class="media">';
											echo '<div class="media-right">';
												echo '<a href="UserProfile.php?UserWriteID='. $TheComments['Com_UserName'] .'">';
													echo '<img src="Uploads/Images/'. $TheComments['UserImage'] .'" alt="Defualt Image" width="50px" height="60px">';
												echo '</a>';
											echo '</div>';
											echo '<div class="media-body">';
												echo '<h5>' . $TheComments['Com_Comments'] . '</h5>';
												echo '<div>';
													echo 'بواسطة <a href="UserProfile.php?UserWriteID='. $TheComments['Com_UserName'] .'">' . $TheComments['UserName'] . '</a> |';
													if ($DayTody === $TheComments['Com_Date']) {
													echo ' اليوم';
													} else {
														echo ' بتاريخ ' . $TheComments['Com_Date'];
														echo $Count;
													}
												echo '</div>';
											echo '</div>';
										echo '</div>';
									echo '</div>';

									}

								} else {

									echo "لا يوجد تعليقات";

								}
							
							?>
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
					</aside>
				</article>
			</div>


<?php		
// if $Count != 0
	} else {

		echo "<div class='Page-First container alert alert-danger'>لا يوجد مقال بهذا الأسم</div>";

	}
// Culture-Articles Page End
} elseif ($Art == 'Community-Articles') {
// Community-Articles Page Start

	$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;

	$ComArtStmt = $con-> prepare("SELECT 
									community.*, 
									users.User_Name AS UserName 
								  FROM 
								  	community 
								  JOIN 
								  	users 
								  ON 
								  	users.User_ID = community.Com_Write
								  WHERE 
								  	Com_ID = ?
								  ");
	$ComArtStmt-> execute(array($ArtID));
	$Count = $ComArtStmt-> rowCount();

	if ($Count > 0) {
// if $Count > 0
		$ComArticles = $ComArtStmt-> fetch(); ?>

			<div class="container Artcle-Page">
				<h1 class="Page-First text-center">المجتمع</h1>
				<article class="row">
					<aside class="col-lg-8">
						<h1 class="Article-heading"><?php echo $ComArticles['Com_Name']; ?></h1>
						<img src="Uploads/Images/<?php echo $ComArticles['Com_Image']; ?>" alt="Article Image" height="300px" width="100%">
						<div class="panel panel-info">
							<div class="panel-heading">
								بواسطة: <a href="UserProfile.php?UserWriteID=<?php echo $ComArticles['Com_Write']; ?>"> <?php echo $ComArticles['UserName']; ?> </a> |
								بتاريخ: <?php echo $ComArticles['Com_Date']; ?>
								<?php 
									if ($ComArticles["Com_Time"] > 12) {
										echo '<span>الساعة ';
										echo $ComArticles["Com_Time"] - 12 . ' مساءً';
										echo "</span>";
									} elseif ($ComArticles["Com_Time"] == 00) {

										echo '<span>الساعة ';
										echo $ComArticles["Com_Time"] + 12 . ' صباحاً';
										echo "</span>";

									} else {
										echo '<span>الساعة ';
										echo $ComArticles["Com_Time"] - 1 + 1 . ' صباحاً';
										echo "</span>";
									}

								?>
							</div>
							<div class="panel-body">
								<?php echo $ComArticles['Com_Details']; ?>
							</div>
						</div>
						<div class="panel panel-success">
							<div class="panel-heading"> أترك تعليقك </div>
							<div class="panel-body">
								<form class="input-textarea form-group" action="AddComments.php" method="POST">
									<?php 

										if ($_GET['Art'] === 'Community-Articles') {

											echo '<input type="hidden" name="ComSectionName" value="3">';
											echo '<input type="hidden" name="GETName" value="Community-Articles">';

										}

									?>
									<input type="hidden" name="ArtID" value="<?php echo $ArtID; ?>">
									<label>تعليق</label>
									<textarea class="form-control" name="user-Comment"></textarea>
									<input class="btn btn-primary" type="submit" name="AddComment">
								</form>
							</div>
						</div>
						<hr>
						<?php 

							$ShowComment = $con-> prepare("SELECT 
																	comments.*, 
																	users.User_Name AS UserName,
																	users.User_Image AS UserImage
															   	FROM 
															   		comments 
															   	JOIN 
															   		users 
															   	ON 
															   		users.User_ID = comments.Com_UserName 
															   	WHERE 
															   		Com_SectionName = 3 
															   	AND 
															   		Art_ID = ?
															   	ORDER BY 
															   		Com_Date 
															   	DESC
															   	");

							$ShowComment-> execute(array($ArtID));
							$Count = $ShowComment-> rowCount();

						?>
						<div class="panel panel-info">
							<div id="Comments" class="panel-heading">التعليقات: <?php echo $Count; ?></div>
							<div class="panel-body">
							<?php 

								if ($Count > 0) {

									$ComShow = $ShowComment-> fetchAll();
									date_default_timezone_set('Asia/Riyadh');
									$DayTody = date('Y-m-d');
									foreach($ComShow as $TheComments) {

									echo '<div class="panel panel-default">';
										echo '<div class="media">';
											echo '<div class="media-right">';
												echo '<a href="UserProfile.php?UserWriteID='. $TheComments['Com_UserName'] .'">';
													echo '<img src="Uploads/Images/'. $TheComments['UserImage'] .'" alt="Defualt Image" width="50px" height="60px">';
												echo '</a>';
											echo '</div>';
											echo '<div class="media-body">';
												echo '<h5>' . $TheComments['Com_Comments'] . '</h5>';
												echo '<div>';
													echo 'بواسطة <a href="UserProfile.php?UserWriteID='. $TheComments['Com_UserName'] .'">' . $TheComments['UserName'] . '</a> |';
													if ($DayTody === $TheComments['Com_Date']) {
													echo ' اليوم';
													} else {
														echo ' بتاريخ ' . $TheComments['Com_Date'];
														echo $Count;
													}
												echo '</div>';
											echo '</div>';
										echo '</div>';
									echo '</div>';

									}

								} else {

									echo "لا يوجد تعليقات";

								}
							
							?>
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
					</aside>
				</article>
			</div>


<?php		
// if $Count != 0
	} else {

		echo "<div class='Page-First container alert alert-danger'>لا يوجد مقال بهذا الأسم</div>";

	}
// Community-Articles Page End
} elseif ($Art == 'Tourism-Articles') {
// Tourism-Articles Page Start

	$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;

	$TouArtStmt = $con-> prepare("SELECT 
									tourism.*, 
									users.User_Name AS UserName 
								  FROM 
								  	tourism 
								  JOIN 
								  	users 
								  ON 
								  	users.User_ID = tourism.Tou_Write
								  WHERE 
								  	Tou_ID = ?
								  ");
	$TouArtStmt-> execute(array($ArtID));
	$Count = $TouArtStmt-> rowCount();

	if ($Count > 0) {
// if $Count > 0
		$TouArticles = $TouArtStmt-> fetch(); ?>

			<div class="container Artcle-Page">
				<h1 class="Page-First text-center">السياحة</h1>
				<article class="row">
					<aside class="col-lg-8">
						<h1 class="Article-heading"><?php echo $TouArticles['Tou_Name']; ?></h1>
						<img src="Uploads/Images/<?php echo $TouArticles['Tou_Image']; ?>" alt="Article Image" height="300px" width="100%">
						<div class="panel panel-info">
							<div class="panel-heading">
								بواسطة: <a href="UserProfile.php?UserWriteID=<?php echo $TouArticles['Tou_Write']; ?>"> <?php echo $TouArticles['UserName']; ?> </a> |
								بتاريخ: <?php echo $TouArticles['Tou_Date']; ?>
								<?php 
									if ($TouArticles["Tou_Time"] > 12) {
										echo '<span>الساعة ';
										echo $TouArticles["Tou_Time"] - 12 . ' مساءً';
										echo "</span>";
									} elseif ($TouArticles["Tou_Time"] == 00) {

										echo '<span>الساعة ';
										echo $TouArticles["Tou_Time"] + 12 . ' صباحاً';
										echo "</span>";

									} else {
										echo '<span>الساعة ';
										echo $TouArticles["Tou_Time"] - 1 + 1 . ' صباحاً';
										echo "</span>";
									}

								?>
							</div>
							<div class="panel-body">
								<?php echo $TouArticles['Tou_Details']; ?>
							</div>
						</div>
						<div class="panel panel-success">
							<div class="panel-heading"> أترك تعليقك </div>
							<div class="panel-body">
								<form class="input-textarea form-group" action="AddComments.php" method="POST">
									<?php 

										if ($_GET['Art'] === 'Tourism-Articles') {

											echo '<input type="hidden" name="ComSectionName" value="4">';
											echo '<input type="hidden" name="GETName" value="Tourism-Articles">';

										}

									?>
									<input type="hidden" name="ArtID" value="<?php echo $ArtID; ?>">
									<label>تعليق</label>
									<textarea class="form-control" name="user-Comment"></textarea>
									<input class="btn btn-primary" type="submit" name="AddComment">
								</form>
							</div>
						</div>
						<hr>
						<?php 

							$ShowComment = $con-> prepare("SELECT 
																	comments.*, 
																	users.User_Name AS UserName,
																	users.User_Image AS UserImage
															   	FROM 
															   		comments 
															   	JOIN 
															   		users 
															   	ON 
															   		users.User_ID = comments.Com_UserName 
															   	WHERE 
															   		Com_SectionName = 4
															   	AND 
															   		Art_ID = ?
															   	ORDER BY 
															   		Com_Date 
															   	DESC
															   	");

							$ShowComment-> execute(array($ArtID));
							$Count = $ShowComment-> rowCount();

						?>
						<div class="panel panel-info">
							<div id="Comments" class="panel-heading">التعليقات: <?php echo $Count; ?></div>
							<div class="panel-body">
							<?php 

								if ($Count > 0) {

									$ComShow = $ShowComment-> fetchAll();
									date_default_timezone_set('Asia/Riyadh');
									$DayTody = date('Y-m-d');
									foreach($ComShow as $TheComments) {

									echo '<div class="panel panel-default">';
										echo '<div class="media">';
											echo '<div class="media-right">';
												echo '<a href="UserProfile.php?UserWriteID='. $TheComments['Com_UserName'] .'">';
													echo '<img src="Uploads/Images/'. $TheComments['UserImage'] .'" alt="Defualt Image" width="50px" height="60px">';
												echo '</a>';
											echo '</div>';
											echo '<div class="media-body">';
												echo '<h5>' . $TheComments['Com_Comments'] . '</h5>';
												echo '<div>';
													echo 'بواسطة <a href="UserProfile.php?UserWriteID='. $TheComments['Com_UserName'] .'">' . $TheComments['UserName'] . '</a> |';
													if ($DayTody === $TheComments['Com_Date']) {
													echo ' اليوم';
													} else {
														echo ' بتاريخ ' . $TheComments['Com_Date'];
														echo $Count;
													}
												echo '</div>';
											echo '</div>';
										echo '</div>';
									echo '</div>';

									}

								} else {

									echo "لا يوجد تعليقات";

								}
							
							?>
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
					</aside>
				</article>
			</div>


<?php		
// if $Count != 0
	} else {

		echo "<div class='Page-First container alert alert-danger'>لا يوجد مقال بهذا الأسم</div>";

	}
// Tourism-Articles Page End
} elseif ($Art == 'Sport-Articles') {
// Sport-Articles Page Start

	$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;

	$SpoArtStmt = $con-> prepare("SELECT 
									sport.*, 
									users.User_Name AS UserName 
								  FROM 
								  	sport 
								  JOIN 
								  	users 
								  ON 
								  	users.User_ID = sport.Spo_Write
								  WHERE 
								  	Spo_ID = ?
								  ");
	$SpoArtStmt-> execute(array($ArtID));
	$Count = $SpoArtStmt-> rowCount();

	if ($Count > 0) {
// if $Count > 0
		$SpoArticles = $SpoArtStmt-> fetch(); ?>

			<div class="container Artcle-Page">
				<h1 class="Page-First text-center">الرياضة</h1>
				<article class="row">
					<aside class="col-lg-8">
						<h1 class="Article-heading"><?php echo $SpoArticles['Spo_Name']; ?></h1>
						<img src="Uploads/Images/<?php echo $SpoArticles['Spo_Image']; ?>" alt="Article Image" height="300px" width="100%">
						<div class="panel panel-info">
							<div class="panel-heading">
								بواسطة: <a href="UserProfile.php?UserWriteID=<?php echo $SpoArticles['Spo_Write']; ?>"> <?php echo $SpoArticles['UserName']; ?> </a> |
								بتاريخ: <?php echo $SpoArticles['Spo_Date']; ?>
								<?php 
									if ($SpoArticles["Spo_Time"] > 12) {
										echo '<span>الساعة ';
										echo $SpoArticles["Spo_Time"] - 12 . ' مساءً';
										echo "</span>";
									} elseif ($SpoArticles["Spo_Time"] == 00) {

										echo '<span>الساعة ';
										echo $SpoArticles["Spo_Time"] + 12 . ' صباحاً';
										echo "</span>";

									} else {
										echo '<span>الساعة ';
										echo $SpoArticles["Spo_Time"] - 1 + 1 . ' صباحاً';
										echo "</span>";
									}

								?>
							</div>
							<div class="panel-body">
								<?php echo $SpoArticles['Spo_Details']; ?>
							</div>
						</div>
						<div class="panel panel-success">
							<div class="panel-heading"> أترك تعليقك </div>
							<div class="panel-body">
								<form class="input-textarea form-group" action="AddComments.php" method="POST">
									<?php 

										if ($_GET['Art'] === 'Sport-Articles') {

											echo '<input type="hidden" name="ComSectionName" value="5">';
											echo '<input type="hidden" name="GETName" value="Sport-Articles">';

										}

									?>
									<input type="hidden" name="ArtID" value="<?php echo $ArtID; ?>">
									<label>تعليق</label>
									<textarea class="form-control" name="user-Comment"></textarea>
									<input class="btn btn-primary" type="submit" name="AddComment">
								</form>
							</div>
						</div>
						<hr>
						<?php 

							$ShowComment = $con-> prepare("SELECT 
																	comments.*, 
																	users.User_Name AS UserName,
																	users.User_Image AS UserImage
															   	FROM 
															   		comments 
															   	JOIN 
															   		users 
															   	ON 
															   		users.User_ID = comments.Com_UserName 
															   	WHERE 
															   		Com_SectionName = 5
															   	AND 
															   		Art_ID = ?
															   	ORDER BY 
															   		Com_Date 
															   	DESC
															   	");

							$ShowComment-> execute(array($ArtID));
							$Count = $ShowComment-> rowCount();

						?>
						<div class="panel panel-info">
							<div id="Comments" class="panel-heading">التعليقات: <?php echo $Count; ?></div>
							<div class="panel-body">
							<?php 

								if ($Count > 0) {

									$ComShow = $ShowComment-> fetchAll();
									date_default_timezone_set('Asia/Riyadh');
									$DayTody = date('Y-m-d');
									foreach($ComShow as $TheComments) {

									echo '<div class="panel panel-default">';
										echo '<div class="media">';
											echo '<div class="media-right">';
												echo '<a href="UserProfile.php?UserWriteID='. $TheComments['Com_UserName'] .'">';
													echo '<img src="Uploads/Images/'. $TheComments['UserImage'] .'" alt="Defualt Image" width="50px" height="60px">';
												echo '</a>';
											echo '</div>';
											echo '<div class="media-body">';
												echo '<h5>' . $TheComments['Com_Comments'] . '</h5>';
												echo '<div>';
													echo 'بواسطة <a href="UserProfile.php?UserWriteID='. $TheComments['Com_UserName'] .'">' . $TheComments['UserName'] . '</a> |';
													if ($DayTody === $TheComments['Com_Date']) {
													echo ' اليوم';
													} else {
														echo ' بتاريخ ' . $TheComments['Com_Date'];
														echo $Count;
													}
												echo '</div>';
											echo '</div>';
										echo '</div>';
									echo '</div>';

									}

								} else {

									echo "لا يوجد تعليقات";

								}
							
							?>
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
					</aside>
				</article>
			</div>


<?php		
// if $Count != 0
	} else {

		echo "<div class='Page-First container alert alert-danger'>لا يوجد مقال بهذا الأسم</div>";

	}
// Sport-Articles Page End
} elseif ($Art == 'Websites-Articles') {
// Websites-Articles Page Start

	$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;

	$WebArtStmt = $con-> prepare("SELECT 
									websites.*, 
									users.User_Name AS UserName 
								  FROM 
								  	websites 
								  JOIN 
								  	users 
								  ON 
								  	users.User_ID = websites.Web_Write
								  WHERE 
								  	Web_ID = ?
								  ");
	$WebArtStmt-> execute(array($ArtID));
	$Count = $WebArtStmt-> rowCount();

	if ($Count > 0) {
// if $Count > 0
		$WebArticles = $WebArtStmt-> fetch(); ?>

			<div class="container Artcle-Page">
				<h1 class="Page-First text-center">مواقع الكترونية</h1>
				<article class="row">
					<aside class="col-lg-8">
						<h1 class="Article-heading"><?php echo $WebArticles['Web_Name']; ?></h1>
						<img src="Uploads/Images/<?php echo $WebArticles['Web_Image']; ?>" alt="Article Image" height="300px" width="100%">
						<div class="panel panel-info">
							<div class="panel-heading">
								بواسطة: <a href="UserProfile.php?UserWriteID=<?php echo $WebArticles['Web_Write']; ?>"> <?php echo $WebArticles['UserName']; ?> </a> |
								بتاريخ: <?php echo $WebArticles['Web_Date']; ?>
								<?php 
									if ($WebArticles["Web_Time"] > 12) {
										echo '<span>الساعة ';
										echo $WebArticles["Web_Time"] - 12 . ' مساءً';
										echo "</span>";
									} elseif ($WebArticles["Web_Time"] == 00) {

										echo '<span>الساعة ';
										echo $WebArticles["Web_Time"] + 12 . ' صباحاً';
										echo "</span>";

									} else {
										echo '<span>الساعة ';
										echo $WebArticles["Web_Time"] - 1 + 1 . ' صباحاً';
										echo "</span>";
									}

								?>
							</div>
							<div class="panel-body">
								<?php echo $WebArticles['Web_Details']; ?>
								<hr>
								<?php echo '<a class="btn btn-primary" href="'. $WebArticles['Web_Link'] . '">' . 'رابط الموقع</a>'; ?>
							</div>
						</div>
						<div class="panel panel-success">
							<div class="panel-heading"> أترك تعليقك </div>
							<div class="panel-body">
								<form class="input-textarea form-group" action="AddComments.php" method="POST">
									<?php 

										if ($_GET['Art'] === 'Websites-Articles') {

											echo '<input type="hidden" name="ComSectionName" value="6">';
											echo '<input type="hidden" name="GETName" value="Websites-Articles">';

										}

									?>
									<input type="hidden" name="ArtID" value="<?php echo $ArtID; ?>">
									<label>تعليق</label>
									<textarea class="form-control" name="user-Comment"></textarea>
									<input class="btn btn-primary" type="submit" name="AddComment">
								</form>
							</div>
						</div>
						<hr>
						<?php 

							$ShowComment = $con-> prepare("SELECT 
																	comments.*, 
																	users.User_Name AS UserName,
																	users.User_Image AS UserImage
															   	FROM 
															   		comments 
															   	JOIN 
															   		users 
															   	ON 
															   		users.User_ID = comments.Com_UserName 
															   	WHERE 
															   		Com_SectionName = 6
															   	AND 
															   		Art_ID = ?
															   	ORDER BY 
															   		Com_Date 
															   	DESC
															   	");

							$ShowComment-> execute(array($ArtID));
							$Count = $ShowComment-> rowCount();

						?>
						<div class="panel panel-info">
							<div id="Comments" class="panel-heading">التعليقات: <?php echo $Count; ?></div>
							<div class="panel-body">
							<?php 

								if ($Count > 0) {

									$ComShow = $ShowComment-> fetchAll();
									date_default_timezone_set('Asia/Riyadh');
									$DayTody = date('Y-m-d');
									foreach($ComShow as $TheComments) {

									echo '<div class="panel panel-default">';
										echo '<div class="media">';
											echo '<div class="media-right">';
												echo '<a href="UserProfile.php?UserWriteID='. $TheComments['Com_UserName'] .'">';
													echo '<img src="Uploads/Images/'. $TheComments['UserImage'] .'" alt="Defualt Image" width="50px" height="60px">';
												echo '</a>';
											echo '</div>';
											echo '<div class="media-body">';
												echo '<h5>' . $TheComments['Com_Comments'] . '</h5>';
												echo '<div>';
													echo 'بواسطة <a href="UserProfile.php?UserWriteID='. $TheComments['Com_UserName'] .'">' . $TheComments['UserName'] . '</a> |';
													if ($DayTody === $TheComments['Com_Date']) {
													echo ' اليوم';
													} else {
														echo ' بتاريخ ' . $TheComments['Com_Date'];
														echo $Count;
													}
												echo '</div>';
											echo '</div>';
										echo '</div>';
									echo '</div>';

									}

								} else {

									echo "لا يوجد تعليقات";

								}
							
							?>
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
					</aside>
				</article>
			</div>


<?php		
// if $Count != 0
	} else {

		echo "<div class='Page-First container alert alert-danger'>لا يوجد مقال بهذا الأسم</div>";

	}
// Websites-Articles Page End
} elseif ($Art == 'SecurityAndDefense-Articles') {
// SecurityAndDefense-Articles Page Start

	$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;

	$SADArtStmt = $con-> prepare("SELECT 
									security_and_defense.*, 
									users.User_Name AS UserName 
								  FROM 
								  	security_and_defense 
								  JOIN 
								  	users 
								  ON 
								  	users.User_ID = security_and_defense.SAD_Write
								  WHERE 
								  	SAD_ID = ?
								  ");
	$SADArtStmt-> execute(array($ArtID));
	$Count = $SADArtStmt-> rowCount();

	if ($Count > 0) {
// if $Count > 0
		$SADArticles = $SADArtStmt-> fetch(); ?>

			<div class="container Artcle-Page">
				<h1 class="Page-First text-center">الأمن والدفاع</h1>
				<article class="row">
					<aside class="col-lg-8">
						<h1 class="Article-heading"><?php echo $SADArticles['SAD_Name']; ?></h1>
						<img src="Uploads/Images/<?php echo $SADArticles['SAD_Image']; ?>" alt="Article Image" height="300px" width="100%">
						<div class="panel panel-info">
							<div class="panel-heading">
								بواسطة: <a href="UserProfile.php?UserWriteID=<?php echo $SADArticles['SAD_Write']; ?>"> <?php echo $SADArticles['UserName']; ?> </a> |
								بتاريخ: <?php echo $SADArticles['SAD_Date']; ?>
								<?php 
									if ($SADArticles["SAD_Time"] > 12) {
										echo '<span>الساعة ';
										echo $SADArticles["SAD_Time"] - 12 . ' مساءً';
										echo "</span>";
									} elseif ($SADArticles["SAD_Time"] == 00) {

										echo '<span>الساعة ';
										echo $SADArticles["SAD_Time"] + 12 . ' صباحاً';
										echo "</span>";

									} else {
										echo '<span>الساعة ';
										echo $SADArticles["SAD_Time"] - 1 + 1 . ' صباحاً';
										echo "</span>";
									}

								?>
							</div>
							<div class="panel-body">
								<?php echo $SADArticles['SAD_Details']; ?>
							</div>
						</div>
						<div class="panel panel-success">
							<div class="panel-heading"> أترك تعليقك </div>
							<div class="panel-body">
								<form class="input-textarea form-group" action="AddComments.php" method="POST">
									<?php 

										if ($_GET['Art'] === 'SecurityAndDefense-Articles') {

											echo '<input type="hidden" name="ComSectionName" value="7">';
											echo '<input type="hidden" name="GETName" value="SecurityAndDefense-Articles">';

										}

									?>
									<input type="hidden" name="ArtID" value="<?php echo $ArtID; ?>">
									<label>تعليق</label>
									<textarea class="form-control" name="user-Comment"></textarea>
									<input class="btn btn-primary" type="submit" name="AddComment">
								</form>
							</div>
						</div>
						<hr>
						<?php 

							$ShowComment = $con-> prepare("SELECT 
																	comments.*, 
																	users.User_Name AS UserName,
																	users.User_Image AS UserImage
															   	FROM 
															   		comments 
															   	JOIN 
															   		users 
															   	ON 
															   		users.User_ID = comments.Com_UserName 
															   	WHERE 
															   		Com_SectionName = 7
															   	AND 
															   		Art_ID = ?
															   	ORDER BY 
															   		Com_Date 
															   	DESC
															   	");

							$ShowComment-> execute(array($ArtID));
							$Count = $ShowComment-> rowCount();

						?>
						<div class="panel panel-info">
							<div id="Comments" class="panel-heading">التعليقات: <?php echo $Count; ?></div>
							<div class="panel-body">
							<?php 

								if ($Count > 0) {

									$ComShow = $ShowComment-> fetchAll();
									date_default_timezone_set('Asia/Riyadh');
									$DayTody = date('Y-m-d');
									foreach($ComShow as $TheComments) {

									echo '<div class="panel panel-default">';
										echo '<div class="media">';
											echo '<div class="media-right">';
												echo '<a href="UserProfile.php?UserWriteID='. $TheComments['Com_UserName'] .'">';
													echo '<img src="Uploads/Images/'. $TheComments['UserImage'] .'" alt="Defualt Image" width="50px" height="60px">';
												echo '</a>';
											echo '</div>';
											echo '<div class="media-body">';
												echo '<h5>' . $TheComments['Com_Comments'] . '</h5>';
												echo '<div>';
													echo 'بواسطة <a href="UserProfile.php?UserWriteID='. $TheComments['Com_UserName'] .'">' . $TheComments['UserName'] . '</a> |';
													if ($DayTody === $TheComments['Com_Date']) {
													echo ' اليوم';
													} else {
														echo ' بتاريخ ' . $TheComments['Com_Date'];
														echo $Count;
													}
												echo '</div>';
											echo '</div>';
										echo '</div>';
									echo '</div>';

									}

								} else {

									echo "لا يوجد تعليقات";

								}
							
							?>
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
					</aside>
				</article>
			</div>


<?php		
// if $Count != 0
	} else {

		echo "<div class='Page-First container alert alert-danger'>لا يوجد مقال بهذا الأسم</div>";

	}
// SecurityAndDefense-Articles Page End
} elseif ($Art == 'Economy-Articles') {
// Economy-Articles Page Start

	$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;

	$EcoArtStmt = $con-> prepare("SELECT 
									economy.*, 
									users.User_Name AS UserName 
								  FROM 
								  	economy 
								  JOIN 
								  	users 
								  ON 
								  	users.User_ID = economy.Eco_Write
								  WHERE 
								  	Eco_ID = ?
								  ");
	$EcoArtStmt-> execute(array($ArtID));
	$Count = $EcoArtStmt-> rowCount();

	if ($Count > 0) {
// if $Count > 0
		$EcoArticles = $EcoArtStmt-> fetch(); ?>

			<div class="container Artcle-Page">
				<h1 class="Page-First text-center">الأقتصاد</h1>
				<article class="row">
					<aside class="col-lg-8">
						<h1 class="Article-heading"><?php echo $EcoArticles['Eco_Name']; ?></h1>
						<img src="Uploads/Images/<?php echo $EcoArticles['Eco_Image']; ?>" alt="Article Image" height="300px" width="100%">
						<div class="panel panel-info">
							<div class="panel-heading">
								بواسطة: <a href="UserProfile.php?UserWriteID=<?php echo $EcoArticles['Eco_Write']; ?>"> <?php echo $EcoArticles['UserName']; ?> </a> |
								بتاريخ: <?php echo $EcoArticles['Eco_Date']; ?>
								<?php 
									if ($EcoArticles["Eco_Time"] > 12) {
										echo '<span>الساعة ';
										echo $EcoArticles["Eco_Time"] - 12 . ' مساءً';
										echo "</span>";
									} elseif ($EcoArticles["Eco_Time"] == 00) {

										echo '<span>الساعة ';
										echo $EcoArticles["Eco_Time"] + 12 . ' صباحاً';
										echo "</span>";

									} else {
										echo '<span>الساعة ';
										echo $EcoArticles["Eco_Time"] - 1 + 1 . ' صباحاً';
										echo "</span>";
									}

								?>
							</div>
							<div class="panel-body">
								<?php echo $EcoArticles['Eco_Details']; ?>
							</div>
						</div>
						<div class="panel panel-success">
							<div class="panel-heading"> أترك تعليقك </div>
							<div class="panel-body">
								<form class="input-textarea form-group" action="AddComments.php" method="POST">
									<?php 

										if ($_GET['Art'] === 'Economy-Articles') {

											echo '<input type="hidden" name="ComSectionName" value="8">';
											echo '<input type="hidden" name="GETName" value="Economy-Articles">';

										}

									?>
									<input type="hidden" name="ArtID" value="<?php echo $ArtID; ?>">
									<label>تعليق</label>
									<textarea class="form-control" name="user-Comment"></textarea>
									<input class="btn btn-primary" type="submit" name="AddComment">
								</form>
							</div>
						</div>
						<hr>
						<?php 

							$ShowComment = $con-> prepare("SELECT 
																	comments.*, 
																	users.User_Name AS UserName,
																	users.User_Image AS UserImage
															   	FROM 
															   		comments 
															   	JOIN 
															   		users 
															   	ON 
															   		users.User_ID = comments.Com_UserName 
															   	WHERE 
															   		Com_SectionName = 8
															   	AND 
															   		Art_ID = ?
															   	ORDER BY 
															   		Com_Date 
															   	DESC
															   	");

							$ShowComment-> execute(array($ArtID));
							$Count = $ShowComment-> rowCount();

						?>
						<div class="panel panel-info">
							<div id="Comments" class="panel-heading">التعليقات: <?php echo $Count; ?></div>
							<div class="panel-body">
							<?php 

								if ($Count > 0) {

									$ComShow = $ShowComment-> fetchAll();
									date_default_timezone_set('Asia/Riyadh');
									$DayTody = date('Y-m-d');
									foreach($ComShow as $TheComments) {

									echo '<div class="panel panel-default">';
										echo '<div class="media">';
											echo '<div class="media-right">';
												echo '<a href="UserProfile.php?UserWriteID='. $TheComments['Com_UserName'] .'">';
													echo '<img src="Uploads/Images/'. $TheComments['UserImage'] .'" alt="Defualt Image" width="50px" height="60px">';
												echo '</a>';
											echo '</div>';
											echo '<div class="media-body">';
												echo '<h5>' . $TheComments['Com_Comments'] . '</h5>';
												echo '<div>';
													echo 'بواسطة <a href="UserProfile.php?UserWriteID='. $TheComments['Com_UserName'] .'">' . $TheComments['UserName'] . '</a> |';
													if ($DayTody === $TheComments['Com_Date']) {
													echo ' اليوم';
													} else {
														echo ' بتاريخ ' . $TheComments['Com_Date'];
														echo $Count;
													}
												echo '</div>';
											echo '</div>';
										echo '</div>';
									echo '</div>';

									}

								} else {

									echo "لا يوجد تعليقات";

								}
							
							?>
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
					</aside>
				</article>
			</div>


<?php		
// if $Count != 0
	} else {

		echo "<div class='Page-First container alert alert-danger'>لا يوجد مقال بهذا الأسم</div>";

	}
// Economy-Articles Page End
} elseif ($Art == 'Politics-Articles') {
// politics-Articles Page Start

	$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;

	$PolArtStmt = $con-> prepare("SELECT 
									politics.*, 
									users.User_Name AS UserName 
								  FROM 
								  	politics 
								  JOIN 
								  	users 
								  ON 
								  	users.User_ID = politics.Pol_Write
								  WHERE 
								  	Pol_ID = ?
								  ");
	$PolArtStmt-> execute(array($ArtID));
	$Count = $PolArtStmt-> rowCount();

	if ($Count > 0) {
// if $Count > 0
		$PolArticles = $PolArtStmt-> fetch(); ?>

			<div class="container Artcle-Page">
				<h1 class="Page-First text-center">السياسة</h1>
				<article class="row">
					<aside class="col-lg-8">
						<h1 class="Article-heading"><?php echo $PolArticles['Pol_Name']; ?></h1>
						<img src="Uploads/Images/<?php echo $PolArticles['Pol_Image']; ?>" alt="Article Image" height="300px" width="100%">
						<div class="panel panel-info">
							<div class="panel-heading">
								بواسطة: <a href="UserProfile.php?UserWriteID=<?php echo $PolArticles['Pol_Write']; ?>"> <?php echo $PolArticles['UserName']; ?> </a> |
								بتاريخ: <?php echo $PolArticles['Pol_Date']; ?>
								<?php 
									if ($PolArticles["Pol_Time"] > 12) {
										echo '<span>الساعة ';
										echo $PolArticles["Pol_Time"] - 12 . ' مساءً';
										echo "</span>";
									} elseif ($PolArticles["Pol_Time"] == 00) {

										echo '<span>الساعة ';
										echo $PolArticles["Pol_Time"] + 12 . ' صباحاً';
										echo "</span>";

									} else {
										echo '<span>الساعة ';
										echo $PolArticles["Pol_Time"] - 1 + 1 . ' صباحاً';
										echo "</span>";
									}

								?>
							</div>
							<div class="panel-body">
								<?php echo $PolArticles['Pol_Details']; ?>
							</div>
						</div>
						<div class="panel panel-success">
							<div class="panel-heading"> أترك تعليقك </div>
							<div class="panel-body">
								<form class="input-textarea form-group" action="AddComments.php" method="POST">
									<?php 

										if ($_GET['Art'] === 'Politics-Articles') {

											echo '<input type="hidden" name="ComSectionName" value="9">';
											echo '<input type="hidden" name="GETName" value="Politics-Articles">';

										}

									?>
									<input type="hidden" name="ArtID" value="<?php echo $ArtID; ?>">
									<label>تعليق</label>
									<textarea class="form-control" name="user-Comment"></textarea>
									<input class="btn btn-primary" type="submit" name="AddComment">
								</form>
							</div>
						</div>
						<hr>
						<?php 

							$ShowComment = $con-> prepare("SELECT 
																	comments.*, 
																	users.User_Name AS UserName,
																	users.User_Image AS UserImage
															   	FROM 
															   		comments 
															   	JOIN 
															   		users 
															   	ON 
															   		users.User_ID = comments.Com_UserName 
															   	WHERE 
															   		Com_SectionName = 9
															   	AND 
															   		Art_ID = ?
															   	ORDER BY 
															   		Com_Date 
															   	DESC
															   	");

							$ShowComment-> execute(array($ArtID));
							$Count = $ShowComment-> rowCount();

						?>
						<div class="panel panel-info">
							<div id="Comments" class="panel-heading">التعليقات: <?php echo $Count; ?></div>
							<div class="panel-body">
							<?php 

								if ($Count > 0) {

									$ComShow = $ShowComment-> fetchAll();
									date_default_timezone_set('Asia/Riyadh');
									$DayTody = date('Y-m-d');
									foreach($ComShow as $TheComments) {

									echo '<div class="panel panel-default">';
										echo '<div class="media">';
											echo '<div class="media-right">';
												echo '<a href="UserProfile.php?UserWriteID='. $TheComments['Com_UserName'] .'">';
													echo '<img src="Uploads/Images/'. $TheComments['UserImage'] .'" alt="Defualt Image" width="50px" height="60px">';
												echo '</a>';
											echo '</div>';
											echo '<div class="media-body">';
												echo '<h5>' . $TheComments['Com_Comments'] . '</h5>';
												echo '<div>';
													echo 'بواسطة <a href="UserProfile.php?UserWriteID='. $TheComments['Com_UserName'] .'">' . $TheComments['UserName'] . '</a> |';
													if ($DayTody === $TheComments['Com_Date']) {
													echo ' اليوم';
													} else {
														echo ' بتاريخ ' . $TheComments['Com_Date'];
														echo $Count;
													}
												echo '</div>';
											echo '</div>';
										echo '</div>';
									echo '</div>';

									}

								} else {

									echo "لا يوجد تعليقات";

								}
							
							?>
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
					</aside>
				</article>
			</div>


<?php		
// if $Count != 0
	} else {

		echo "<div class='Page-First container alert alert-danger'>لا يوجد مقال بهذا الأسم</div>";

	}
// politics-Articles Page End
} else {

	echo '<div class="Page-First container alert alert-danger">لا يوجد صفحة بهذا الأسم </div>';

}
?>

<?php include $TempDir . 'footer.php'; ?>