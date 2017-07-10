<?php include 'init.php'; ?>
<!-- About Us Section Start -->
<div class="container">
<div class="AboutUs-Box">
<div class="">
<h3>السعودية</h3>
<div>
<span></span><i class="fa fa-chevron-down fa-lg"></i><span></span>
</div>
<p> مرحباً بالجميع, هذا الموقع عبارة عن موسوعة شاملة ستجد فيها أخي الزائر وأختي الزائرة ظالتكم عن المملكة العربية السعودية وأي معلومة ترغب بالبحث عنها, ونعتمد نحن في هذا الموقع على المعلومات من مصدرها الرسمي ونتجنب للمعلومات المغلوطة المضللة لشعوب العالم عن المملكة العربية السعودية, فمرحباً مرةً أخرى بك أيها الزائر والزائرة وأي شيء تريد معرفتة ولم تستطع أيجادة يمكنك أستخدام خاصية البحث من قاعدة بياناتنا, أو بالذهاب الى <span>"طلب معلومة"</span> الموجودة في الأعلى... تحياتنا للجميع. </p>
</div>
</div>
</div>
<!-- About Us Section Start -->
<!-- The Sections Start -->
<h1 class="sections-page-h1"> الأقسام </h1>

<div class="sections-div">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-md-3">
				<div class="section-box">
					<img class="img-responsive img-thumbnail" src="Layout/Images/image.jpeg" alt="The Section Image">
					<hr>
					<div class="section-info">
						<?php 

							$ArtNumberStmt = $con-> prepare("SELECT His_ID FROM history");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();

						?>
						<a href="History.php"> <h4> التاريخ </h4> </a>
						<p>نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم</p>
						<span>عدد المواضيع: <?php echo $Count; ?></span>
						</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-3">
				<div class="section-box">
					<img class="img-responsive img-thumbnail" src="Layout/Images/image.jpeg" alt="The Section Image">
					<hr>
					<div class="section-info">
						<?php 

							$ArtNumberStmt = $con-> prepare("SELECT Cul_ID FROM culture");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();

						?>
						<a href="Culture.php"> <h4> الثقافة </h4> </a>
						<p>نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم</p>
						<span>عدد المواضيع: <?php echo $Count; ?></span>
						</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-3">
				<div class="section-box">
					<img class="img-responsive img-thumbnail" src="Layout/Images/image.jpeg" alt="The Section Image">
					<hr>
					<div class="section-info">
						<?php 

							$ArtNumberStmt = $con-> prepare("SELECT Com_ID FROM community");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();

						?>
						<a href="Community.php"> <h4> المجتمع </h4> </a>
						<p>نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم</p>
						<span>عدد المواضيع: <?php echo $Count; ?></span>
						</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-3">
				<div class="section-box">
					<img class="img-responsive img-thumbnail" src="Layout/Images/image.jpeg" alt="The Section Image">
					<hr>
					<div class="section-info">
						<?php 

							$ArtNumberStmt = $con-> prepare("SELECT Tou_ID FROM tourism");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();

						?>
						<a href="Tourism.php"> <h4> السياحة </h4> </a>
						<p>نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم</p>
						<span>عدد المواضيع: <?php echo $Count; ?></span>
						</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-3">
				<div class="section-box">
					<img class="img-responsive img-thumbnail" src="Layout/Images/image.jpeg" alt="The Section Image">
					<hr>
					<div class="section-info">
						<?php 

							$ArtNumberStmt = $con-> prepare("SELECT Spo_ID FROM sport");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();

						?>
						<a href="Sport.php"> <h4> رياضة </h4> </a>
						<p>نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم</p>
						<span>عدد المواضيع: <?echo $Count;php  ?></span>
						</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-3">
				<div class="section-box">
					<img class="img-responsive img-thumbnail" src="Layout/Images/image.jpeg" alt="The Section Image">
					<hr>
					<div class="section-info">
						<?php 

							$ArtNumberStmt = $con-> prepare("SELECT Web_ID FROM websites");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();

						?>
						<a href="Websites.php"> <h4> مواقع الكترونية </h4> </a>
						<p>نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم</p>
						<span>عدد المواضيع: <?php echo $Count; ?></span>
						</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-3">
				<div class="section-box">
					<img class="img-responsive img-thumbnail" src="Layout/Images/image.jpeg" alt="The Section Image">
					<hr>
					<div class="section-info">
						<?php 

							$ArtNumberStmt = $con-> prepare("SELECT SAD_ID FROM security_and_defense");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();

						?>
						<a href="SecurityAndDefense.php"> <h4> الأمن والدفاع </h4> </a>
						<p>نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم</p>
						<span>عدد المواضيع: <?php echo $Count; ?></span>
						</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-3">
				<div class="section-box">
					<img class="img-responsive img-thumbnail" src="Layout/Images/image.jpeg" alt="The Section Image">
					<hr>
					<div class="section-info">
						<?php 

							$ArtNumberStmt = $con-> prepare("SELECT Eco_ID FROM economy");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();

						?>
						<a href="Economy.php"> <h4> الأقتصاد </h4> </a>
						<p>نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم</p>
						<span>عدد المواضيع: <?php echo $Count; ?></span>
						</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-3">
				<div class="section-box">
					<img class="img-responsive img-thumbnail" src="Layout/Images/image.jpeg" alt="The Section Image">
					<hr>
					<div class="section-info">
						<?php 

							$ArtNumberStmt = $con-> prepare("SELECT Pol_ID FROM politics");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();

						?>
						<a href="Politics.php"> <h4> السياسة </h4> </a>
						<p>نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم نبذه عن القسم</p>
						<span>عدد المواضيع: <?php echo $Count; ?></span>
						</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- The Sections Start -->
<?php include $TempDir . 'footer.php'; ?>