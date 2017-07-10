<?php
ob_start();
session_start();

if (isset($_SESSION['Ad-Un-SESSION'])) {

	include 'init.php';

	$Edit = '';

	if (isset($_GET['Edit'])) {
		$Edit = $_GET['Edit'];
	} else {
		header('Location: Admin.php');
		exit();
	}

// User Edit Page Start
	if ($Edit == 'users') {

		$UserID = isset($_GET['UserID']) && is_numeric($_GET['UserID']) ? intval($_GET['UserID']) : 0;

		$WebInfoStmt = $con-> prepare("SELECT * FROM users WHERE User_ID = ? ORDER BY User_ID DESC");
		$WebInfoStmt-> execute(array($UserID));
		$Count = $WebInfoStmt-> rowCount();
		if ($Count > 0) {

			$users = $WebInfoStmt-> fetchAll(); ?>

			<h1 class="Page-First text-center">تحرير المستخدم</h1>
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
							<?php 

								foreach ($users as $Info) {

									echo '<tr>';
										echo '<td><img class="img-circle img-thumbnail" alt="صورة المستخدم" src="../Uploads/Images/'. $Info['User_Image'] .'" width="30px" height="30px"></td>';
										echo '<td>'. $Info['User_ID'] .'</td>';
										echo '<td> <a href="../UserProfile.php?UserWriteID='. $Info['User_ID'] .'">'. $Info['User_Name'] .'</a></td>';
										echo '<td>'. $Info['User_Email'] .'</td>';
										echo '<td>'. $Info['User_FullName'] .'</td>';
										if($Info['User_Group'] == 1) {echo '<td>مستخدم</td>';} elseif ($Info['User_Group'] == 2) {echo '<td>كاتب</td>';} else {echo '<td>مدير</td>';}
										echo '<td>'. $Info['User_From'] .'</td>';
										echo '<td>'. $Info['User_Age'] .'</td>';
										if($Info['User_Sex'] == 1) {echo '<td>ذكر</td>';} else {echo '<td>أنثى</td>';}
										echo '<td>'. $Info['Reg_Date'] .'</td>';
									echo '</tr>';

								}
							}

							?>
							</tr>
						</table>
					</div>
					<div class="col-lg-3">
						<div class="SingUp-Page">
							<div class="alert alert-warning">
								الرجاء تحرير الحقل الذي ترغب بتغييره وأترك الحقول الأخرى
								<i class="fa fa-exclamation-circle fa-2x"></i>
							</div>
							<?php 

								if ($_SERVER['REQUEST_METHOD'] == 'POST') {

									$UserID_hi = $_POST['User_ID']; // From input hidden
									$UserInfoStmt = $con-> prepare("SELECT * FROM users WHERE User_ID = ? ORDER BY User_ID DESC");
									$UserInfoStmt-> execute(array($UserID_hi));
									$Count = $UserInfoStmt-> rowCount();
									if ($Count > 0) {

										$UserInfo = $UserInfoStmt-> fetch();

										$Image_Name = $_FILES['User_Image']['name'];
										$Image_Type = $_FILES['User_Image']['type'];
										$Image_Tmp_Name = $_FILES['User_Image']['tmp_name'];
										$Image_Size = $_FILES['User_Image']['size'];
										// Image Extension Allowed List
										$ImageAllowedExtension = array('jpg', 'jpeg', 'png', 'bmp', 'tiff', 'gif');
										// Conversion From UpperCase To LowerCase
										$ImageToLo = strtolower($Image_Name);
										// Conversion Image Name To Array With explode
										$ImageExplode = explode('.', $ImageToLo);
										// Get The End From The Image Name Array
										$ImageExplodeEnd = end($ImageExplode);

										$User_Email = filter_var($_POST['Email'], FILTER_SANITIZE_EMAIL);
										$User_FullName = filter_var($_POST['FullName'], FILTER_SANITIZE_STRING);
										$User_Group = $_POST['User_Group'];
										$User_From = filter_var($_POST['UserFrom'], FILTER_SANITIZE_STRING);
										$User_Age = filter_var($_POST['UserAge'], FILTER_SANITIZE_NUMBER_INT);
										$User_Sex = $_POST['UserSex'];

										$UserInfoEditErrors = array();

										if (!empty($Image_Name) && !in_array($ImageExplodeEnd, $ImageAllowedExtension)) {
											$UserInfoEditErrors[] = 'أمتداد الصورة غير مسموح به أبحث عن صورة يكون أمتدادها " jpg - jpeg - png - bmp - tiff - gif "';
										}
										if ($Image_Size > 4194304) {
											$UserInfoEditErrors[] = 'حجم الصورة كبير جدا أضف صورة حجمها يكون أقل من 4MB';
										}
										if (empty($User_Email)) {
											$UserInfoEditErrors[] = 'الأيميل يجب أن لا يكون فارغاً';
										}
										if (empty($User_FullName)) {
											$UserInfoEditErrors[] = 'الأسم كامل يجب أن لا يكون فارغاً';
										}
										if ($User_Group == 0) {
											$UserInfoEditErrors[] = 'تصنيف المستخدم يجب أن لا يكون فارغاً';
										}
										if (empty($User_From)) {
											$UserInfoEditErrors[] = 'الجنسية يجب أن لا يكون فارغاً';
										}
										if (empty($User_Age)) {
											$UserInfoEditErrors[] = 'العمر يجب أن لا يكون فارغاً';
										}
										if ($User_Sex == 0) {
											$UserInfoEditErrors[] = 'الجنس يجب أن لا يكون فارغاً';
										}

										foreach ($UserInfoEditErrors as $UserErrors) {
											echo "<div class='alert alert-danger'>" . $UserErrors . "</div>";
										}

										if (empty($UserInfoEditErrors)) {

											$newImage = rand(0, 100000) . '_' . $Image_Name;
											move_uploaded_file($Image_Tmp_Name, '../Uploads/Images/' . $newImage);

											if(empty($Image_Name)) {

												$newImage = $UserInfo['User_Image'];
											
											}

											$UserEditStmt = $con-> prepare("UPDATE users SET User_Email = ?, User_FullName = ?, User_Group = ?, User_From = ?, User_Age = ?, User_Sex = ?, User_Image = ? WHERE User_ID = ?");
											$UserEditStmt-> execute(array($User_Email, $User_FullName, $User_Group, $User_From, $User_Age, $User_Sex, $newImage, $UserID_hi));

											echo "<meta http-equiv='refresh' content='0'>"; //Refresh by HTTP META

										} 

									
									} else {

										header('Location: Admin.php');
										exit();

									}

								}

							?>
							<form class="form-group" action="<?php $_SERVER['PHP_SELF']; ?>" method='POST' enctype="multipart/form-data">
								<input type="hidden" name="User_ID" value="<?php echo $UserID; ?>">
								<label> صورة العرض </label>
									<input class="form-control" type="file" name="User_Image">
								<label> الأيميل </label>
									<input class="form-control" type="email" name="Email" value="<?php echo $Info['User_Email'] ?>">
								<label> الأسم كامل </label>
									<input class="form-control" type="text" name="FullName" value="<?php echo $Info['User_FullName'] ?>">
								<label> تصنيف المستخدم </label>
									<select class="form-control" name="User_Group">
										<option value="0">---</option>
										<option value="1" <?php if ($Info['User_Group'] == 1) echo 'selected'; ?>>مستخدم</option>
										<option value="2" <?php if ($Info['User_Group'] == 2) echo 'selected'; ?>>كاتب</option>
										<option value="3" <?php if ($Info['User_Group'] == 3) echo 'selected'; ?>>مدير</option>
									</select>
								<label> الجنسية </label>
									<input class="form-control" type="text" name="UserFrom" value="<?php echo $Info['User_From'] ?>">
								<label> العمر </label>
									<input class="form-control" type="text" name="UserAge" value="<?php echo $Info['User_Age'] ?>">
								<label> الجنس </label>
									<select class="form-control" name="UserSex">
										<option value="0">---</option>
										<option value="1" <?php if ($Info['User_Sex'] == 1) {echo 'selected';} ?>> ذكر </option>
										<option value="2" <?php if ($Info['User_Sex'] == 2) {echo 'selected';} ?>> أنثى </option>
									</select>
								<input class="btn btn-primary" type="submit" name="تحديث" value="تحديث">
							</form>
						</div>
					</div>
				</div>
			</div>

<?php
// Users Edit Page End
	} elseif ($Edit == 'history') {

		$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
		$WebInfoStmt = $con-> prepare("SELECT history.*, users.User_Name AS UserWrite FROM history JOIN users ON users.User_ID = history.His_Write WHERE His_ID = ? ORDER BY His_ID DESC");
		$WebInfoStmt-> execute(array($ArtID));
		$Count = $WebInfoStmt-> rowCount();
		if ($Count > 0) {

			$history = $WebInfoStmt-> fetchAll(); ?>

			<h1 class="Page-First text-center">تحرير مقال في التاريخ</h1>
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
									echo '</tr>';

								}
							}

							?>
							</tr>
						</table>
					</div>
					<div class="col-lg-3">
						<?php 

							if ($_SERVER['REQUEST_METHOD'] == 'POST') {

								if ($_POST['Edit-His']) {

									$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
									$ArtEditStmt = $con-> prepare("SELECT * FROM history WHERE His_ID = ?");
									$ArtEditStmt-> execute(array($ArtID));
									$Count = $ArtEditStmt-> rowCount();

									if ($Count > 0) {

										$ArtHisInfo = $ArtEditStmt-> fetch();

										$ArtHisName = filter_var($_POST['Article-Name'], FILTER_SANITIZE_STRING);
										$ArtHisDetails = filter_var($_POST['Article-Details'], FILTER_SANITIZE_STRING);
										$ArtHisParent = $_POST['Article-Parent'];
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

										$AddArtHisError = array();
										if (empty($ArtHisName)) {
											$AddArtHisError[] = 'أسم المقال يجب أن لا يكون فارغاً';
										}
										if (empty($ArtHisDetails)) {
											$ArtHisDetails = $ArtHisInfo['His_Details'];
										}
										if ($ArtHisParent == 0) {
											$AddArtHisError[] = 'يجب أن تختار تصنيف المقال';
										}
										if (!empty($ArtImageName) && !in_array($ArtImNameExplodeEnd, $ImageAllwedExtension)) {
											$AddArtHisError[] = 'يجب ان يكون أمتداد الصورة فقط أحدى هذه الأمتدادات " jpg - jpeg - png - bmp - tiff - gif "';
										}
										if ($ArtImageSize > 4194304) {
												$UserInfoError[] = 'حجم الصورة كبير جدا أضف صورة حجمها يكون أقل من 4MB';
										}

										foreach ($AddArtHisError as $AddHisError) {
											echo "<div class='container alert alert-danger'>" . $AddHisError . "</div>";
										}

										if (empty($AddArtHisError)) {

											$Artimage = rand(0, 100000) . '_' . $ArtImageName;
										 	move_uploaded_file($ArtImageTmp, '../Uploads/Images/' . $Artimage);

										 	if (empty($ArtVideo)) {
										 		$ArtVideo = 'لا يوجد فيديو';
										 	}
										 	if (empty($ArtImageName)) {
											$Artimage = $ArtHisInfo['His_Image'];
											}

											$AddArtHisStmt = $con-> prepare("UPDATE history SET His_Name = ?, His_Image = ?, His_Write = ?, His_Details = ?, His_Parent = ?, His_Videos = ? WHERE His_ID = ?");
											$AddArtHisStmt-> execute(array($ArtHisName, $Artimage, $_SESSION['UserID'], $ArtHisDetails, $ArtHisParent, $ArtVideo, $ArtID));

											echo "<meta http-equiv='refresh' content='0'>"; //Refresh by HTTP META
											
										}

									}

								} else {

								header('Location: Admin.php');
								exit();

								}

							}

						?>
						<form class="input-textarea form-group" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
		   					<label>أسم المقال</label>
								<input class="form-control" type="text" name="Article-Name" required="required" value="<?php echo $Info['His_Name'] ?>">
		   					<label>صورة المقال</label>
		   						<h5>الصورة الأصلية</h5>
		   						<div>
		   							<img src="../Uploads/Images/<?php echo $Info['His_Image'] ?>" width="100px" height="100px">
		   						</div>
		   						<h5>عدل الصورة</h5>
								<input class="form-control" type="file" name="Article-Image">
		   					<label>تفاصيل المقال</label>
		   						<div class="textarea-Edit">
		   							<h5>المقال الأصلي</h5>
		   							<?php echo $Info['His_Details'] ?>
		   						</div>
		   						<h5>عدل المقال</h5>
								<textarea class="form-control" name="Article-Details"></textarea>
		   					<label>تصنيف المقال</label>
								<select class="form-control" name="Article-Parent" required="required">
									<option value="0">---</option>
									<option value="1" <?php if ($Info['His_Parent'] == 1) {echo 'selected';} ?>>تاريخ قديم</option>
									<option value="2" <?php if ($Info['His_Parent'] == 2) {echo 'selected';} ?>>تاريخ حديث</option>
								</select>
		   					<label>فيديوهات  للمقال</label>
								<input class="form-control" type="text" name="Article-Video" value="<?php echo $Info['His_Videos'] ?>">
								<input class="btn btn-primary btn-block" type="submit" name="Edit-His" value="تحديث">
						</form>
					</div>
				</div>
			</div>

<?php
// history Edit Page End
	} elseif ($Edit == 'culture') {

		$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
		$WebInfoStmt = $con-> prepare("SELECT culture.*, users.User_Name AS UserWrite FROM culture JOIN users ON users.User_ID = culture.Cul_Write WHERE Cul_ID = ? ORDER BY Cul_ID DESC");
		$WebInfoStmt-> execute(array($ArtID));
		$Count = $WebInfoStmt-> rowCount();
		if ($Count > 0) {

			$culture = $WebInfoStmt-> fetchAll(); ?>

			<h1 class="Page-First text-center">wfwf </h1>
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
											echo '</tr>';

										}
									}

									?>
							</tr>
						</table>
					</div>
					<div class="col-lg-3">
					<?php

						if ($_SERVER['REQUEST_METHOD'] == 'POST') {

							if ($_POST['Edit-Cul']) {

								$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
								$ArtEditStmt = $con-> prepare("SELECT * FROM culture WHERE Cul_ID = ?");
								$ArtEditStmt-> execute(array($ArtID));
								$Count = $ArtEditStmt-> rowCount();

								if ($Count > 0) {

									$ArtCulInfo = $ArtEditStmt-> fetch();

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
										$ArtCulDetails = $ArtCulInfo['Cul_Details'];
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
									 	move_uploaded_file($ArtImageTmp, '../Uploads/Images/' . $Artimage);

									 	if (empty($ArtVideo)) {
									 		$ArtVideo = 'لا يوجد فيديو';
									 	}
									 	if (empty($ArtImageName)) {
										$Artimage = $ArtCulInfo['Cul_Image'];
										}

										$AddArtCulStmt = $con-> prepare("UPDATE culture SET Cul_Name = ?, Cul_Image = ?, Cul_Write = ?, Cul_Details = ?, Cul_Parent = ?, Cul_Videos = ? WHERE Cul_ID = ?");
										$AddArtCulStmt-> execute(array($ArtCulName, $Artimage, $_SESSION['UserID'], $ArtCulDetails, $ArtCulParent, $ArtVideo, $ArtID));

										echo '<meta http-equiv="refresh" content="0">';
										
									}
								}

							}

						}

					?>
						<form class="input-textarea form-group" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
		   					<label>أسم المقال</label>
								<input class="form-control" type="text" name="Article-Name" required="required" value="<?php echo $Info['Cul_Name'] ?>">
		   					<label>صورة المقال</label>
		   						<h5>الصورة الأصلية</h5>
		   						<div>
		   							<img src="../Uploads/Images/<?php echo $Info['Cul_Image'] ?>" width="100px" height="100px">
		   						</div>
		   						<h5>عدل الصورة</h5>
								<input class="form-control" type="file" name="Article-Image">
		   					<label>تفاصيل المقال</label>
		   						<div class="textarea-Edit">
		   							<h5>المقال الأصلي</h5>
		   							<?php echo $Info['Cul_Details'] ?>
		   						</div>
		   						<h5>عدل المقال</h5>
								<textarea class="form-control" name="Article-Details"></textarea>
							<label>تصنيف المقال</label>
								<select class="form-control" name="Article-Parent" required="required">
									<option value="0">---</option>
									<option value="1" <?php if ($Info['Cul_Parent'] == 1) {echo 'selected';} ?>>المسرح والسينما</option>
									<option value="2" <?php if ($Info['Cul_Parent'] == 2) {echo 'selected';} ?>>الموسيقى</option>
									<option value="3" <?php if ($Info['Cul_Parent'] == 3) {echo 'selected';} ?>>الأدب والفنون</option>
									<option value="4" <?php if ($Info['Cul_Parent'] == 4) {echo 'selected';} ?>>المتاحف والمهرجانات</option>
									<option value="5" <?php if ($Info['Cul_Parent'] == 5) {echo 'selected';} ?>>الإعلام</option>
									<option value="6" <?php if ($Info['Cul_Parent'] == 6) {echo 'selected';} ?>>المطبخ</option>
								</select>
		   					<label>فيديوهات  للمقال</label>
								<input class="form-control" type="text" name="Article-Video" value="<?php echo $Info['Cul_Videos'] ?>">
								<input class="btn btn-primary btn-block" type="submit" name="Edit-Cul" value="أضافة المقال">
						</form>
					</div>
				</div>
			</div>
