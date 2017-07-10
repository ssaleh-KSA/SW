<?php 
	
	session_start();

	if (isset($_SESSION['username'])) {

		include 'init.php';

		$Profile = '';

		if (isset($_GET['Profile'])) {

			$Profile = $_GET['Profile'];

		} else {

			$Profile = 'Profile';

		}

			$UserProfileStmt = $con-> prepare("SELECT * FROM users WHERE User_Name = ?");
			$UserProfileStmt-> execute(array($_SESSION['username']));
			$UserInfo = $UserProfileStmt-> fetch();

// Profile Page Start
		if ($Profile == 'Profile') { ?>
			<div class="container">
				<article class="row">
					<h1 class="Page-First text-center">الملف الشخصي</h1>
					<aside class="col-lg-8">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="Profile-Page">
								<div class="user-Profile">
									<img src="Uploads/Images/<?php echo $UserInfo['User_Image']; ?>" alt="User Image" width="100px" height="100px">
									<a href="Profile.php?Profile=Image-Edit">تحرير الصورة</a>
									<div class="user-info1">
										<div class="font-box">
											<span class="fa-stack fa-lg">
											  	<i class="fa fa-circle-thin fa-stack-2x"></i>
												<i class="fa fa-twitter-square fa-stack-1x"></i>
											</span>
											<span class="fa-stack fa-lg">
											  	<i class="fa fa-circle-thin fa-stack-2x"></i>
												<i class="fa fa-facebook-square fa-stack-1x"></i>
											</span>
											<span class="fa-stack fa-lg">
											  	<i class="fa fa-circle-thin fa-stack-2x"></i>
												<i class="fa fa-youtube-square fa-stack-1x"></i>
											</span>
											<span class="fa-stack fa-lg">
											  	<i class="fa fa-circle-thin fa-stack-2x"></i>
												<i class="fa fa-google-plus-square fa-stack-1x"></i>
											</span>
											<span class="fa-stack fa-lg">
											  	<i class="fa fa-circle-thin fa-stack-2x"></i>
												<i class="fa fa-instagram fa-stack-1x"></i>
											</span>
										</div>
									</div>
									<div class="user-info2">
											<a href="Profile.php?Profile=Password-Edit" class="btn btn-primary">تغيير الرقم السري</a><hr>
											<label> أسم المستخدم </label>
											<span class="text-right"><?php echo $UserInfo['User_Name']; ?></span> <a href="Profile.php?Profile=Username-Edit">تحرير</a><br>
											<label> الجنسية </label>
											<span class="text-right"><?php echo $UserInfo['User_From']; ?></span><br>
											<label> الأيميل </label>
											<span class="text-right"><?php echo $UserInfo['User_Email']; ?></span><br>
											<label> الأسم </label>
											<span class="text-right"><?php echo $UserInfo['User_FullName']; ?></span><br>
											<label> العمر </label>
											<span class="text-right"><?php echo $UserInfo['User_Age']; ?></span><br>
										<label> الجنس </label>
											<span class="text-right"><?php if ($UserInfo['User_Sex'] == 1) { echo "ذكر"; } else { echo "أنثى"; } ?></span><br>
											<label> تاريخ التسجيل </label>
											<span class="text-right"><?php echo $UserInfo['Reg_Date']; ?></span><br>

										<a href="Profile.php?Profile=Profile-Edit" class="btn btn-primary">تحرير</a>
										<a href="Profile.php?Profile=Account-Delete&UserID=<?php echo $UserInfo['User_ID']; ?>" class="Account-Delete btn btn-danger">حذف الحساب</a>
									</div>
								</div>
							</div>
						</div>
					</aside>
					<aside class="col-lg-4 left-aside">
						<div class="panel panel-success">
							<div class="panel-heading">
								مقالاتي
							</div>
							<div class="panel-body">
								<?php 

									$UserArticlesStmt = $con-> prepare("SELECT * FROM history WHERE His_Write = ? ORDER BY His_ID DESC");
									$UserArticlesStmt-> execute(array($UserInfo['User_ID']));
									$Count = $UserArticlesStmt-> rowCount();

									if ($Count > 0) {

										$UserArt = $UserArticlesStmt-> fetchAll();

										foreach($UserArt as $UserArticles) {

											echo "<div class='panel panel-default'>";
												echo "<div class='media'>";
													echo "<div class='media-right'>";
														echo "<img src='Uploads/Images/". $UserArticles['His_Image'] ."' width='50px' height='50px'>";
													echo "</div>";
													echo "<div class='media-body'>";
														echo "<a href='Articles.php?Art=History-Articles&ArtID=". $UserArticles['His_ID'] ."'>";
															echo $UserArticles['His_Name'];
															echo "</a>";
															echo "<div class='ArtUserPro'>";
																echo "<a href='History.php?Art=His-Edit&ArtID=". $UserArticles['His_ID'] ."'>تحرير</a>";
																echo " | <a class='Art-Delete' href='History.php?Art=His-Delete&ArtID=". $UserArticles['His_ID'] ."'>حذف</a>";
																echo " | قسم <a href='History.php'>التاريخ</a>";
															echo "</div>";
													echo "</div>";
												echo "</div>";
											echo "</div>";

										}

									} else {

										echo "لا يوجد مقالات";

									}

								?>
								<?php 

									$UserArticlesStmt = $con-> prepare("SELECT * FROM culture WHERE Cul_Write = ? ORDER BY Cul_ID DESC");
									$UserArticlesStmt-> execute(array($UserInfo['User_ID']));
									$Count = $UserArticlesStmt-> rowCount();


									if ($Count > 0) {

										$UserArt = $UserArticlesStmt-> fetchAll();

										foreach($UserArt as $UserArticles) {

											echo "<div class='panel panel-default'>";
												echo "<div class='media'>";
													echo "<div class='media-right'>";
														echo "<img src='Uploads/Images/". $UserArticles['Cul_Image'] ."' width='50px' height='50px'>";
													echo "</div>";
													echo "<div class='media-body'>";
														echo "<a href='Articles.php?Art=Culture-Articles&ArtID=". $UserArticles['Cul_ID'] ."'>";
															echo $UserArticles['Cul_Name'];
															echo "</a>";
															echo "<div class='ArtUserPro'>";
																echo "<a href='Culture.php?Art=Cul-Edit&ArtID=". $UserArticles['Cul_ID'] ."'>تحرير</a>";
																echo " | <a class='Art-Delete' href='Culture.php?Art=Cul-Delete&ArtID=". $UserArticles['Cul_ID'] ."'>حذف</a>";
																echo " | قسم <a href='Culture.php'>الثقافة</a>";
															echo "</div>";
													echo "</div>";
												echo "</div>";
											echo "</div>";

										}

									} else {

										echo "لا يوجد مقالات";

									}

								?>
								<?php 

									$UserArticlesStmt = $con-> prepare("SELECT * FROM community WHERE Com_Write = ? ORDER BY Com_ID DESC");
									$UserArticlesStmt-> execute(array($UserInfo['User_ID']));
									$Count = $UserArticlesStmt-> rowCount();


									if ($Count > 0) {

										$UserArt = $UserArticlesStmt-> fetchAll();

										foreach($UserArt as $UserArticles) {

											echo "<div class='panel panel-default'>";
												echo "<div class='media'>";
													echo "<div class='media-right'>";
														echo "<img src='Uploads/Images/". $UserArticles['Com_Image'] ."' width='50px' height='50px'>";
													echo "</div>";
													echo "<div class='media-body'>";
														echo "<a href='Articles.php?Art=Community-Articles&ArtID=". $UserArticles['Com_ID'] ."'>";
															echo $UserArticles['Com_Name'];
															echo "</a>";
															echo "<div class='ArtUserPro'>";
																echo "<a href='Community.php?Art=Com-Edit&ArtID=". $UserArticles['Com_ID'] ."'>تحرير</a>";
																echo " | <a class='Art-Delete' href='Community.php?Art=Com-Delete&ArtID=". $UserArticles['Com_ID'] ."'>حذف</a>";
																echo " | قسم <a href='Community.php'>المجتمع</a>";
															echo "</div>";
													echo "</div>";
												echo "</div>";
											echo "</div>";

										}

									} else {

										echo "لا يوجد مقالات";

									}

								?>
								<?php 

									$UserArticlesStmt = $con-> prepare("SELECT * FROM tourism WHERE Tou_Write = ? ORDER BY Tou_ID DESC");
									$UserArticlesStmt-> execute(array($UserInfo['User_ID']));
									$Count = $UserArticlesStmt-> rowCount();


									if ($Count > 0) {

										$UserArt = $UserArticlesStmt-> fetchAll();

										foreach($UserArt as $UserArticles) {

											echo "<div class='panel panel-default'>";
												echo "<div class='media'>";
													echo "<div class='media-right'>";
														echo "<img src='Uploads/Images/". $UserArticles['Tou_Image'] ."' width='50px' height='50px'>";
													echo "</div>";
													echo "<div class='media-body'>";
														echo "<a href='Articles.php?Art=Tourism-Articles&ArtID=". $UserArticles['Tou_ID'] ."'>";
															echo $UserArticles['Tou_Name'];
															echo "</a>";
															echo "<div class='ArtUserPro'>";
																echo "<a href='Tourism.php?Art=Tou-Edit&ArtID=". $UserArticles['Tou_ID'] ."'>تحرير</a>";
																echo " | <a class='Art-Delete' href='Tourism.php?Art=Tou-Delete&ArtID=". $UserArticles['Tou_ID'] ."'>حذف</a>";
																echo " | قسم <a href='Tourism.php'>السياحة</a>";
															echo "</div>";
													echo "</div>";
												echo "</div>";
											echo "</div>";

										}

									} else {

										echo "لا يوجد مقالات";

									}

								?>
								<?php 

									$UserArticlesStmt = $con-> prepare("SELECT * FROM sport WHERE Spo_Write = ? ORDER BY Spo_ID DESC");
									$UserArticlesStmt-> execute(array($UserInfo['User_ID']));
									$Count = $UserArticlesStmt-> rowCount();


									if ($Count > 0) {

										$UserArt = $UserArticlesStmt-> fetchAll();

										foreach($UserArt as $UserArticles) {

											echo "<div class='panel panel-default'>";
												echo "<div class='media'>";
													echo "<div class='media-right'>";
														echo "<img src='Uploads/Images/". $UserArticles['Spo_Image'] ."' width='50px' height='50px'>";
													echo "</div>";
													echo "<div class='media-body'>";
														echo "<a href='Articles.php?Art=Sport-Articles&ArtID=". $UserArticles['Spo_ID'] ."'>";
															echo $UserArticles['Spo_Name'];
															echo "</a>";
															echo "<div class='ArtUserPro'>";
																echo "<a href='Sport.php?Art=Spo-Edit&ArtID=". $UserArticles['Spo_ID'] ."'>تحرير</a>";
																echo " | <a class='Art-Delete' href='Sport.php?Art=Spo-Delete&ArtID=". $UserArticles['Spo_ID'] ."'>حذف</a>";
																echo " | قسم <a href='Sport.php'>الرياضة</a>";
															echo "</div>";
													echo "</div>";
												echo "</div>";
											echo "</div>";

										}

									} else {

										echo "لا يوجد مقالات";

									}

								?>
								<?php 

									$UserArticlesStmt = $con-> prepare("SELECT * FROM websites WHERE Web_Write = ? ORDER BY Web_ID DESC");
									$UserArticlesStmt-> execute(array($UserInfo['User_ID']));
									$Count = $UserArticlesStmt-> rowCount();


									if ($Count > 0) {

										$UserArt = $UserArticlesStmt-> fetchAll();

										foreach($UserArt as $UserArticles) {

											echo "<div class='panel panel-default'>";
												echo "<div class='media'>";
													echo "<div class='media-right'>";
														echo "<img src='Uploads/Images/". $UserArticles['Web_Image'] ."' width='50px' height='50px'>";
													echo "</div>";
													echo "<div class='media-body'>";
														echo "<a href='Articles.php?Art=Websites-Articles&ArtID=". $UserArticles['Web_ID'] ."'>";
															echo $UserArticles['Web_Name'];
															echo "</a>";
															echo "<div class='ArtUserPro'>";
																echo "<a href='Websites.php?Art=Web-Edit&ArtID=". $UserArticles['Web_ID'] ."'>تحرير</a>";
																echo " | <a class='Art-Delete' href='Websites.php?Art=Web-Delete&ArtID=". $UserArticles['Web_ID'] ."'>حذف</a>";
																echo " | قسم <a href='Websites.php'>مواقع الكترونية</a>";
															echo "</div>";
													echo "</div>";
												echo "</div>";
											echo "</div>";

										}

									} else {

										echo "لا يوجد مقالات";

									}

								?>
								<?php 

									$UserArticlesStmt = $con-> prepare("SELECT * FROM security_and_defense WHERE SAD_Write = ? ORDER BY SAD_ID DESC");
									$UserArticlesStmt-> execute(array($UserInfo['User_ID']));
									$Count = $UserArticlesStmt-> rowCount();


									if ($Count > 0) {

										$UserArt = $UserArticlesStmt-> fetchAll();

										foreach($UserArt as $UserArticles) {

											echo "<div class='panel panel-default'>";
												echo "<div class='media'>";
													echo "<div class='media-right'>";
														echo "<img src='Uploads/Images/". $UserArticles['SAD_Image'] ."' width='50px' height='50px'>";
													echo "</div>";
													echo "<div class='media-body'>";
														echo "<a href='Articles.php?Art=SecurityAndDefense-Articles&ArtID=". $UserArticles['SAD_ID'] ."'>";
															echo $UserArticles['SAD_Name'];
															echo "</a>";
															echo "<div class='ArtUserPro'>";
																echo "<a href='SecurityAndDefense.php?Art=SAD-Edit&ArtID=". $UserArticles['SAD_ID'] ."'>تحرير</a>";
																echo " | <a class='Art-Delete' href='SecurityAndDefense.php?Art=SAD-Delete&ArtID=". $UserArticles['SAD_ID'] ."'>حذف</a>";
																echo " | قسم <a href='SecurityAndDefense.php'>الأمن والدفاع</a>";
															echo "</div>";
													echo "</div>";
												echo "</div>";
											echo "</div>";

										}

									} else {

										echo "لا يوجد مقالات";

									}

								?>
								<?php 

									$UserArticlesStmt = $con-> prepare("SELECT * FROM economy WHERE Eco_Write = ? ORDER BY Eco_ID DESC");
									$UserArticlesStmt-> execute(array($UserInfo['User_ID']));
									$Count = $UserArticlesStmt-> rowCount();


									if ($Count > 0) {

										$UserArt = $UserArticlesStmt-> fetchAll();

										foreach($UserArt as $UserArticles) {

											echo "<div class='panel panel-default'>";
												echo "<div class='media'>";
													echo "<div class='media-right'>";
														echo "<img src='Uploads/Images/". $UserArticles['Eco_Image'] ."' width='50px' height='50px'>";
													echo "</div>";
													echo "<div class='media-body'>";
														echo "<a href='Articles.php?Art=Economy-Articles&ArtID=". $UserArticles['Eco_ID'] ."'>";
															echo $UserArticles['Eco_Name'];
															echo "</a>";
															echo "<div class='ArtUserPro'>";
																echo "<a href='Economy.php?Art=Eco-Edit&ArtID=". $UserArticles['Eco_ID'] ."'>تحرير</a>";
																echo " | <a class='Art-Delete' href='Economy.php?Art=Eco-Delete&ArtID=". $UserArticles['Eco_ID'] ."'>حذف</a>";
																echo " | قسم <a href='Economy.php'>الأقتصاد</a>";
															echo "</div>";
													echo "</div>";
												echo "</div>";
											echo "</div>";

										}

									} else {

										echo "لا يوجد مقالات";

									}

								?>
								<?php 

									$UserArticlesStmt = $con-> prepare("SELECT * FROM politics WHERE Pol_Write = ? ORDER BY Pol_ID DESC");
									$UserArticlesStmt-> execute(array($UserInfo['User_ID']));
									$Count = $UserArticlesStmt-> rowCount();


									if ($Count > 0) {

										$UserArt = $UserArticlesStmt-> fetchAll();

										foreach($UserArt as $UserArticles) {

											echo "<div class='panel panel-default'>";
												echo "<div class='media'>";
													echo "<div class='media-right'>";
														echo "<img src='Uploads/Images/". $UserArticles['Pol_Image'] ."' width='50px' height='50px'>";
													echo "</div>";
													echo "<div class='media-body'>";
														echo "<a href='Articles.php?Art=Politics-Articles&ArtID=". $UserArticles['Pol_ID'] ."'>";
															echo $UserArticles['Pol_Name'];
															echo "</a>";
															echo "<div class='ArtUserPro'>";
																echo "<a href='Politics.php?Art=Pol-Edit&ArtID=". $UserArticles['Pol_ID'] ."'>تحرير</a>";
																echo " | <a class='Art-Delete' href='Politics.php?Art=Pol-Delete&ArtID=". $UserArticles['Pol_ID'] ."'>حذف</a>";
																echo " | قسم <a href='Politics.php'>السياسة</a>";
															echo "</div>";
													echo "</div>";
												echo "</div>";
											echo "</div>";

										}

									} else {

										echo "لا يوجد مقالات";

									}

								?>
							</div>
						</div>
					</aside>
				</article>
			</div>

<?php 
// Profile Page End
// Profile-Edit Page Start
		} elseif ($Profile == 'Profile-Edit') { ?>

		<div class="container">
			<article class="row">
				<h1 class="Page-First text-center">تحرير الملف الشخصي</h1>
				<aside class="col-lg-8">
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<form class="form-group" action="?Profile=Profile-Update" method='POST' enctype="multipart/form-data">
							<label> الأيميل </label>
								<input class="form-control" type="email" name="Email" value="<?php echo $UserInfo['User_Email'] ?>">
							<label> الأسم كامل </label>
								<input class="form-control" type="text" name="FullName" value="<?php echo $UserInfo['User_FullName'] ?>">
							<label> الجنسية </label>
								<input class="form-control" type="text" name="UserFrom" value="<?php echo $UserInfo['User_From'] ?>">
							<label> العمر </label>
								<input class="form-control" type="text" name="UserAge" value="<?php echo $UserInfo['User_Age'] ?>">
							<label> الجنس </label>
								<select class="form-control" name="UserSex">
									<option value="0">---</option>
									<option value="1" <?php if ($UserInfo['User_Sex'] == 1) {echo 'selected';} ?>> ذكر </option>
									<option value="2" <?php if ($UserInfo['User_Sex'] == 2) {echo 'selected';} ?>> أنثى </option>
								</select>
							<input class="btn btn-primary" type="submit" name="تحديث" value="تحديث">
						</form>
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
				</aside>
			</article>
		</div>

<?php
// Profile-Edit Page End
// Profile-Update Page Start
		} elseif ($Profile == 'Profile-Update') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo "<h4 class='Page-First text-center'>تحديث الملف الشخصي</h4>";

				$Email = filter_var($_POST['Email'], FILTER_SANITIZE_EMAIL);
				$FullName = filter_var($_POST['FullName'], FILTER_SANITIZE_STRING);
				$UserFrom = filter_var($_POST['UserFrom'], FILTER_SANITIZE_STRING);
				$UserAge = filter_var($_POST['UserAge'], FILTER_SANITIZE_NUMBER_INT);
				$UserSex = $_POST['UserSex'];

				$UserInfoError = array();

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
				foreach ($UserInfoError as $UserError) {
					echo "<div class='container alert alert-danger'>" . $UserError . "</div>";
				}

				if (empty($UserInfoError)) {

					$UserID = $UserInfo['User_ID'];

					$CheckUser = $con-> prepare("SELECT * FROM users WHERE User_Name = ? AND User_ID != ?");
				 	$CheckUser -> execute(array($Username, $UserID));

				 	$Count = $CheckUser-> rowCount();

				 	if ($Count == 1) {

				 		echo "<div class='container alert alert-danger'>أسم المستخدم هذا مستخدم من قبل</div>";

				 	} else {

				 		$UserAddStmt = $con-> prepare("UPDATE users SET User_Email = ?, User_FullName = ?, User_From = ?, User_Age = ?, User_Sex = ? WHERE User_ID = ?");
						$UserAddStmt-> execute(array($Email, $FullName, $UserFrom, $UserAge, $UserSex, $UserID));

						echo "<div class='container alert alert-success'>تم تحديث بياناتك بنجاح </div>";

						header("Location: Profile.php");
						exit();

				 	}

				}

			} else {

				header('Location: index.php');
				exit();

			}
