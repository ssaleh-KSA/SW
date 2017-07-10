<?php

session_start();

if (isset($_SESSION['Ad-Un-SESSION'])) {

	include 'init.php';

	$Info = '';

	if (isset($_GET['Info'])) {
		$Info = $_GET['Info'];
	} else {
		header('Location: Admin.php');
		exit();
	}

	if ($Info == 'users') {

		$AlertGET = '';

		if(isset($_GET['alerts'])) {

			$AlertGET = 'WHERE Alerts = 1';

		} else {

			$AlertGET = '';

		}

		$WebInfoStmt = $con-> prepare("SELECT * FROM users $AlertGET ORDER BY User_ID DESC");
		$WebInfoStmt-> execute();
		$Count = $WebInfoStmt-> rowCount();
		if ($Count > 0) {

			$users = $WebInfoStmt-> fetchAll(); ?>

			<h1 class="Page-First text-center"> الأعضاء </h1>
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-hover">
							<tr>
								<td>صورة العرض</td>
								<td>رقم التعريف</td>
								<td>أسم المستخدم</td>
								<td>الإيميل</td>
								<td>الأسم</td>
								<td>تصنيف المستخدم</td>
								<td>الجنسية</td>
								<td>العمر</td>
								<td>الجنس</td>
								<td>تاريخ التسجيل</td>
								<td>التحكم</td>
							<?php 

								foreach ($users as $Info) {

									echo '<tr>';
										echo '<td><img class="img-circle img-thumbnail" alt="صورة المستخدم" src="../Uploads/Images/'. $Info['User_Image'] .'" width="30px" height="30px"></td>';
										echo '<td>'. $Info['User_ID'] .'</td>';
										echo '<td> <a href="../UserProfile.php?User=User&UserWriteID='. $Info['User_ID'] .'">'. $Info['User_Name'] .'</a></td>';
										echo '<td>'. $Info['User_Email'] .'</td>';
										echo '<td>'. $Info['User_FullName'] .'</td>';
										if($Info['User_Group'] == 1) {echo '<td>مستخدم</td>';} elseif ($Info['User_Group'] == 2) {echo '<td>كاتب</td>';} else {echo '<td>مدير</td>';}
										echo '<td>'. $Info['User_From'] .'</td>';
										echo '<td>'. $Info['User_Age'] .'</td>';
										if($Info['User_Sex'] == 1) {echo '<td>ذكر</td>';} else {echo '<td>أنثى</td>';}
										echo '<td>'. $Info['Reg_Date'] .'</td>';
										echo '<td><a href="WebInfoEdit.php?Edit=users&UserID='. $Info['User_ID'] .'">تحرير</a> | <a href="WebInfoDelete.php?Delete=users&UserID='. $Info['User_ID'] .'" class="user-Delete"><i class="fa fa-trash-o fa-1x"></i></a></td>';
									echo '</tr>';

								}

							?>
							</tr>
						</table>
					</div>
				</div>
			</div>

<?php
		} else {

			echo "<div class='container Page-First alert alert-danger'>لا يوجد بيانات</div>";

		}

	} elseif ($Info == 'history') {

		$AlertGET = '';

		if(isset($_GET['alerts'])) {

			$AlertGET = "SELECT * FROM history WHERE Alerts = 1 ORDER BY His_ID DESC";

		} else {

			$AlertGET = "SELECT history.*, users.User_Name AS UserWrite FROM history JOIN users ON users.User_ID = history.His_Write $AlertGET ORDER BY His_ID DESC";

		}

		$WebInfoStmt = $con-> prepare("$AlertGET");
		$WebInfoStmt-> execute();
		$Count = $WebInfoStmt-> rowCount();
		if ($Count > 0) {

			$history = $WebInfoStmt-> fetchAll(); ?>

			<h1 class="Page-First text-center"> التاريخ </h1>
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-hover">
							<tr>
								<td>رقم التعريف</td>
								<td>صورة المقال</td>
								<td>أسم المقال</td>
								<td>الكاتب</td>
								<td>كتب بتاريخ</td>
								<td>الساعة</td>
								<td>التفاصيل</td>
								<td>تصنيف المقال</td>
								<td>فيديو للمقال</td>
								<td>التحكم</td>
							<?php 

								foreach ($history as $Info) {

									echo '<tr>';
										echo '<td>'. $Info['His_ID'] .'</td>';
										echo '<td><img class="img-circle" alt="صورة المستخدم" src="../Uploads/Images/'. $Info['His_Image'] .'" width="30px" height="30px"></td>';
										echo '<td>'. $Info['His_Name'] .'</td>';
										echo '<td><a href="../UserProfile.php?UserWriteID='. $Info['His_Write'] .'">'. $Info['UserWrite'] .'</a></td>';
										echo '<td>'. $Info['His_Date'] .'</td>';
										echo '<td>'. $Info['His_Time'] .'</td>';
										echo '<td><a href="../Articles.php?Art=History-Articles&ArtID='. $Info['His_ID'] .'">التفاصيل</a></td>';
										if($Info['His_Parent'] == 1) {echo '<td>تاريخ قديم</td>';} else {echo '<td>تاريخ حديث</td>';}
										if ($Info['His_Videos'] == 'لا يوجد فيديو') {
											echo '<td> لا يوجد فيديو</td>';
										} else {
											echo '<td>'. $Info['His_Videos'] .'</td>';
										}
										echo '<td><a href="WebInfoEdit.php?Edit=history&ArtID='. $Info['His_ID'] .'">تحرير</a> | <a href="WebInfoDelete.php?Delete=history&ArtID='. $Info['His_ID'] .'" class="Art-Delete"><i class="fa fa-trash-o fa-1x"></i></a></td>';
									echo '</tr>';

								}

							?>
							</tr>
						</table>
					</div>
				</div>
			</div>

<?php
		} else {

			echo "<div class='container Page-First alert alert-danger'>لا يوجد بيانات</div>";

		}

	} elseif ($Info == 'culture') {

		$AlertGET = '';

		if(isset($_GET['alerts'])) {

			$AlertGET = "SELECT * FROM culture WHERE Alerts = 1 ORDER BY Cul_ID DESC";

		} else {

			$AlertGET = "SELECT culture.*, users.User_Name AS UserWrite FROM culture JOIN users ON users.User_ID = culture.Cul_Write ORDER BY Cul_ID DESC";

		}

		$WebInfoStmt = $con-> prepare("$AlertGET");
		$WebInfoStmt-> execute();
		$Count = $WebInfoStmt-> rowCount();
		if ($Count > 0) {

			$culture = $WebInfoStmt-> fetchAll(); ?>

			<h1 class="Page-First text-center"> الثقافة </h1>
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-hover">
							<tr>
								<td>رقم التعريف</td>
								<td>صورة المقال</td>
								<td>أسم المقال</td>
								<td>الكاتب</td>
								<td>كتب بتاريخ</td>
								<td>الساعة</td>
								<td>التفاصيل</td>
								<td>تصنيف المقال</td>
								<td>فيديو للمقال</td>
								<td>التحكم</td>
									<?php 

										foreach ($culture as $Info) {

											echo '<tr>';
												echo '<td>'. $Info['Cul_ID'] .'</td>';
												echo '<td><img class="img-circle" alt="صورة المستخدم" src="../Uploads/Images/'. $Info['Cul_Image'] .'" width="30px" height="30px"></td>';
												echo '<td>'. $Info['Cul_Name'] .'</td>';
												echo '<td><a href="../UserProfile.php?UserWriteID='. $Info['Cul_Write'] .'">'. $Info['UserWrite'] .'</a></td>';
												echo '<td>'. $Info['Cul_Date'] .'</td>';
												echo '<td>'. $Info['Cul_Time'] .'</td>';
												echo '<td><a href="../Articles.php?Art=Culture-Articles&ArtID='. $Info['Cul_ID'] .'">التفاصيل</a></td>';
												if($Info['Cul_Parent'] == 1) {echo '<td>المسرح والسينما</td>';} 
												elseif ($Info['Cul_Parent'] == 2) {echo '<td>الموسيقى</td>';}  
												elseif ($Info['Cul_Parent'] == 3) {echo '<td>الأدب والفنون</td>';}  
												elseif ($Info['Cul_Parent'] == 4) {echo '<td>المتاحف والمهرجانات</td>';} 
												elseif ($Info['Cul_Parent'] == 5) {echo '<td>الأعلام</td>';}
												else {echo '<td>المطبخ</td>';}
												if ($Info['Cul_Videos'] == 'لا يوجد فيديو') {
													echo '<td> لا يوجد فيديو</td>';
												} else {
													echo '<td>'. $Info['Cul_Videos'] .'</td>';
												}
												echo '<td><a href="WebInfoEdit.php?Edit=culture&ArtID='. $Info['Cul_ID'] .'">تحرير</a> | <a href="WebInfoDelete.php?Delete=culture&ArtID='. $Info['Cul_ID'] .'" class="Art-Delete"><i class="fa fa-trash-o fa-1x"></i></a></td>';
											echo '</tr>';

										}

									?>
							</tr>
						</table>
					</div>
				</div>
			</div>

<?php
		} else {

			echo "<div class='container Page-First alert alert-danger'>لا يوجد بيانات</div>";

		}

	} elseif ($Info == 'community') {

		$AlertGET = '';

		if(isset($_GET['alerts'])) {

			$AlertGET = "SELECT * FROM community WHERE Alerts = 1 ORDER BY Com_ID DESC";

		} else {

			$AlertGET = "SELECT community.*, users.User_Name AS UserWrite FROM community JOIN users ON users.User_ID = community.Com_Write ORDER BY Com_ID DESC";

		}

		$WebInfoStmt = $con-> prepare("$AlertGET");
		$WebInfoStmt-> execute();
		$Count = $WebInfoStmt-> rowCount();
		if ($Count > 0) {

			$community = $WebInfoStmt-> fetchAll(); ?>

			<h1 class="Page-First text-center"> المجتمع </h1>
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-hover">
							<tr>
								<td>رقم التعريف</td>
								<td>صورة المقال</td>
								<td>أسم المقال</td>
								<td>الكاتب</td>
								<td>كتب بتاريخ</td>
								<td>الساعة</td>
								<td>التفاصيل</td>
								<td>تصنيف المقال</td>
								<td>فيديو للمقال</td>
								<td>التحكم</td>
					<?php 

						foreach ($community as $Info) {

							echo '<tr>';
								echo '<td>'. $Info['Com_ID'] .'</td>';
								echo '<td><img class="img-circle" alt="صورة المستخدم" src="../Uploads/Images/'. $Info['Com_Image'] .'" width="30px" height="30px"></td>';
								echo '<td>'. $Info['Com_Name'] .'</td>';
								echo '<td><a href="../UserProfile.php?UserWriteID='. $Info['Com_Write'] .'">'. $Info['UserWrite'] .'</a></td>';
								echo '<td>'. $Info['Com_Date'] .'</td>';
								echo '<td>'. $Info['Com_Time'] .'</td>';
								echo '<td><a href="../Articles.php?Art=Community-Articles&ArtID='. $Info['Com_ID'] .'">التفاصيل</a></td>';
								if($Info['Com_Parent'] == 1) {echo '<td>مؤثرين سعوديين</td>';} elseif($Info['Com_Parent'] == 2) {echo '<td>السكان</td>';} else {echo '<td>التعليم</td>';}
								if ($Info['Com_Videos'] == 'لا يوجد فيديو') {
									echo '<td> لا يوجد فيديو</td>';
								} else {
									echo '<td>'. $Info['Com_Videos'] .'</td>';
								}
								echo '<td><a href="WebInfoEdit.php?Edit=community&ArtID='. $Info['Com_ID'] .'">تحرير</a> | <a href="WebInfoDelete.php?Delete=community&ArtID='. $Info['Com_ID'] .'" class="Art-Delete"><i class="fa fa-trash-o fa-1x"></i></a></td>';
							echo '</tr>';

						}

					?>
							</tr>
						</table>
					</div>
				</div>
			</div>

<?php
		} else {

			echo "<div class='container Page-First alert alert-danger'>لا يوجد بيانات</div>";

		}

	} elseif ($Info == 'tourism') {

		$AlertGET = '';

		if(isset($_GET['alerts'])) {

			$AlertGET = "SELECT * FROM tourism WHERE Alerts = 1 ORDER BY Tou_ID DESC";

		} else {

			$AlertGET = "SELECT tourism.*, users.User_Name AS UserWrite FROM tourism JOIN users ON users.User_ID = tourism.Tou_Write ORDER BY Tou_ID DESC";

		}

		$WebInfoStmt = $con-> prepare("$AlertGET");
		$WebInfoStmt-> execute();
		$Count = $WebInfoStmt-> rowCount();
		if ($Count > 0) {

			$tourism = $WebInfoStmt-> fetchAll(); ?>

			<h1 class="Page-First text-center"> السياحة </h1>
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-hover">
							<tr>
								<td>رقم التعريف</td>
								<td>صورة المقال</td>
								<td>أسم المقال</td>
								<td>الكاتب</td>
								<td>كتب بتاريخ</td>
								<td>الساعة</td>
								<td>التفاصيل</td>
								<td>فيديو للمقال</td>
								<td>التحكم</td>
									<?php 

										foreach ($tourism as $Info) {

											echo '<tr>';
												echo '<td>'. $Info['Tou_ID'] .'</td>';
												echo '<td><img class="img-circle" alt="صورة المستخدم" src="../Uploads/Images/'. $Info['Tou_Image'] .'" width="30px" height="30px"></td>';
												echo '<td>'. $Info['Tou_Name'] .'</td>';
												echo '<td><a href="../UserProfile.php?UserWriteID='. $Info['Tou_Write'] .'">'. $Info['UserWrite'] .'</a></td>';
												echo '<td>'. $Info['Tou_Date'] .'</td>';
												echo '<td>'. $Info['Tou_Time'] .'</td>';
												echo '<td><a href="../Articles.php?Art=Tourism-Articles&ArtID='. $Info['Tou_ID'] .'">التفاصيل</a></td>';
												if ($Info['Tou_Videos'] == 'لا يوجد فيديو') {
													echo '<td> لا يوجد فيديو</td>';
												} else {
													echo '<td>'. $Info['Tou_Videos'] .'</td>';
												}
												echo '<td><a href="WebInfoEdit.php?Edit=tourism&ArtID='. $Info['Tou_ID'] .'">تحرير</a> | <a href="WebInfoDelete.php?Delete=tourism&ArtID='. $Info['Tou_ID'] .'" class="Art-Delete"><i class="fa fa-trash-o fa-1x"></i></a></td>';
											echo '</tr>';

										}

									?>
							</tr>
						</table>
					</div>
				</div>
			</div>

<?php
		} else {

			echo "<div class='container Page-First alert alert-danger'>لا يوجد بيانات</div>";

		}

	} elseif ($Info == 'sport') {

		$AlertGET = '';

		if(isset($_GET['alerts'])) {

			$AlertGET = "SELECT * FROM sport WHERE Alerts = 1 ORDER BY Spo_ID DESC";

		} else {

			$AlertGET = "SELECT sport.*, users.User_Name AS UserWrite FROM sport JOIN users ON users.User_ID = sport.Spo_Write ORDER BY Spo_ID DESC";

		}

		$WebInfoStmt = $con-> prepare("$AlertGET");
		$WebInfoStmt-> execute();
		$Count = $WebInfoStmt-> rowCount();
		if ($Count > 0) {

			$sport = $WebInfoStmt-> fetchAll(); ?>

			<h1 class="Page-First text-center"> الرياضة </h1>
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-hover">
							<tr>
								<td>رقم التعريف</td>
								<td>صورة المقال</td>
								<td>أسم المقال</td>
								<td>الكاتب</td>
								<td>كتب بتاريخ</td>
								<td>الساعة</td>
								<td>التفاصيل</td>
								<td>فيديو للمقال</td>
								<td>التحكم</td>
									<?php 

										foreach ($sport as $Info) {

											echo '<tr>';
												echo '<td>'. $Info['Spo_ID'] .'</td>';
												echo '<td><img class="img-circle" alt="صورة المستخدم" src="../Uploads/Images/'. $Info['Spo_Image'] .'" width="30px" height="30px"></td>';
												echo '<td>'. $Info['Spo_Name'] .'</td>';
												echo '<td><a href="../UserProfile.php?UserWriteID='. $Info['Spo_Write'] .'">'. $Info['UserWrite'] .'</a></td>';
												echo '<td>'. $Info['Spo_Date'] .'</td>';
												echo '<td>'. $Info['Spo_Time'] .'</td>';
												echo '<td><a href="../Articles.php?Art=Sport-Articles&ArtID='. $Info['Spo_ID'] .'">التفاصيل</a></td>';
												if ($Info['Spo_Videos'] == 'لا يوجد فيديو') {
													echo '<td> لا يوجد فيديو</td>';
												} else {
													echo '<td>'. $Info['Spo_Videos'] .'</td>';
												}
												echo '<td><a href="WebInfoEdit.php?Edit=sport&ArtID='. $Info['Spo_ID'] .'">تحرير</a> | <a href="WebInfoDelete.php?Delete=sport&ArtID='. $Info['Spo_ID'] .'" class="Art-Delete"><i class="fa fa-trash-o fa-1x"></i></a></td>';
											echo '</tr>';

										}

									?>
							</tr>
						</table>
					</div>
				</div>
			</div>

<?php
		} else {

			echo "<div class='container Page-First alert alert-danger'>لا يوجد بيانات</div>";

		}

	} elseif ($Info == 'websites') {

		$AlertGET = '';

		if(isset($_GET['alerts'])) {

			$AlertGET = "SELECT * FROM websites WHERE Alerts = 1 ORDER BY Web_ID DESC";

		} else {

			$AlertGET = "SELECT websites.*, users.User_Name AS UserWrite FROM websites JOIN users ON users.User_ID = websites.Web_Write ORDER BY Web_ID DESC";

		}

		$WebInfoStmt = $con-> prepare("$AlertGET");
		$WebInfoStmt-> execute();
		$Count = $WebInfoStmt-> rowCount();
		if ($Count > 0) {

			$websites = $WebInfoStmt-> fetchAll(); ?>

			<h1 class="Page-First text-center"> مواقع الكترونية </h1>
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-hover">
							<tr>
								<td>رقم التعريف</td>
								<td>صورة المقال</td>
								<td>أسم المقال</td>
								<td>الكاتب</td>
								<td>كتب بتاريخ</td>
								<td>الساعة</td>
								<td>التفاصيل</td>
								<td>فيديو للمقال</td>
								<td>رابط الموقع</td>
								<td>التحكم</td>
									<?php 

										foreach ($websites as $Info) {

											echo '<tr>';
												echo '<td>'. $Info['Web_ID'] .'</td>';
												echo '<td><img class="img-circle" alt="صورة المستخدم" src="../Uploads/Images/'. $Info['Web_Image'] .'" width="30px" height="30px"></td>';
												echo '<td>'. $Info['Web_Name'] .'</td>';
												echo '<td><a href="../UserProfile.php?UserWriteID='. $Info['Web_Write'] .'">'. $Info['UserWrite'] .'</a></td>';
												echo '<td>'. $Info['Web_Date'] .'</td>';
												echo '<td>'. $Info['Web_Time'] .'</td>';
												echo '<td><a href="../Articles.php?Art=Websites-Articles&ArtID='. $Info['Web_ID'] .'">التفاصيل</a></td>';
												if ($Info['Web_Videos'] == 'لا يوجد فيديو') {
													echo '<td> لا يوجد فيديو</td>';
												} else {
													echo '<td>'. $Info['Web_Videos'] .'</td>';
												}
												echo '<td><a href="'. $Info['Web_Link'] .'">الرابط</a></td>';
												echo '<td><a href="WebInfoEdit.php?Edit=websites&ArtID='. $Info['Web_ID'] .'">تحرير</a> | <a href="WebInfoDelete.php?Delete=websites&ArtID='. $Info['Web_ID'] .'" class="Art-Delete"><i class="fa fa-trash-o fa-1x"></i></a></td>';
											echo '</tr>';

										}

									?>
							</tr>
						</table>
					</div>
				</div>
			</div>

<?php
		} else {

			echo "<div class='container Page-First alert alert-danger'>لا يوجد بيانات</div>";

		}

	} elseif ($Info == 'security-and-defense') {

		$AlertGET = '';

		if(isset($_GET['alerts'])) {

			$AlertGET = "SELECT * FROM security_and_defense WHERE Alerts = 1 ORDER BY SAD_ID DESC";

		} else {

			$AlertGET = "SELECT security_and_defense.*, users.User_Name AS UserWrite FROM security_and_defense JOIN users ON users.User_ID = security_and_defense.SAD_Write ORDER BY SAD_ID DESC";

		}

		$WebInfoStmt = $con-> prepare("$AlertGET");
		$WebInfoStmt-> execute();
		$Count = $WebInfoStmt-> rowCount();
		if ($Count > 0) {

			$security_and_defense = $WebInfoStmt-> fetchAll(); ?>

			<h1 class="Page-First text-center"> الأمن والدفاع </h1>
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-hover">
							<tr>
								<td>رقم التعريف</td>
								<td>صورة المقال</td>
								<td>أسم المقال</td>
								<td>الكاتب</td>
								<td>كتب بتاريخ</td>
								<td>الساعة</td>
								<td>التفاصيل</td>
								<td>تصنيف المقال</td>
								<td>فيديو للمقال</td>
								<td>التحكم</td>
									<?php 

										foreach ($security_and_defense as $Info) {

											echo '<tr>';
												echo '<td>'. $Info['SAD_ID'] .'</td>';
												echo '<td><img class="img-circle" alt="صورة المستخدم" src="../Uploads/Images/'. $Info['SAD_Image'] .'" width="30px" height="30px"></td>';
												echo '<td>'. $Info['SAD_Name'] .'</td>';
												echo '<td><a href="../UserProfile.php?UserWriteID='. $Info['SAD_Write'] .'">'. $Info['UserWrite'] .'</a></td>';
												echo '<td>'. $Info['SAD_Date'] .'</td>';
												echo '<td>'. $Info['SAD_Time'] .'</td>';
												echo '<td><a href="../Articles.php?Art=SecurityAndDefense-Articles&ArtID='. $Info['SAD_ID'] .'">التفاصيل</a></td>';
												if($Info['SAD_Parent'] == 1) {echo '<td>وزارة الدفاع</td>';} elseif($Info['SAD_Parent'] == 2) {echo '<td>وزارة الداخلية</td>';} else {echo '<td>وزارة الحرس الوطني</td>';}
												if ($Info['SAD_Videos'] == 'لا يوجد فيديو') {
													echo '<td> لا يوجد فيديو</td>';
												} else {
													echo '<td>'. $Info['SAD_Videos'] .'</td>';
												}
												echo '<td><a href="WebInfoEdit.php?Edit=security-and-defense&ArtID='. $Info['SAD_ID'] .'">تحرير</a> | <a href="WebInfoDelete.php?Delete=security-and-defense&ArtID='. $Info['SAD_ID'] .'" class="Art-Delete"><i class="fa fa-trash-o fa-1x"></i></a></td>';
											echo '</tr>';

										}

									?>
							</tr>
						</table>
					</div>
				</div>
			</div>

<?php
		} else {

			echo "<div class='container Page-First alert alert-danger'>لا يوجد بيانات</div>";

		}

	} elseif ($Info == 'economy') {

		$AlertGET = '';

		if(isset($_GET['alerts'])) {

			$AlertGET = "SELECT * FROM economy WHERE Alerts = 1 ORDER BY Eco_ID DESC";

		} else {

			$AlertGET = "SELECT economy.*, users.User_Name AS UserWrite FROM economy JOIN users ON users.User_ID = economy.Eco_Write ORDER BY Eco_ID DESC";

		}

		$WebInfoStmt = $con-> prepare("$AlertGET");
		$WebInfoStmt-> execute();
		$Count = $WebInfoStmt-> rowCount();
		if ($Count > 0) {

			$economy = $WebInfoStmt-> fetchAll(); ?>

			<h1 class="Page-First text-center"> الأقتصاد </h1>
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-hover">
							<tr>
								<td>رقم التعريف</td>
								<td>صورة المقال</td>
								<td>أسم المقال</td>
								<td>الكاتب</td>
								<td>كتب بتاريخ</td>
								<td>الساعة</td>
								<td>التفاصيل</td>
								<td>تصنيف المقال</td>
								<td>فيديو للمقال</td>
								<td>التحكم</td>
									<?php 

										foreach ($economy as $Info) {

											echo '<tr>';
												echo '<td>'. $Info['Eco_ID'] .'</td>';
												echo '<td><img class="img-circle" alt="صورة المستخدم" src="../Uploads/Images/'. $Info['Eco_Image'] .'" width="30px" height="30px"></td>';
												echo '<td>'. $Info['Eco_Name'] .'</td>';
												echo '<td><a href="../UserProfile.php?UserWriteID='. $Info['Eco_Write'] .'">'. $Info['UserWrite'] .'</a></td>';
												echo '<td>'. $Info['Eco_Date'] .'</td>';
												echo '<td>'. $Info['Eco_Time'] .'</td>';
												echo '<td><a href="../Articles.php?Art=Economy-Articles&ArtID='. $Info['Eco_ID'] .'">التفاصيل</a></td>';
												if($Info['Eco_Parent'] == 1) {echo '<td>شركات خاصة</td>';} else {echo '<td>شركات حكومية</td>';}
												if ($Info['Eco_Videos'] == 'لا يوجد فيديو') {
													echo '<td> لا يوجد فيديو</td>';
												} else {
													echo '<td>'. $Info['Eco_Videos'] .'</td>';
												}
												echo '<td><a href="WebInfoEdit.php?Edit=economy&ArtID='. $Info['Eco_ID'] .'">تحرير</a> | <a href="WebInfoDelete.php?Delete=economy&ArtID='. $Info['Eco_ID'] .'" class="Art-Delete"><i class="fa fa-trash-o fa-1x"></i></a></td>';
											echo '</tr>';

										}

									?>
							</tr>
						</table>
					</div>
				</div>
			</div>

<?php
		} else {

			echo "<div class='container Page-First alert alert-danger'>لا يوجد بيانات</div>";

		}

	} elseif ($Info == 'politics') {

		$AlertGET = '';

		if(isset($_GET['alerts'])) {

			$AlertGET = "SELECT * FROM politics WHERE Alerts = 1 ORDER BY Pol_ID DESC";

		} else {

			$AlertGET = "SELECT politics.*, users.User_Name AS UserWrite FROM politics JOIN users ON users.User_ID = politics.Pol_Write ORDER BY Pol_ID DESC";

		}

		$WebInfoStmt = $con-> prepare("$AlertGET");
		$WebInfoStmt-> execute();
		$Count = $WebInfoStmt-> rowCount();
		if ($Count > 0) {

			$politics = $WebInfoStmt-> fetchAll(); ?>

			<h1 class="Page-First text-center"> السياسة </h1>
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-hover">
							<tr>
								<td>رقم التعريف</td>
								<td>صورة المقال</td>
								<td>أسم المقال</td>
								<td>الكاتب</td>
								<td>كتب بتاريخ</td>
								<td>الساعة</td>
								<td>التفاصيل</td>
								<td>فيديو للمقال</td>
								<td>التجكم</td>
									<?php 

										foreach ($politics as $Info) {

											echo '<tr>';
												echo '<td>'. $Info['Pol_ID'] .'</td>';
												echo '<td><img class="img-circle" alt="صورة المستخدم" src="../Uploads/Images/'. $Info['Pol_Image'] .'" width="30px" height="30px"></td>';
												echo '<td>'. $Info['Pol_Name'] .'</td>';
												echo '<td><a href="../UserProfile.php?UserWriteID='. $Info['Pol_Write'] .'">'. $Info['UserWrite'] .'</a></td>';
												echo '<td>'. $Info['Pol_Date'] .'</td>';
												echo '<td>'. $Info['Pol_Time'] .'</td>';
												echo '<td><a href="../Articles.php?Art=Politics-Articles&ArtID='. $Info['Pol_ID'] .'">التفاصيل</a></td>';
												if ($Info['Pol_Videos'] == 'لا يوجد فيديو') {
													echo '<td> لا يوجد فيديو</td>';
												} else {
													echo '<td>'. $Info['Pol_Videos'] .'</td>';
												}
												echo '<td><a href="WebInfoEdit.php?Edit=politics&ArtID='. $Info['Pol_ID'] .'">تحرير</a> | <a href="WebInfoDelete.php?Delete=politics&ArtID='. $Info['Pol_ID'] .'" class="Art-Delete"><i class="fa fa-trash-o fa-1x"></i></a></td>';
											echo '</tr>';

										}

									?>
							</tr>
						</table>
					</div>
				</div>
			</div>

<?php
		} else {

			echo "<div class='container Page-First alert alert-danger'>لا يوجد بيانات</div>";

		}

	} elseif ($Info == 'comments') {

		$AlertGET = '';

		if(isset($_GET['alerts'])) {

			$AlertGET = "SELECT * FROM comments WHERE Alerts = 1 ORDER BY Com_ID DESC";

		} else {

			$AlertGET = "SELECT comments.*, users.User_Name AS UserWrite FROM comments JOIN users ON users.User_ID = comments.Com_UserName ORDER BY Com_ID DESC";

		}

		$WebInfoStmt = $con-> prepare("$AlertGET");
		$WebInfoStmt-> execute();
		$Count = $WebInfoStmt-> rowCount();
		if ($Count > 0) {

			$comments = $WebInfoStmt-> fetchAll(); ?>

			<h1 class="Page-First text-center"> التعليقات </h1>
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-hover">
							<tr>
								<td>رقم التعريف</td>
								<td>التعليق</td>
								<td>كتب بتاريخ</td>
								<td>كاتب التعليق</td>
								<td>في قسم</td>
								<td>في المقال</td>
								<td>التحكم</td>
									<?php 

										foreach ($comments as $Info) {

											echo '<tr>';
												echo '<td>'. $Info['Com_ID'] .'</td>';
												echo '<td>'. $Info['Com_Comments'] .'</td>';
												echo '<td>'. $Info['Com_Date'] .'</td>';
												echo '<td><a href="../UserProfile.php?UserWriteID='. $Info['Com_UserName'] .'">'. $Info['UserWrite'] .'</a></td>';
												if($Info['Com_SectionName'] == 1) {echo '<td><a href="../History.php"> التاريخ </a></td>';}
												elseif ($Info['Com_SectionName'] == 2) {echo '<td><a href="../Culture.php"> الثقافة </a></td>';}
												elseif ($Info['Com_SectionName'] == 3) {echo '<td><a href="../Community.php"> المجتمع </a></td>';}
												elseif ($Info['Com_SectionName'] == 4) {echo '<td><a href="../Tourism.php"> السياحة </a></td>';}
												elseif ($Info['Com_SectionName'] == 5) {echo '<td><a href="../Sport.php"> الرياضة </a></td>';}
												elseif ($Info['Com_SectionName'] == 6) {echo '<td><a href="../Websites.php"> مواقع الكترونية </a></td>';}
												elseif ($Info['Com_SectionName'] == 7) {echo '<td><a href="../SecurityAndDefense.php"> الأمن والدفاع </a></td>';}
												elseif ($Info['Com_SectionName'] == 8) {echo '<td><a href="../Economy.php"> الأقتصاد </a></td>';}
												elseif ($Info['Com_SectionName'] == 9) {echo '<td><a href="../Politics.php"> السياسة </a></td>';}
												else {echo '<td><a href="../News.php"> الأخبار </a></td>';}
												if($Info['Com_SectionName'] == 1) {echo '<td><a href="../Articles.php?Art=History-Articles&ArtID='. $Info['Art_ID'] .'">'. $Info['Art_ID'] .'</a></td>';}
												elseif ($Info['Com_SectionName'] == 2) {echo '<td><a href="../Articles.php?Art=Culture-Articles&ArtID='. $Info['Art_ID'] .'">'. $Info['Art_ID'] .'</a></td>';}
												elseif ($Info['Com_SectionName'] == 3) {echo '<td><a href="../Articles.php?Art=Community-Articles&ArtID='. $Info['Art_ID'] .'">'. $Info['Art_ID'] .'</a></td>';}
												elseif ($Info['Com_SectionName'] == 4) {echo '<td><a href="../Articles.php?Art=Tourism-Articles&ArtID='. $Info['Art_ID'] .'">'. $Info['Art_ID'] .'</a></td>';}
												elseif ($Info['Com_SectionName'] == 5) {echo '<td><a href="../Articles.php?Art=Sport-Articles&ArtID='. $Info['Art_ID'] .'">'. $Info['Art_ID'] .'</a></td>';}
												elseif ($Info['Com_SectionName'] == 6) {echo '<td><a href="../Articles.php?Art=Websites-Articles&ArtID='. $Info['Art_ID'] .'">'. $Info['Art_ID'] .'</a></td>';}
												elseif ($Info['Com_SectionName'] == 7) {echo '<td><a href="../Articles.php?Art=SecurityAndDefense-Articles&ArtID='. $Info['Art_ID'] .'">'. $Info['Art_ID'] .'</a></td>';}
												elseif ($Info['Com_SectionName'] == 8) {echo '<td><a href="../Articles.php?Art=Economy-Articles&ArtID='. $Info['Art_ID'] .'">'. $Info['Art_ID'] .'</a></td>';}
												elseif ($Info['Com_SectionName'] == 9) {echo '<td><a href="../Articles.php?Art=Politics-Articles&ArtID='. $Info['Art_ID'] .'">'. $Info['Art_ID'] .'</a></td>';}
												else {echo '<td><a href="../Articles.php?Art=News-Articles&ArtID='. $Info['Art_ID'] .'">'. $Info['Art_ID'] .'</a></td>';}
												echo '<td><a href="WebInfoDelete.php?Delete=comments&CommeID='. $Info['Com_ID'] .'" class="Comment-Delete"><i class="fa fa-trash-o fa-1x"></i></a></td>';
											echo '</tr>';

										}

									?>
							</tr>
						</table>
					</div>
				</div>
			</div>

<?php
		} else {

			echo "<div class='container Page-First alert alert-danger'>لا يوجد بيانات</div>";

		}

	} elseif ($Info == 'news') {

		$AlertGET = '';

		if(isset($_GET['alerts'])) {

			$AlertGET = "SELECT * FROM news WHERE Alerts = 1 ORDER BY News_ID DESC";

		} else {

			$AlertGET = "SELECT news.*, users.User_Name AS UserWrite FROM news JOIN users ON users.User_ID = news.News_Write ORDER BY News_ID DESC";

		}

		$WebInfoStmt = $con-> prepare("$AlertGET");
		$WebInfoStmt-> execute();
		$Count = $WebInfoStmt-> rowCount();
		if ($Count > 0) {

			$news = $WebInfoStmt-> fetchAll(); ?>

			<h1 class="Page-First text-center"> الأخبار </h1>
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-hover">
							<tr>
								<td>رقم التعريف</td>
								<td>صورة الخبر</td>
								<td>أسم الخبر</td>
								<td>الكاتب</td>
								<td>كتب بتاريخ</td>
								<td>الساعة</td>
								<td>التفاصيل</td>
								<td>فيديو للمقال</td>
								<td>التحكم</td>
									<?php 

										foreach ($news as $Info) {

											echo '<tr>';
												echo '<td>'. $Info['News_ID'] .'</td>';
												echo '<td><img class="img-circle" alt="صورة المستخدم" src="../Uploads/Images/'. $Info['News_Image'] .'" width="30px" height="30px"></td>';
												echo '<td>'. $Info['News_Name'] .'</td>';
												echo '<td><a href="../UserProfile.php?UserWriteID='. $Info['News_Write'] .'">'. $Info['UserWrite'] .'</a></td>';
												echo '<td>'. $Info['News_Date'] .'</td>';
												echo '<td>'. $Info['News_Time'] .'</td>';
												echo '<td><a href="../NewsArt.php?Art=News&ArtID='. $Info['News_ID'] .'">التفاصيل</a></td>';
												if ($Info['News_Videos'] == 'لا يوجد فيديو') {
													echo '<td> لا يوجد فيديو</td>';
												} else {
													echo '<td>'. $Info['News_Videos'] .'</td>';
												}
												echo '<td><a href="WebInfoDelete.php?Delete=news&ArtID='. $Info['News_ID'] .'" class="Art-Delete"><i class="fa fa-trash-o fa-1x"></i></a></td>';
											echo '</tr>';

										}

									?>
							</tr>
						</table>
					</div>
				</div>
			</div>

<?php
		} else {

			echo "<div class='container Page-First alert alert-danger'>لا يوجد بيانات</div>";

		}

	} elseif ($Info == 'connect-us') {

		$AlertGET = '';

		if(isset($_GET['alerts'])) {

			$AlertGET = "SELECT * FROM connect_us WHERE Alerts = 1 ORDER BY Con_ID DESC";

		} else {

			$AlertGET = "SELECT * FROM connect_us ORDER BY Con_ID DESC";

		}

		$WebInfoStmt = $con-> prepare("$AlertGET");
		$WebInfoStmt-> execute();
		$Count = $WebInfoStmt-> rowCount();
		if ($Count > 0) {

			$conntact_us = $WebInfoStmt-> fetchAll(); ?>

			<h1 class="Page-First text-center"> تواصل معنا </h1>
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-hover">
							<tr>
								<td>رقم التعريف</td>
								<td>أسم المرسل</td>
								<td>إيميل المرسل</td>
								<td>نوع الرسالة</td>
								<td>الموضوع</td>
								<td>الرسالة</td>
								<td>أسم المستخم </td>
								<td>تاريخ الأرسال</td>
								<td>حالة الرسالة</td>
								<td>تحكم</td>
									<?php 

										foreach ($conntact_us as $Info) {

											echo '<tr>';
												echo '<td>'. $Info['Con_ID'] .'</td>';
												echo '<td>'. $Info['Con_Name'] .'</td>';
												echo '<td>'. $Info['Con_Email'] .'</td>';
												if ($Info['Con_Parent'] == 1) {echo '<td>شكوى</td>';}
												elseif ($Info['Con_Parent'] == 2) {echo '<td>أقتراح</td>';}
												elseif ($Info['Con_Parent'] == 3) {echo '<td>ملاحظة</td>';}
												elseif ($Info['Con_Parent'] == 4) {echo '<td>طلب</td>';}
												else {echo '<td>أخرى</td>';}
												echo '<td>'. $Info['Con_Subject'] .'</td>';
												echo '<td>'. $Info['Con_Message'] .'</td>';
												if ($Info['Con_UserName'] == 0) {echo '<td>غير مسجل</td>';} else {echo '<td><a href="../UserProfile.php?UserWriteID='. $Info['Con_UserName'] .'">'. $Info['Con_UserName'] .'</a></td>';}
												echo '<td>'. $Info['Con_Date'] .'</td>';
												if ($Info['Con_Answered'] == 0) {echo '<td>لم يتم الأجابة <a href="#"> - رد</a></td>';} else {echo '<td>تمت الأجابة<a href="#"> - مشاهدة</a></td>';}
												echo '<td><a href="WebInfoDelete.php?Delete=connect-us&Con-Message='. $Info['Con_ID'] .'" class="ConMessage-Delete"><i class="fa fa-trash-o"></i></a></td>';
											echo '</tr>';

										}

									?>
							</tr>
						</table>
					</div>
				</div>
			</div>

<?php
		} else {

			echo "<div class='container Page-First alert alert-danger'>لا يوجد بيانات</div>";

		}

	} else {
		header('Location: Admin.php');
		exit();

	}

	include $TempDir . 'footer.php';

} else {

	header('Location: AdminLogin.php');
	exit();

}