<?php
// culture Edit Page End
	} elseif ($Edit == 'community') {

		$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
		$WebInfoStmt = $con-> prepare("SELECT community.*, users.User_Name AS UserWrite FROM community JOIN users ON users.User_ID = community.Com_Write WHERE Com_ID = ? ORDER BY Com_ID DESC");
		$WebInfoStmt-> execute(array($ArtID));
		$Count = $WebInfoStmt-> rowCount();
		if ($Count > 0) {

			$community = $WebInfoStmt-> fetchAll(); ?>

			<h1 class="Page-First text-center">wfwf </h1>
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
							echo '</tr>';

						}
					}

					?>
							</tr>
						</table>
					</div>
					<div class="col-lg-3">
					<?php 

						if ($_SERVER['REQUEST_METHOD'] == 'POST') {

							if ($_POST['Edit-Com']) {

								$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;

								$ArtEditStmt = $con-> prepare("SELECT * FROM community WHERE Com_ID = ?");
								$ArtEditStmt-> execute(array($ArtID));
								$Count = $ArtEditStmt-> rowCount();

								if ($Count > 0) {

									$ArtComInfo = $ArtEditStmt-> fetch();

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
										$ArtComDetails = $ArtComInfo['Com_Details'];
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
									 	move_uploaded_file($ArtImageTmp, '../Uploads/Images/' . $Artimage);

									 	if (empty($ArtVideo)) {
									 		$ArtVideo = 'لا يوجد فيديو';
									 	}
									 	if (empty($ArtImageName)) {
										$Artimage = $ArtComInfo['Com_Image'];
										}

										$AddArtComStmt = $con-> prepare("UPDATE community SET Com_Name = ?, Com_Image = ?, Com_Write = ?, Com_Details = ?, Com_Parent = ?, Com_Videos = ? WHERE Com_ID = ?");
										$AddArtComStmt-> execute(array($ArtComName, $Artimage, $_SESSION['UserID'], $ArtComDetails, $ArtComParent, $ArtVideo, $ArtID));

										echo '<meta http-equiv="refresh" content="0">';
										
									}

								}

							}

						}

					?>
						<form class="input-textarea form-group" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
		   					<label>أسم المقال</label>
								<input class="form-control" type="text" name="Article-Name" required="required" value="<?php echo $Info['Com_Name'] ?>">
		   					<label>صورة المقال</label>
		   						<h5>الصورة الأصلية</h5>
		   						<div>
		   							<img src="../Uploads/Images/<?php echo $Info['Com_Image'] ?>" width="100px" height="100px">
		   						</div>
		   						<h5>عدل الصورة</h5>
								<input class="form-control" type="file" name="Article-Image">
		   					<label>تفاصيل المقال</label>
		   						<div class="textarea-Edit">
		   							<h5>المقال الأصلي</h5>
		   							<?php echo $Info['Com_Details'] ?>
		   						</div>
		   						<h5>عدل المقال</h5>
								<textarea class="form-control" name="Article-Details"></textarea>
							<label>تصنيف المقال</label>
								<select class="form-control" name="Article-Parent" required="required">
									<option value="0">---</option>
									<option value="1" <?php if ($Info['Com_Parent'] == 1) {echo 'selected';} ?>>مؤثرين سعوديين</option>
									<option value="2" <?php if ($Info['Com_Parent'] == 2) {echo 'selected';} ?>>السكان</option>
									<option value="3" <?php if ($Info['Com_Parent'] == 3) {echo 'selected';} ?>>التعليم</option>
								</select>
		   					<label>فيديوهات  للمقال</label>
								<input class="form-control" type="text" name="Article-Video" value="<?php echo $Info['Com_Videos'] ?>">
								<input class="btn btn-primary btn-block" type="submit" name="Edit-Com" value="تحديث">
						</form>
					</div>
				</div>
			</div>