// Profile-Update Page End
// Username-Edit Page Start
		} elseif ($Profile == 'Username-Edit') { ?>
			<div class="container">
				<article class="row">
				<h1 class='Page-First text-center'>تحرير أسم المستخدم</h1>
					<aside class="col-lg-8">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<form class="form-group" action="?Profile=Username-Update" method="POST">
				 				<label>أسم المستخدم</label>
								<input class="form-control" type="text" name="NewUserName">
								<input class="btn btn-primary" type="submit" name="Send" value="تحديث">
								<div class="alert alert-warning">بعد الضغط على تحديث سوف يتم تسجيل خروجك من الموقع, بعد ذالك سجل دخولك بأسم المستخدم الجديد</div>
							</form>
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
					</aside>
				</article>
			</div>

<?php
// Username-Edit Page End
// Username-Update Page Start
		} elseif ($Profile == 'Username-Update')  {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$UserID = $UserInfo['User_ID'];

				echo "<h4 class='Page-First text-center'>تحديث أسم المستخدم</h4>";

				$NewUserName = filter_var($_POST['NewUserName'], FILTER_SANITIZE_STRING);

				if (empty($NewUserName)) {

					header('Location: Profile.php?Profile=Username-Edit');
					exit();

				} else {

					$CheckUser = $con-> prepare("SELECT * FROM users WHERE User_Name = ? AND User_ID = ?");
				 	$CheckUser -> execute(array($NewUserName, $UserID));

				 	$Count = $CheckUser-> rowCount();

				 	if ($Count == 1) {

				 		echo "<div class='container alert alert-danger'>أسم المستخدم هذا مستخدم من قبل</div>";

				 	} else {

				 		$UserAddStmt = $con-> prepare("UPDATE users SET User_Name = ? WHERE User_ID = ?");
						$UserAddStmt-> execute(array($NewUserName, $UserID));

							header("Location: logout.php");
							exit();

				 	}

				}

			} else {

				header('Location: index.php');
				exit();

			}
