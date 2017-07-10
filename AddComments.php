<?php

session_start();

if (isset($_SESSION['username'])) {

	include 'init.php';
//--------------------------------------------------------------------------------------------------------

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$UserComment = filter_var($_POST['user-Comment'], FILTER_SANITIZE_STRING);
		$Com_SectionName = $_POST['ComSectionName'];
		$ArtID = $_POST['ArtID'];
		$GETName = $_POST['GETName'];


		if (!empty($UserComment)) {

			$AddCommentStmt = $con-> prepare("INSERT INTO comments(Com_Comments, Com_Date, Com_UserName, Com_SectionName, Art_ID, Alerts) 
											VALUES(:TheComment, now(), :TheSESSION, :SectionName, :ArticleID, :Alerts)");
			$AddCommentStmt-> execute(array(

				'TheComment' 	=> $UserComment,
				'TheSESSION' 	=> $_SESSION['UserID'],
				'SectionName' 	=> $Com_SectionName,
				'ArticleID' 	=> $ArtID,
				'Alerts' 		=> '1'

			));

			header('Location: Articles.php?Art='. $GETName . '&ArtID='. $ArtID .'#Comments');
			exit();

		} else {

			echo "<div class='Page-First container alert alert-danger'>لا يمكنك ترك حقل التعليق فارغ</div>";

		}
		


	} else {

		header('Location: index.php');
		exit();

	}

//--------------------------------------------------------------------------------------------------------
	include $TempDir . 'footer.php';

} else {

	header('Location: login.php');
	exit();

}