<?php
// community Edit Page End
	} elseif ($Edit == 'tourism') {

		$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
		$WebInfoStmt = $con-> prepare("SELECT tourism.*, users.User_Name AS UserWrite FROM tourism JOIN users ON users.User_ID = tourism.Tou_Write WHERE Tou_ID = ? ORDER BY Tou_ID DESC");
		$WebInfoStmt-> execute(array($ArtID));
		$Count = $WebInfoStmt-> rowCount();
		if ($Count > 0) {

			$tourism = $WebInfoStmt-> fetchAll(); ?>

			<h1 class="Page-First text-center">wfwf </h1>
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
											echo '</tr>';

										}
									}

									?>
							</tr>
						</table>
					</div>
					<div class="col-lg-3">
						<?php 

							if($_SERVER['REQUEST_METHOD'] == 'POST') {

								if($_POST['Tou-Edit']) {

									$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
									$ArtEditStmt = $con-> prepare("SELECT * FROM tourism WHERE Tou_ID = ?");
									$ArtEditStmt-> execute(array($ArtID));
									$Count = $ArtEditStmt-> rowCount();

									if ($Count > 0) {

										$ArtTouInfo = $ArtEditStmt-> fetch();

										$ArtTouName = filter_var($_POST['Article-Name'], FILTER_SANITIZE_STRING);
										$ArtTouDetails = filter_var($_POST['Article-Details'], FILTER_SANITIZE_STRING);
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

										$AddArtTouError = array();
										if (empty($ArtTouName)) {
											$AddArtTouError[] = 'أسم المقال يجب أن لا يكون فارغاً';
										}
										if (empty($ArtTouDetails)) {
											$ArtTouDetails = $ArtTouInfo['Tou_Details'];
										}
										if (!empty($ArtImageName) && !in_array($ArtImNameExplodeEnd, $ImageAllwedExtension)) {
											$AddArtTouError[] = 'يجب ان يكون أمتداد الصورة فقط أحدى هذه الأمتدادات " jpg - jpeg - png - bmp - tiff - gif "';
										}
										if ($ArtImageSize > 4194304) {
												$UserInfoError[] = 'حجم الصورة كبير جدا أضف صورة حجمها يكون أقل من 4MB';
										}

										foreach ($AddArtTouError as $AddTouError) {
											echo "<div class='container alert alert-danger'>" . $AddTouError . "</div>";
										}

										if (empty($AddArtTouError)) {

											$Artimage = rand(0, 100000) . '_' . $ArtImageName;
										 	move_uploaded_file($ArtImageTmp, '../Uploads/Images/' . $Artimage);

										 	if (empty($ArtVideo)) {
										 		$ArtVideo = 'لا يوجد فيديو';
										 	}
										 	if (empty($ArtImageName)) {
											$Artimage = $ArtTouInfo['Tou_Image'];
											}

											$AddArtTouStmt = $con-> prepare("UPDATE tourism SET Tou_Name = ?, Tou_Image = ?, Tou_Write = ?, Tou_Details = ?, Tou_Videos = ? WHERE Tou_ID = ?");
											$AddArtTouStmt-> execute(array($ArtTouName, $Artimage, $_SESSION['UserID'], $ArtTouDetails, $ArtVideo, $ArtID));

											echo '<meta http-equiv="refresh" content="0">';
											
										}

									}

								}

							}

						?>
						<form class="input-textarea form-group" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
		   					<label>أسم المقال</label>
								<input class="form-control" type="text" name="Article-Name" required="required" value="<?php echo $Info['Tou_Name'] ?>">
		   					<label>صورة المقال</label>
		   						<h5>الصورة الأصلية</h5>
		   						<div>
		   							<img src="../Uploads/Images/<?php echo $Info['Tou_Image'] ?>" width="100px" height="100px">
		   						</div>
		   						<h5>عدل الصورة</h5>
								<input class="form-control" type="file" name="Article-Image">
		   					<label>تفاصيل المقال</label>
		   						<div class="textarea-Edit">
		   							<h5>المقال الأصلي</h5>
		   							<?php echo $Info['Tou_Details'] ?>
		   						</div>
		   						<h5>عدل المقال</h5>
								<textarea class="form-control" name="Article-Details"></textarea>
		   					<label>فيديوهات  للمقال</label>
								<input class="form-control" type="text" name="Article-Video" value="<?php echo $Info['Tou_Videos'] ?>">
								<input class="btn btn-primary btn-block" type="submit" name="Tou-Edit" value="تحديث">
						</form>
					</div>
				</div>
			</div>

