<?php 

	session_start();

	include 'init.php'; ?>

<?php

	$User = '';
	if ($_GET['User']) {
		$User = $_GET['User'];
	} else {
		$User = 'User';
	}

	if ($User == 'User') {

	$UsWrID = isset($_GET['UserWriteID']) && is_numeric($_GET['UserWriteID']) ? intval($_GET['UserWriteID']) : 0;

	$UserWriteProfileStmt = $con-> prepare("SELECT * FROM users WHERE User_ID = ?");
	$UserWriteProfileStmt-> execute(array($UsWrID));

	$Count = $UserWriteProfileStmt-> rowCount();

	if ($Count > 0) {

		$UserInfo = $UserWriteProfileStmt-> fetch(); ?>

		<div class="container">
		<article class="row">
			<h1 class="Page-First text-center">الملف الشخصي</h1>
			<aside class="col-lg-8">
					<div class="panel panel-success Profile-Page">
						<div class="user-Profile">
							<img src="Uploads/Images/<?php echo $UserInfo['User_Image']; ?>" alt="User Image" width="100px" height="100px">
							<?php echo '<mark>' . $UserInfo['User_Name'] . '</mark>'; ?>
							<div class="userfolo">
							<?php 

								if (isset($_SESSION['username'])) {

									$UserID = $_SESSION['UserID'];

									$UserSESSIONileStmt = $con-> prepare("SELECT * FROM users WHERE User_ID = ?");
									$UserSESSIONileStmt-> execute(array($UserID));

									$Count = $UserSESSIONileStmt-> rowCount();

									if ($Count > 0) {

										$UserWriteIDfo = $UserSESSIONileStmt-> fetch();

										$Followers = explode(',', $UserWriteIDfo['User_Following']);

										if (in_array($UserInfo['User_ID'], $Followers)) {
											echo '<a class="Follo-And-unfollo-danger btn btn-danger" href="Continue-User.php?ContinueUser=unFollowing&UserID='. $UsWrID .'">الغاء المتابعة</a>';
										} elseif ($UserInfo['User_ID'] == $UserID) {

										} else {
											echo '<a class="Follo-And-unfollo-primary btn btn-primary" href="Continue-User.php?ContinueUser=Following&UserID='. $UsWrID .'">متابعة</a>';
										}

									}

								} else {

									echo '<a class="Follo-And-unfollo btn btn-primary" href="login.php">متابعة</a>';

								}
							
							echo "<div class='Followers-And-Following'>";
								echo "<div class='Following-Section'>";
									$FollowingInfoStmt = $con-> prepare("SELECT * FROM users WHERE User_ID = ?");
									$FollowingInfoStmt-> execute(array($UsWrID));

									$Count = $FollowingInfoStmt-> rowCount();

									if ($Count > 0) {

										$UserWriteIDFollowingInfo = $FollowingInfoStmt-> fetch();

										$FollowingInfo = explode(',', $UserWriteIDFollowingInfo['User_Following']);

										$FollowingInfo_Count = Count($FollowingInfo);

										echo "يتابع " . '<br>';
										echo '<a href="UserProfile.php?UserWriteID='. $UsWrID .'&User=Following">' . ($FollowingInfo_Count - 2) . '</a>' . '<br>';
									}

								echo "</div>";
								echo "<div class='Followers-Section'>";
									$FollowersInfoStmt = $con-> prepare("SELECT * FROM users WHERE User_ID = ?");
									$FollowersInfoStmt-> execute(array($UsWrID));

									$Count = $FollowersInfoStmt-> rowCount();

									if ($Count > 0) {

										$UserWriteIDFollowersInfo = $FollowersInfoStmt-> fetch();

										$FollowersInfoExplode = explode(',', $UserWriteIDFollowersInfo['User_Followers']);

										$FollowersInfo_Count = Count($FollowersInfoExplode);

										echo "يتابعة " . '<br>';
										echo '<a href="UserProfile.php?UserWriteID='. $UsWrID .'&User=Followers">' . ($FollowersInfo_Count - 2) . '</a>' . '<br>';
									}

								echo "</div>";
							echo "</div>";

							?>
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
							</div>
							<div class="user-info2">
								<label> أسم المستخدم </label>
									<span class="text-right"><?php echo $UserInfo['User_Name']; ?></span><br>
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
							</div>
						</div>
					</div>
			</aside>
			<aside class="col-lg-4 left-aside">
				<div class="panel panel-success">
					<div class="panel-heading">
						مقالات <?php echo $UserInfo['User_Name']; ?>
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
																echo "بتاريخ " . $UserArticles['His_Date'];
																echo " | قسم <a href='History.php'>التاريخ</a>";
															echo "</div>";
													echo "</div>";
												echo "</div>";
											echo "</div>";

										}

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
																echo "بتاريخ " . $UserArticles['Cul_Date'];
																echo " | قسم <a href='Culture.php'>الثقافة</a>";
															echo "</div>";
													echo "</div>";
												echo "</div>";
											echo "</div>";

										}

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
																echo "بتاريخ " . $UserArticles['Com_Date'];
																echo " | قسم <a href='Community.php'>المجتمع</a>";
															echo "</div>";
													echo "</div>";
												echo "</div>";
											echo "</div>";

										}

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
																echo "بتاريخ " . $UserArticles['Tou_Date'];
																echo " | قسم <a href='Tourism.php'>السياحة</a>";
															echo "</div>";
													echo "</div>";
												echo "</div>";
											echo "</div>";

										}

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
																echo "بتاريخ " . $UserArticles['Spo_Date'];
																echo " | قسم <a href='Sport.php'>الرياضة</a>";
															echo "</div>";
													echo "</div>";
												echo "</div>";
											echo "</div>";

										}

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
																echo "بتاريخ " . $UserArticles['Web_Date'];
																echo " | قسم <a href='Websites.php'>مواقع الكترونية</a>";
															echo "</div>";
													echo "</div>";
												echo "</div>";
											echo "</div>";

										}

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
																echo "بتاريخ " . $UserArticles['SAD_Date'];
																echo " | قسم <a href='SecurityAndDefense.php'>الأمن والدفاع</a>";
															echo "</div>";
													echo "</div>";
												echo "</div>";
											echo "</div>";

										}

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
																echo "بتاريخ " . $UserArticles['Eco_Date'];
																echo " | قسم <a href='Economy.php'>الأقتصاد</a>";
															echo "</div>";
													echo "</div>";
												echo "</div>";
											echo "</div>";

										}

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
																echo "بتاريخ " . $UserArticles['Pol_Date'];
																echo " | قسم <a href='Politics.php'>السياسة</a>";
															echo "</div>";
													echo "</div>";
												echo "</div>";
											echo "</div>";

										}

									}

								?>
					</div>
				</div>
			</aside>
		</article>
	</div>