// Username-Update Page Start
// ImageProfile-Edit Page Start
		} elseif ($Profile == 'Image-Edit') { ?>

			<div class="container">
				<article class="row">
				<h1 class='Page-First text-center'>تحرير صورة البروفايل</h1>
					<aside class="col-lg-8">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<form class="form-group" action="?Profile=Image-Update" method="POST" enctype="multipart/form-data">
				 				<label>صورة العرض</label>
								<input class="form-control" type="file" name="NewProfileImage">
								<input class="btn btn-primary" type="submit" name="Send" value="تحديث">
							</form>
							<div class='alert alert-warning'><i class="fa fa-exclamation-circle fa-2x"></i> يجب أن تختار صورة<div>
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
					</aside>
				</article>
			</div>

<?php
// ImageProfile-Edit Page End
// ImageProfile-Update Page Start
		} elseif ($Profile == 'Image-Update') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$UserName = $UserInfo['User_Name'];
				$UserID = $UserInfo['User_ID'];

				echo "<h4 class='Page-First text-center'>تحديث صورة البروفايل</h4>";

				$ImageName = $_FILES['NewProfileImage']['name'];
				$ImageSize = $_FILES['NewProfileImage']['size'];
				$ImageType = $_FILES['NewProfileImage']['type'];
				$ImageTmp_Name = $_FILES['NewProfileImage']['tmp_name'];

				$ImageToLo = strtolower($ImageName);
				$ImageToExplode = explode('.', $ImageToLo);
				$ImageExtension = end($ImageToExplode);

					if (empty($ImageName)) {

						header('Location: Profile.php?Profile=Image-Edit');
						exit();

					} else {

						$CheckUser = $con-> prepare("SELECT * FROM users WHERE User_Name = ? AND User_ID = ?");
						$CheckUser-> execute(array($UserName, $UserID));

						$Count = $CheckUser-> rowCount();

					 	if ($Count == 1) {

					 		$Image = rand(0, 100000) . '_' . $ImageName;

					 		move_uploaded_file($ImageTmp_Name, 'Uploads/Images/' . $Image);

					 		$UserAddStmt = $con-> prepare("UPDATE users SET User_Image = ? WHERE User_ID = ?");
							$UserAddStmt-> execute(array($Image, $UserID));

							header("Location: Profile.php");
							exit();

			 			}

					}

			} else {

				header('Location: index.php');
				exit();

			}