<?php
// tourism Edit Page End
	} elseif ($Edit == 'sport') {

		$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
		$WebInfoStmt = $con-> prepare("SELECT sport.*, users.User_Name AS UserWrite FROM sport JOIN users ON users.User_ID = sport.Spo_Write WHERE Spo_ID = ? ORDER BY Spo_ID DESC");
		$WebInfoStmt-> execute(array($ArtID));
		$Count = $WebInfoStmt-> rowCount();
		if ($Count > 0) {

			$sport = $WebInfoStmt-> fetchAll(); ?>

			<h1 class="Page-First text-center">wfwf </h1>
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
											echo '</tr>';

										}
									}

									?>
							</tr>
						</table>
					</div>
					<div class="col-lg-3">
						<?php 

							if($_SERVER['REQUEST_METHOD'] == 'POST') {

								if($_POST['Spo-Edit']) {

									$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
									$ArtEditStmt = $con-> prepare("SELECT * FROM sport WHERE Spo_ID = ?");
									$ArtEditStmt-> execute(array($ArtID));
									$Count = $ArtEditStmt-> rowCount();

									if ($Count > 0) {

										$ArtSpoInfo = $ArtEditStmt-> fetch();

										$ArtSpoName = filter_var($_POST['Article-Name'], FILTER_SANITIZE_STRING);
										$ArtSpoDetails = filter_var($_POST['Article-Details'], FILTER_SANITIZE_STRING);
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

										$AddArtSpoError = array();
										if (empty($ArtSpoName)) {
											$AddArtSpoError[] = 'أسم المقال يجب أن لا يكون فارغاً';
										}
										if (empty($ArtSpoDetails)) {
											$ArtSpoDetails = $ArtSpoInfo['Spo_Details'];
										}
										if (!empty($ArtImageName) && !in_array($ArtImNameExplodeEnd, $ImageAllwedExtension)) {
											$AddArtSpoError[] = 'يجب ان يكون أمتداد الصورة فقط أحدى هذه الأمتدادات " jpg - jpeg - png - bmp - tiff - gif "';
										}
										if ($ArtImageSize > 4194304) {
												$UserInfoError[] = 'حجم الصورة كبير جدا أضف صورة حجمها يكون أقل من 4MB';
										}

										foreach ($AddArtSpoError as $AddSpoError) {
											echo "<div class='container alert alert-danger'>" . $AddSpoError . "</div>";
										}

										if (empty($AddArtSpoError)) {

											$Artimage = rand(0, 100000) . '_' . $ArtImageName;
										 	move_uploaded_file($ArtImageTmp, '../Uploads/Images/' . $Artimage);

										 	if (empty($ArtVideo)) {
										 		$ArtVideo = 'لا يوجد فيديو';
										 	}
										 	if (empty($ArtImageName)) {
											$Artimage = $ArtSpoInfo['Spo_Image'];
											}

											$AddArtSpoStmt = $con-> prepare("UPDATE sport SET Spo_Name = ?, Spo_Image = ?, Spo_Write = ?, Spo_Details = ?, Spo_Videos = ? WHERE Spo_ID = ?");
											$AddArtSpoStmt-> execute(array($ArtSpoName, $Artimage, $_SESSION['UserID'], $ArtSpoDetails, $ArtVideo, $ArtID));

											echo '<meta http-equiv="refresh" content="0">';
											
										}

									}

								}

							}

						?>
						<form class="input-textarea form-group" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
		   					<label>أسم المقال</label>
								<input class="form-control" type="text" name="Article-Name" required="required" value="<?php echo $Info['Spo_Name'] ?>">
		   					<label>صورة المقال</label>
		   						<h5>الصورة الأصلية</h5>
		   						<div>
		   							<img src="../Uploads/Images/<?php echo $Info['Spo_Image'] ?>" width="100px" height="100px">
		   						</div>
		   						<h5>عدل الصورة</h5>
								<input class="form-control" type="file" name="Article-Image">
		   					<label>تفاصيل المقال</label>
		   						<div class="textarea-Edit">
		   							<h5>المقال الأصلي</h5>
		   							<?php echo $Info['Spo_Details'] ?>
		   						</div>
		   						<h5>عدل المقال</h5>
								<textarea class="form-control" name="Article-Details"></textarea>
		   					<label>فيديوهات  للمقال</label>
								<input class="form-control" type="text" name="Article-Video" value="<?php echo $Info['Spo_Videos'] ?>">
								<input class="btn btn-primary btn-block" type="submit" name="Spo-Edit" value="تحديث">
						</form>
					</div>
				</div>
			</div>

