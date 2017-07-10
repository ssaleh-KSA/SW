<?php 

session_start();

if (isset($_SESSION['Ad-Un-SESSION'])) {

	include 'init.php'; ?>

<aside id="mySidenav" class="sidenav">
	<a class="closebtn" onclick="closeNav()">&times;</a>
	<div class="myhref">
                <a href="../History.php"> التاريخ </a>
                <a href="../Culture.php"> الثقافة </a>
                <a href="../Community.php"> المجتمع </a>
                <a href="../Tourism.php"> السياحة </a>
                <a href="../Sport.php"> رياضة </a>
                <a href="../Websites.php"> مواقع الكترونية </a>
                <a href="../SecurityAndDefense.php"> الأمن والدفاع </a>
                <a href="../Economy.php"> الأقتصاد </a>
                <a href="../Politics.php"> السياسة </a>
	</div>
</aside>

	<div class="container Admin-Page">
		<h1 class="Page-First text-center">لوحة التحكم</h1>
		<div class="container row">
			<div class="settings col-lg-12"><span class="cogs-open" onclick="openNav()"><i class="fa fa-cogs fa-5x"></i></span></div>
		</div>
		<div class="row">
			<div class="col-lg-3">
				<div class="panel Members">
					<div class="panel-heading"> الأعضاء </div>
					<div class="panel-body">
					<div class="The-Box">
						<i class="fa fa-users fa-5x"></i> 
						<?php 

							$ArtNumberStmt = $con-> prepare("SELECT User_ID FROM users");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();

						?>
						<span><a href="webInfo.php?Info=users"><?php echo $Count; ?></a></span>
						</div>
					</div>
						<?php 
							$ArtNumberStmt = $con-> prepare("SELECT User_ID FROM users WHERE alerts = 1");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();
							if($Count > 0) {

								echo '<div class="Alert-Box">';
									echo '<a href="webInfo.php?Info=users&alerts">'. $Count .'</a>';
								echo '</div>';

							}

							// $UserEditStmt = $con-> prepare("UPDATE users SET Alerts = 0");
							// $UserEditStmt-> execute();

						?>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="panel History">
					<div class="panel-heading"> التاريخ </div>
					<div class="panel-body">
					<div class="The-Box">
						<i class="fa fa-globe fa-5x"></i> 
						<?php 

							$ArtNumberStmt = $con-> prepare("SELECT His_ID FROM history");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();

						?>
						<span><a href="webInfo.php?Info=history"><?php echo $Count; ?></a></span>
						</div>
					</div>
						<?php 
							$ArtNumberStmt = $con-> prepare("SELECT His_ID FROM history WHERE alerts = 1");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();
							if($Count > 0) {

								echo '<div class="Alert-Box">';
									echo '<a href="webInfo.php?Info=history&alerts">'. $Count .'</a>';
								echo '</div>';

							}
						?>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="panel Culture">
					<div class="panel-heading"> الثقافة </div>
					<div class="panel-body">
					<div class="The-Box">
						<i class="fa fa-bank fa-5x"></i> 
						<?php 

							$ArtNumberStmt = $con-> prepare("SELECT Cul_ID FROM culture");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();

						?>
						<span><a href="webInfo.php?Info=culture"><?php echo $Count; ?></a></span>
						</div>
					</div>
						<?php 
							$ArtNumberStmt = $con-> prepare("SELECT Cul_ID FROM culture WHERE alerts = 1");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();
							if($Count > 0) {

								echo '<div class="Alert-Box">';
									echo '<a href="webInfo.php?Info=culture&alerts">'. $Count .'</a>';
								echo '</div>';

							}
						?>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="panel Community">
					<div class="panel-heading"> المجتمع </div>
					<div class="panel-body">
					<div class="The-Box">
						<i class="fa fa-group fa-5x"></i> 
						<?php 

							$ArtNumberStmt = $con-> prepare("SELECT Com_ID FROM community");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();

						?>
						<span><a href="webInfo.php?Info=community"><?php echo $Count; ?></a></span>
						</div>
					</div>
						<?php 
							$ArtNumberStmt = $con-> prepare("SELECT Com_ID FROM community WHERE alerts = 1");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();
							if($Count > 0) {

								echo '<div class="Alert-Box">';
									echo '<a href="webInfo.php?Info=community&alerts">'. $Count .'</a>';
								echo '</div>';

							}
						?>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="panel Tourism">
					<div class="panel-heading"> السياحة </div>
					<div class="panel-body">
					<div class="The-Box">
						<i class="fa fa-plane fa-5x"></i> 
						<?php 

							$ArtNumberStmt = $con-> prepare("SELECT Tou_ID FROM tourism");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();

						?>
						<span><a href="webInfo.php?Info=tourism"><?php echo $Count; ?></a></span>
						</div>
					</div>
						<?php 
							$ArtNumberStmt = $con-> prepare("SELECT Tou_ID FROM tourism WHERE alerts = 1");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();
							if($Count > 0) {

								echo '<div class="Alert-Box">';
									echo '<a href="webInfo.php?Info=tourism&alerts">'. $Count .'</a>';
								echo '</div>';

							}
						?>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="panel Sport">
					<div class="panel-heading"> الرياضة </div>
					<div class="panel-body">
					<div class="The-Box">
						<i class="fa fa-bicycle fa-5x"></i> 
						<?php 

							$ArtNumberStmt = $con-> prepare("SELECT Spo_ID FROM sport");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();

						?>
						<span><a href="webInfo.php?Info=sport"><?php echo $Count; ?></a></span>
						</div>
					</div>
						<?php 
							$ArtNumberStmt = $con-> prepare("SELECT Spo_ID FROM sport WHERE alerts = 1");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();
							if($Count > 0) {

								echo '<div class="Alert-Box">';
									echo '<a href="webInfo.php?Info=sport&alerts">'. $Count .'</a>';
								echo '</div>';

							}
						?>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="panel Websites">
					<div class="panel-heading"> مواقع الكترونية </div>
					<div class="panel-body">
					<div class="The-Box">
						<i class="fa fa-link fa-5x"></i> 
						<?php 

							$ArtNumberStmt = $con-> prepare("SELECT Web_ID FROM websites");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();

						?>
						<span><a href="webInfo.php?Info=websites"><?php echo $Count; ?></a></span>
						</div>
					</div>
						<?php 
							$ArtNumberStmt = $con-> prepare("SELECT Web_ID FROM websites WHERE alerts = 1");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();
							if($Count > 0) {

								echo '<div class="Alert-Box">';
									echo '<a href="webInfo.php?Info=websites&alerts">'. $Count .'</a>';
								echo '</div>';

							}
						?>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="panel SecurityAndDefense">
					<div class="panel-heading"> الأمن والدفاع </div>
					<div class="panel-body">
					<div class="The-Box">
						<i class="fa fa-truck fa-5x"></i> 
						<?php 

							$ArtNumberStmt = $con-> prepare("SELECT SAD_ID FROM security_and_defense");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();

						?>
						<span><a href="webInfo.php?Info=security-and-defense"><?php echo $Count; ?></a></span>
						</div>
					</div>
						<?php 
							$ArtNumberStmt = $con-> prepare("SELECT SAD_ID FROM security_and_defense WHERE alerts = 1");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();
							if($Count > 0) {

								echo '<div class="Alert-Box">';
									echo '<a href="webInfo.php?Info=security-and-defense&alerts">'. $Count .'</a>';
								echo '</div>';

							}
						?>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="panel Economy">
					<div class="panel-heading"> الأقتصاد </div>
					<div class="panel-body">
					<div class="The-Box">
						<i class="fa fa-money fa-5x"></i> 
						<?php 

							$ArtNumberStmt = $con-> prepare("SELECT Eco_ID FROM economy");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();

						?>
						<span><a href="webInfo.php?Info=economy"><?php echo $Count; ?></a></span>
						</div>
					</div>
						<?php 
							$ArtNumberStmt = $con-> prepare("SELECT Eco_ID FROM economy WHERE alerts = 1");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();
							if($Count > 0) {

								echo '<div class="Alert-Box">';
									echo '<a href="webInfo.php?Info=economy&alerts">'. $Count .'</a>';
								echo '</div>';

							}
						?>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="panel Politics">
					<div class="panel-heading"> السياسة </div>
					<div class="panel-body">
					<div class="The-Box">
						<i class="fa fa-flag fa-5x"></i> 
						<?php 

							$ArtNumberStmt = $con-> prepare("SELECT Pol_ID FROM politics");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();

						?>
						<span><a href="webInfo.php?Info=politics"><?php echo $Count; ?></a></span>
						</div>
					</div>
						<?php 
							$ArtNumberStmt = $con-> prepare("SELECT Pol_ID FROM politics WHERE alerts = 1");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();
							if($Count > 0) {

								echo '<div class="Alert-Box">';
									echo '<a href="webInfo.php?Info=politics&alerts">'. $Count .'</a>';
								echo '</div>';

							}
						?>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="panel Comments">
					<div class="panel-heading"> التعليقات </div>
					<div class="panel-body">
					<div class="The-Box">
						<i class="fa fa-comments fa-5x"></i> 
						<?php 

							$ArtNumberStmt = $con-> prepare("SELECT Com_ID FROM comments");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();

						?>
						<span><a href="webInfo.php?Info=comments"><?php echo $Count; ?></a></span>
						</div>
					</div>
						<?php 
							$ArtNumberStmt = $con-> prepare("SELECT Com_ID FROM comments WHERE alerts = 1");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();
							if($Count > 0) {

								echo '<div class="Alert-Box">';
									echo '<a href="webInfo.php?Info=comments&alerts">'. $Count .'</a>';
								echo '</div>';

							}
						?>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="panel News">
					<div class="panel-heading"> الأخبار </div>
					<div class="panel-body">
					<div class="The-Box">
						<i class="fa fa-newspaper-o fa-5x"></i> 
						<?php 

							$ArtNumberStmt = $con-> prepare("SELECT News_ID FROM news");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();

						?>
						<span><a href="webInfo.php?Info=news"><?php echo $Count; ?></a></span>
						</div>
					</div>
						<?php 
							$ArtNumberStmt = $con-> prepare("SELECT News_ID FROM news WHERE alerts = 1");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();
							if($Count > 0) {

								echo '<div class="Alert-Box">';
									echo '<a href="webInfo.php?Info=news&alerts">'. $Count .'</a>';
								echo '</div>';

							}
						?>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="panel ConntactUs">
					<div class="panel-heading"> تواصل معنا </div>
					<div class="panel-body">
					<div class="The-Box">
						<i class="fa fa-pencil-square-o fa-5x"></i> 
						<?php 

							$ArtNumberStmt = $con-> prepare("SELECT Con_ID FROM connect_us");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();

						?>
						<span><a href="webInfo.php?Info=connect-us"><?php echo $Count; ?></a></span>
						</div>
					</div>
						<?php 
							$ArtNumberStmt = $con-> prepare("SELECT Con_ID FROM connect_us WHERE alerts = 1");
							$ArtNumberStmt-> execute();
							$Count = $ArtNumberStmt-> rowCount();
							if($Count > 0) {

								echo '<div class="Alert-Box">';
									echo '<a href="webInfo.php?Info=connect-us&alerts">'. $Count .'</a>';
								echo '</div>';

							}
						?>
				</div>
			</div>
		</div>
	</div>

<?php
	include $TempDir . 'footer.php';

} else {

	header('Location: AdminLogin.php');
	exit();

}

?>