// ImageProfile-Update Page End
// Password-Edit Page Start
		} elseif ($Profile == 'Password-Edit') { ?>

			<div class="container">
				<article class="row">
				<h1 class='Page-First text-center'>تغيير الرقم السري</h1>
					<aside class="col-lg-8">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<form class="form-group" action="?Profile=Password-Update" method="POST">
				 				<label>الرقم السري القديم</label>
								<input class="form-control" type="password" name="OldPassword">
								هل نسيت الرقم السري<a href="Profile.php?Profile=Forgot-Password"> نعم</a><br>
								<label>الرقم السري الجديد</label>
								<input class="form-control" type="password" name="NewPassword">
								<input class="btn btn-primary" type="submit" name="Send" value="تحديث">
							</form>
							<div class='alert alert-warning'><i class="fa fa-exclamation-circle fa-2x"></i> بعد الضغط على تحديث سوف يتم تسجيل خروجك من الموقع, بعد ذالك سجل دخولك بالرقم السري الجديد <div>
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
					</aside>
				</article>
			</div>

<?php
// Password-Edit Page End
// Password-Update Page Start
		} elseif ($Profile == 'Password-Update') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo "<h1 class='Page-First text-center'>تحديث الرقم السري</h1>";

				$User_Password = $UserInfo['User_Password'];
				$UserID = $UserInfo['User_ID'];

				$OldPassword = sha1($_POST['OldPassword']);
				$NewPassword = sha1($_POST['NewPassword']);

				if (empty($OldPassword or $NewPassword)) {

					header('Location: Profile.php?Profile=Password-Edit');
					exit();

				} else {

					if ($OldPassword != $User_Password) {

						echo "<div class='container alert alert-danger'>الرقم السري القديم غير صحيح</div>";

					} else {

						$CheckUser = $con-> prepare("SELECT * FROM users WHERE User_ID = ?");
					 	$CheckUser -> execute(array($UserID));

					 	$Count = $CheckUser-> rowCount();

					 	if ($Count == 1) {

					 		$UserAddStmt = $con-> prepare("UPDATE users SET User_Password = ? WHERE User_ID = ?");
							$UserAddStmt-> execute(array($NewPassword, $UserID));

							header("Location: logout.php");
							exit();

					 	} else {

					 		echo "<div class='container alert alert-danger'>أسم المستخدم هذا مستخدم من قبل</div>";

					 	}

					}

				}

			} else {

				header('Location: Profile.php');
				exit();

			}