<?php
// sport Edit Page End
	} elseif ($Edit == 'websites') {

		$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
		$WebInfoStmt = $con-> prepare("SELECT websites.*, users.User_Name AS UserWrite FROM websites JOIN users ON users.User_ID = websites.Web_Write WHERE Web_ID = ? ORDER BY Web_ID DESC");
		$WebInfoStmt-> execute(array($ArtID));
		$Count = $WebInfoStmt-> rowCount();
		if ($Count > 0) {

			$websites = $WebInfoStmt-> fetchAll(); ?>

			<h1 class="Page-First text-center">wfwf </h1>
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
											echo '</tr>';

										}
									}

									?>
							</tr>
						</table>
					</div>
					<div class="col-lg-3">
						<?php 

							if($_SERVER['REQUEST_METHOD'] == 'POST') {

								if($_POST['Web-Edit']) {

									$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
									$ArtEditStmt = $con-> prepare("SELECT * FROM websites WHERE Web_ID = ?");
									$ArtEditStmt-> execute(array($ArtID));
									$Count = $ArtEditStmt-> rowCount();

									if ($Count > 0) {

										$ArtWebInfo = $ArtEditStmt-> fetch();

										$ArtWebName = filter_var($_POST['Article-Name'], FILTER_SANITIZE_STRING);
										$ArtWebDetails = filter_var($_POST['Article-Details'], FILTER_SANITIZE_STRING);
										$ArtLink = filter_var($_POST['Article-Link'], FILTER_SANITIZE_URL);
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

										$AddArtWebError = array();
										if (empty($ArtWebName)) {
											$AddArtWebError[] = 'أسم المقال يجب أن لا يكون فارغاً';
										}
										if (empty($ArtWebDetails)) {
											$ArtWebDetails = $ArtWebInfo['Web_Details'];
										}
										if (!empty($ArtImageName) && !in_array($ArtImNameExplodeEnd, $ImageAllwedExtension)) {
											$AddArtWebError[] = 'يجب ان يكون أمتداد الصورة فقط أحدى هذه الأمتدادات " jpg - jpeg - png - bmp - tiff - gif "';
										}
										if ($ArtImageSize > 4194304) {
												$UserInfoError[] = 'حجم الصورة كبير جدا أضف صورة حجمها يكون أقل من 4MB';
										}

										foreach ($AddArtWebError as $AddWebError) {
											echo "<div class='container alert alert-danger'>" . $AddWebError . "</div>";
										}

										if (empty($AddArtWebError)) {

											$Artimage = rand(0, 100000) . '_' . $ArtImageName;
										 	move_uploaded_file($ArtImageTmp, '../Uploads/Images/' . $Artimage);

										 	if (empty($ArtVideo)) {
										 		$ArtVideo = 'لا يوجد فيديو';
										 	}
										 	if (empty($ArtImageName)) {
											$Artimage = $ArtWebInfo['Web_Image'];
											}
											if (empty($ArtLink)) {
											$ArtLink = $ArtWebInfo['Web_Link'];
											}

											$AddArtWebStmt = $con-> prepare("UPDATE websites SET Web_Name = ?, Web_Image = ?, Web_Write = ?, Web_Details = ?, Web_Videos = ?, Web_Link = ? WHERE Web_ID = ?");
											$AddArtWebStmt-> execute(array($ArtWebName, $Artimage, $_SESSION['UserID'], $ArtWebDetails, $ArtVideo, $ArtLink, $ArtID));

											echo '<meta http-equiv="refresh" content="0">';
											
										}

									}

								}

							}

						?>
						<form class="input-textarea form-group" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
		   					<label>أسم المقال</label>
								<input class="form-control" type="text" name="Article-Name" required="required" value="<?php echo $Info['Web_Name'] ?>">
		   					<label>صورة المقال</label>
		   						<h5>الصورة الأصلية</h5>
		   						<div>
		   							<img src="../Uploads/Images/<?php echo $Info['Web_Image'] ?>" width="100px" height="100px">
		   						</div>
		   						<h5>عدل الصورة</h5>
								<input class="form-control" type="file" name="Article-Image">
		   					<label>تفاصيل المقال</label>
		   						<div class="textarea-Edit">
		   							<h5>المقال الأصلي</h5>
		   							<?php echo $Info['Web_Details'] ?>
		   						</div>
		   						<h5>عدل المقال</h5>
								<textarea class="form-control" name="Article-Details"></textarea>
		   					<label>فيديوهات  للمقال</label>
								<input class="form-control" type="text" name="Article-Video" value="<?php echo $Info['Web_Videos'] ?>">
							<label>رابط الموقع</label>
								<h5>الرابط القديم</h5>
								<span><?php echo $Info['Web_Link'] ?></span>
								<input class="form-control" type="text" name="Article-Link">
								<input class="btn btn-primary btn-block" type="submit" name="Web-Edit" value="تحديث">
						</form>
					</div>
				</div>
			</div>