<?php 
		} else {

		echo "<div class='Page-First container alert alert-warning'>لا يوجد مستخدم بهذا الأسم</div>";

	}

	} elseif ($User == 'Following') { ?>

		<div class="container">
			<h3 class="Page-First text-center">يتابع</h3>
			<article class="row">
				<aside class="col-lg-6">
					<div class="panel-body">
						<div class="panel panel-default"> 
							<div class="media">
								<div class="media-body">
									<h5 class="Followers-Following-heding">
										<?php 
										$UsWrID = isset($_GET['UserWriteID']) && is_numeric($_GET['UserWriteID']) ? intval($_GET['UserWriteID']) : 0;

										$FollowingInfoStmt = $con-> prepare("SELECT * FROM users WHERE User_ID = ?");
										$FollowingInfoStmt-> execute(array($UsWrID));

										$Count = $FollowingInfoStmt-> rowCount();

										if ($Count > 0) {

											$UserWriteIDFollowingInfo = $FollowingInfoStmt-> fetch();

											$FollowingInfo = explode(',', $UserWriteIDFollowingInfo['User_Following']);

											foreach ($FollowingInfo as $Foll) {

												$FollowingInfoStmt = $con-> prepare("SELECT * FROM users WHERE User_ID = ?");
												$FollowingInfoStmt-> execute(array($Foll));

												$Count = $FollowingInfoStmt-> rowCount();

												if ($Count > 0) {

													$FollInfo = $FollowingInfoStmt-> fetchAll();

													foreach($FollInfo as $FollowerInfo) {
														echo '<a href="UserProfile.php?UserWriteID='. $Foll .'">' . $FollowerInfo['User_Name'] . '</a><hr>';
													}
												}
											}
										}

										?>
									</h5>
								</div>
							</div>
						</div>
					</div>
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

	} elseif ($User == 'Followers') { ?>

		<div class="container">
			<h3 class="Page-First text-center">يتابع</h3>
			<article class="row">
				<aside class="col-lg-6">
					<div class="panel-body">
						<div class="panel panel-default"> 
							<div class="media">
								<div class="media-body">
									<h5 class="Followers-Following-heding">
										<?php
											$UsWrID = isset($_GET['UserWriteID']) && is_numeric($_GET['UserWriteID']) ? intval($_GET['UserWriteID']) : 0;

											$FollowersInfoStmt = $con-> prepare("SELECT * FROM users WHERE User_ID = ?");
											$FollowersInfoStmt-> execute(array($UsWrID));

											$Count = $FollowersInfoStmt-> rowCount();

											if ($Count > 0) {

												$UserWriteIDFollowersInfo = $FollowersInfoStmt-> fetch();
												$FollowersInfoExplode = explode(',', $UserWriteIDFollowersInfo['User_Followers']);

												foreach ($FollowersInfoExplode as $Foll) {

													$FollowingInfoStmt = $con-> prepare("SELECT * FROM users WHERE User_ID = ?");
													$FollowingInfoStmt-> execute(array($Foll));

													$Count = $FollowingInfoStmt-> rowCount();

													if ($Count > 0) {

														$FollInfo = $FollowingInfoStmt-> fetchAll();

														foreach($FollInfo as $FollowerInfo) {
															echo '<a href="UserProfile.php?UserWriteID='. $Foll .'">' . $FollowerInfo['User_Name'] . '</a><hr>';
														}
													}
												}
											}
										?>
									</h5>
								</div>
							</div>
						</div>
					</div>
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

	header('Location: Admin/Admin.php');
	exit();

}

include $TempDir . 'footer.php';