// Password-Update Page End
// Forgot-Password Page Start
		} elseif ($Profile == 'Forgot-Password') { ?>

			<div class="container">
				<article class="row">
				<h1 class='Page-First text-center'>أستعادة كلمة المرور</h1>
					<aside class="col-lg-8">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<form class="form-group" action="?Profile=Forgot-Password-Update" method="POST">
				 				<label>أدخل ايميلك المسجل به في الموقع</label>
								<input class="form-control" type="email" name="EmailPasswordSend">
								<input class="btn btn-primary" type="submit" name="Send" value="أرسل">
							</form>
							<div class='alert alert-warning'><i class="fa fa-exclamation-circle fa-2x"></i> سوف يتم أرسال رقم سري جديد الى إيميلك, أستخدمة في تغيير الرقم السري, في حقل الرقم السري القديم, في هذه الصفحة <a href="Profile.php?Profile=Password-Edit"> هنا </a> <div>
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
					</aside>
				</article>
			</div>

<?php
// Forgot-Password Page End
// Forgot-Password-Update Page Start
		} elseif ($Profile == 'Forgot-Password-Update') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$UserID = $UserInfo['User_ID'];
				$EmailToSend = filter_var($_POST['EmailPasswordSend'], FILTER_SANITIZE_EMAIL);
				$passrand = rand(0, 1000000);
				$Temporary_PIN = sha1($passrand);

				$Temporary_Password = $con-> prepare("SELECT * FROM users WHERE User_ID = ? LIMIT 1");
				$Temporary_Password-> execute(array($UserID));
				$Count = $Temporary_Password-> rowCount();

				if ($Count == 1) {

					$Temporary_NewPassword = $con-> prepare("UPDATE users SET User_Password = ? WHERE User_ID = ?");
					$Temporary_NewPassword-> execute(array($Temporary_PIN, $UserID));

				}

			} else {

				header('Location: Profile.php');
				exit();

			}

// Forgot-Password-Update Page End
// Account-Delete Page Start
		} elseif ($Profile == 'Account-Delete') {

			$UserID = isset($_GET['UserID']) && is_numeric($_GET['UserID']) ? intval($_GET['UserID']) : 0;

			$AccountDeleteStmt = $con-> prepare("DELETE FROM users WHERE User_ID = :UserID");
			$AccountDeleteStmt-> bindParam(':UserID', $UserID);
			$AccountDeleteStmt-> execute();

			header('Location: logout.php');
			exit();


// Account-Delete Page End
		} else {

			header('Location: index.php');
			exit();

		}


// SESSION isset
	} else {

		header('Location: index.php');
		exit();

	}

	include $TempDir . 'footer.php';