<?php
// websites Edit Page End
	} elseif ($Edit == 'security-and-defense') {

		$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
		$WebInfoStmt = $con-> prepare("SELECT security_and_defense.*, users.User_Name AS UserWrite FROM security_and_defense JOIN users ON users.User_ID = security_and_defense.SAD_Write WHERE SAD_ID = ? ORDER BY SAD_ID DESC");
		$WebInfoStmt-> execute(array($ArtID));
		$Count = $WebInfoStmt-> rowCount();
		if ($Count > 0) {

			$security_and_defense = $WebInfoStmt-> fetchAll(); ?>

			<h1 class="Page-First text-center">wfwf </h1>
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
											echo '</tr>';

										}
									}

									?>
							</tr>
						</table>
					</div>
					<div class="col-lg-3">
						<?php 

							if($_SERVER['REQUEST_METHOD'] == 'POST') {

								if($_POST['SAD-Edit']) {

									$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
									$ArtEditStmt = $con-> prepare("SELECT * FROM security_and_defense WHERE SAD_ID = ?");
									$ArtEditStmt-> execute(array($ArtID));
									$Count = $ArtEditStmt-> rowCount();

									if ($Count > 0) {

										$ArtSADInfo = $ArtEditStmt-> fetch();

										$ArtSADName = filter_var($_POST['Article-Name'], FILTER_SANITIZE_STRING);
										$ArtSADDetails = filter_var($_POST['Article-Details'], FILTER_SANITIZE_STRING);
										$ArtSADParent = $_POST['Article-Parent'];
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

										$AddArtSADError = array();
										if (empty($ArtSADName)) {
											$AddArtSADError[] = 'أسم المقال يجب أن لا يكون فارغاً';
										}
										if (empty($ArtSADDetails)) {
											$ArtSADDetails = $ArtSADInfo['SAD_Details'];
										}
										if ($ArtSADParent == 0) {
											$AddArtSADError[] = 'يجب أن تختار تصنيف المقال';
										}
										if (!empty($ArtImageName) && !in_array($ArtImNameExplodeEnd, $ImageAllwedExtension)) {
											$AddArtSADError[] = 'يجب ان يكون أمتداد الصورة فقط أحدى هذه الأمتدادات " jpg - jpeg - png - bmp - tiff - gif "';
										}
										if ($ArtImageSize > 4194304) {
												$UserInfoError[] = 'حجم الصورة كبير جدا أضف صورة حجمها يكون أقل من 4MB';
										}

										foreach ($AddArtSADError as $AddSADError) {
											echo "<div class='container alert alert-danger'>" . $AddSADError . "</div>";
										}

										if (empty($AddArtSADError)) {

											$Artimage = rand(0, 100000) . '_' . $ArtImageName;
										 	move_uploaded_file($ArtImageTmp, '../Uploads/Images/' . $Artimage);

										 	if (empty($ArtVideo)) {
										 		$ArtVideo = 'لا يوجد فيديو';
										 	}
										 	if (empty($ArtImageName)) {
											$Artimage = $ArtSADInfo['SAD_Image'];
											}

											$AddArtSADStmt = $con-> prepare("UPDATE security_and_defense SET SAD_Name = ?, SAD_Image = ?, SAD_Write = ?, SAD_Details = ?, SAD_Parent = ?, SAD_Videos = ? WHERE SAD_ID = ?");
											$AddArtSADStmt-> execute(array($ArtSADName, $Artimage, $_SESSION['UserID'], $ArtSADDetails, $ArtSADParent, $ArtVideo, $ArtID));

											echo '<meta http-equiv="refresh" content="0">';
											
										}

									}

								}

							}

						?>
						<form class="input-textarea form-group" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
		   					<label>أسم المقال</label>
								<input class="form-control" type="text" name="Article-Name" required="required" value="<?php echo $Info['SAD_Name'] ?>">
		   					<label>صورة المقال</label>
		   						<h5>الصورة الأصلية</h5>
		   						<div>
		   							<img src="../Uploads/Images/<?php echo $Info['SAD_Image'] ?>" width="100px" height="100px">
		   						</div>
		   						<h5>عدل الصورة</h5>
								<input class="form-control" type="file" name="Article-Image">
		   					<label>تفاصيل المقال</label>
		   						<div class="textarea-Edit">
		   							<h5>المقال الأصلي</h5>
		   							<?php echo $Info['SAD_Details'] ?>
		   						</div>
		   						<h5>عدل المقال</h5>
								<textarea class="form-control" name="Article-Details"></textarea>
		   					<label>تصنيف المقال</label>
								<select class="form-control" name="Article-Parent" required="required">
									<option value="0">---</option>
									<option value="1" <?php if ($Info['SAD_Parent'] == 1) {echo 'selected';} ?>>وزارة الدفاع</option>
									<option value="2" <?php if ($Info['SAD_Parent'] == 2) {echo 'selected';} ?>>وزارة الداخلية</option>
									<option value="2" <?php if ($Info['SAD_Parent'] == 3) {echo 'selected';} ?>>وزارة الحرس الوطني</option>
								</select>
		   					<label>فيديوهات  للمقال</label>
								<input class="form-control" type="text" name="Article-Video" value="<?php echo $Info['SAD_Videos'] ?>">
								<input class="btn btn-primary btn-block" type="submit" name="SAD-Edit" value="تحديث">
						</form>
					</div>
				</div>
			</div>

<?php
// security-and-defense Edit Page End
	} elseif ($Edit == 'economy') {

		$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
		$WebInfoStmt = $con-> prepare("SELECT economy.*, users.User_Name AS UserWrite FROM economy JOIN users ON users.User_ID = economy.Eco_Write WHERE Eco_ID = ? ORDER BY Eco_ID DESC");
		$WebInfoStmt-> execute(array($ArtID));
		$Count = $WebInfoStmt-> rowCount();
		if ($Count > 0) {

			$economy = $WebInfoStmt-> fetchAll(); ?>

			<h1 class="Page-First text-center">wfwf </h1>
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
											echo '</tr>';

										}
									}

									?>
							</tr>
						</table>
					</div>
					<div class="col-lg-3">
						<?php 

							if($_SERVER['REQUEST_METHOD'] == 'POST') {

								if($_POST['Eco-Edit']) {

									$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
									$ArtEditStmt = $con-> prepare("SELECT * FROM economy WHERE Eco_ID = ?");
									$ArtEditStmt-> execute(array($ArtID));
									$Count = $ArtEditStmt-> rowCount();

									if ($Count > 0) {

										$ArtEcoInfo = $ArtEditStmt-> fetch();

										$ArtEcoName = filter_var($_POST['Article-Name'], FILTER_SANITIZE_STRING);
										$ArtEcoDetails = filter_var($_POST['Article-Details'], FILTER_SANITIZE_STRING);
										$ArtEcoParent = $_POST['Article-Parent'];
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

										$AddArtEcoError = array();
										if (empty($ArtEcoName)) {
											$AddArtEcoError[] = 'أسم المقال يجب أن لا يكون فارغاً';
										}
										if (empty($ArtEcoDetails)) {
											$ArtEcoDetails = $ArtEcoInfo['Eco_Details'];
										}
										if ($ArtEcoParent == 0) {
											$AddArtEcoError[] = 'يجب أن تختار تصنيف المقال';
										}
										if (!empty($ArtImageName) && !in_array($ArtImNameExplodeEnd, $ImageAllwedExtension)) {
											$AddArtEcoError[] = 'يجب ان يكون أمتداد الصورة فقط أحدى هذه الأمتدادات " jpg - jpeg - png - bmp - tiff - gif "';
										}
										if ($ArtImageSize > 4194304) {
												$UserInfoError[] = 'حجم الصورة كبير جدا أضف صورة حجمها يكون أقل من 4MB';
										}

										foreach ($AddArtEcoError as $AddEcoError) {
											echo "<div class='container alert alert-danger'>" . $AddEcoError . "</div>";
										}

										if (empty($AddArtEcoError)) {

											$Artimage = rand(0, 100000) . '_' . $ArtImageName;
										 	move_uploaded_file($ArtImageTmp, '../Uploads/Images/' . $Artimage);

										 	if (empty($ArtVideo)) {
										 		$ArtVideo = 'لا يوجد فيديو';
										 	}
										 	if (empty($ArtImageName)) {
											$Artimage = $ArtEcoInfo['Eco_Image'];
											}

											$AddArtEcoStmt = $con-> prepare("UPDATE economy SET Eco_Name = ?, Eco_Image = ?, Eco_Write = ?, Eco_Details = ?, Eco_Parent = ?, Eco_Videos = ? WHERE Eco_ID = ?");
											$AddArtEcoStmt-> execute(array($ArtEcoName, $Artimage, $_SESSION['UserID'], $ArtEcoDetails, $ArtEcoParent, $ArtVideo, $ArtID));

											echo '<meta http-equiv="refresh" content="0">';
											
										}

									}

								}

							}

						?>
						<form class="input-textarea form-group" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
		   					<label>أسم المقال</label>
								<input class="form-control" type="text" name="Article-Name" required="required" value="<?php echo $Info['Eco_Name'] ?>">
		   					<label>صورة المقال</label>
		   						<h5>الصورة الأصلية</h5>
		   						<div>
		   							<img src="../Uploads/Images/<?php echo $Info['Eco_Image'] ?>" width="100px" height="100px">
		   						</div>
		   						<h5>عدل الصورة</h5>
								<input class="form-control" type="file" name="Article-Image">
		   					<label>تفاصيل المقال</label>
		   						<div class="textarea-Edit">
		   							<h5>المقال الأصلي</h5>
		   							<?php echo $Info['Eco_Details'] ?>
		   						</div>
		   						<h5>عدل المقال</h5>
								<textarea class="form-control" name="Article-Details"></textarea>
		   					<label>تصنيف المقال</label>
								<select class="form-control" name="Article-Parent" required="required">
									<option value="0">---</option>
									<option value="1" <?php if ($Info['Eco_Parent'] == 1) {echo 'selected';} ?>>شركات خاصة</option>
									<option value="2" <?php if ($Info['Eco_Parent'] == 2) {echo 'selected';} ?>>شركات حكومية</option>
								</select>
		   					<label>فيديوهات  للمقال</label>
								<input class="form-control" type="text" name="Article-Video" value="<?php echo $Info['Eco_Videos'] ?>">
								<input class="btn btn-primary btn-block" type="submit" name="Eco-Edit" value="تحديث">
						</form>
					</div>
				</div>
			</div>

<?php
// economy Edit Page End
	} elseif ($Edit == 'politics') {

		$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
		$WebInfoStmt = $con-> prepare("SELECT politics.*, users.User_Name AS UserWrite FROM politics JOIN users ON users.User_ID = politics.Pol_Write WHERE Pol_ID = ? ORDER BY Pol_ID DESC");
		$WebInfoStmt-> execute(array($ArtID));
		$Count = $WebInfoStmt-> rowCount();
		if ($Count > 0) {

			$politics = $WebInfoStmt-> fetchAll(); ?>

			<h1 class="Page-First text-center">wfwf </h1>
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
											echo '</tr>';

										}
									}

									?>
							</tr>
						</table>
					</div>
					<div class="col-lg-3">
						<?php 

							if($_SERVER['REQUEST_METHOD'] == 'POST') {

								if($_POST['Pol-Edit']) {

									$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
									$ArtEditStmt = $con-> prepare("SELECT * FROM politics WHERE Pol_ID = ?");
									$ArtEditStmt-> execute(array($ArtID));
									$Count = $ArtEditStmt-> rowCount();

									if ($Count > 0) {

										$ArtPolInfo = $ArtEditStmt-> fetch();

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
											$ArtPolDetails = $ArtPolInfo['Pol_Details'];
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
										 	move_uploaded_file($ArtImageTmp, '../Uploads/Images/' . $Artimage);

										 	if (empty($ArtVideo)) {
										 		$ArtVideo = 'لا يوجد فيديو';
										 	}
										 	if (empty($ArtImageName)) {
											$Artimage = $ArtPolInfo['Pol_Image'];
											}

											$AddArtPolStmt = $con-> prepare("UPDATE politics SET Pol_Name = ?, Pol_Image = ?, Pol_Write = ?, Pol_Details = ?, Pol_Videos = ? WHERE Pol_ID = ?");
											$AddArtPolStmt-> execute(array($ArtPolName, $Artimage, $_SESSION['UserID'], $ArtPolDetails, $ArtVideo, $ArtID));

											echo '<meta http-equiv="refresh" content="0">';
											
										}

									}

								}

							}

						?>
						<form class="input-textarea form-group" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
		   					<label>أسم المقال</label>
								<input class="form-control" type="text" name="Article-Name" required="required" value="<?php echo $Info['Pol_Name'] ?>">
		   					<label>صورة المقال</label>
		   						<h5>الصورة الأصلية</h5>
		   						<div>
		   							<img src="../Uploads/Images/<?php echo $Info['Pol_Image'] ?>" width="100px" height="100px">
		   						</div>
		   						<h5>عدل الصورة</h5>
								<input class="form-control" type="file" name="Article-Image">
		   					<label>تفاصيل المقال</label>
		   						<div class="textarea-Edit">
		   							<h5>المقال الأصلي</h5>
		   							<?php echo $Info['Pol_Details'] ?>
		   						</div>
		   						<h5>عدل المقال</h5>
								<textarea class="form-control" name="Article-Details"></textarea>
		   					<label>فيديوهات  للمقال</label>
								<input class="form-control" type="text" name="Article-Video" value="<?php echo $Info['Pol_Videos'] ?>">
								<input class="btn btn-primary btn-block" type="submit" name="Pol-Edit" value="تحديث">
						</form>
					</div>
				</div>
			</div>

<?php
// politics Edit Page End
	}

	include $TempDir . 'footer.php';

} else {

	header('Location: AdminLogin.php');
	exit();

}
ob_end_flush();
?>