<?php

session_start();

if (isset($_SESSION['Ad-Un-SESSION'])) {

	include 'init.php';

	$Delete = '';

	if (isset($_GET['Delete'])) {
		$Delete = $_GET['Delete'];
	} else {
		header('Location: Admin.php');
		exit();
	}

	if ($Delete == 'users') {

		$UserID = isset($_GET['UserID']) && is_numeric($_GET['UserID']) ? intval($_GET['UserID']) : 0;
		$UserDeleteStmt = $con-> prepare("DELETE FROM users WHERE User_ID = :User_ID");
		$UserDeleteStmt-> bindparam(':User_ID', $UserID);
		$UserDeleteStmt-> execute();
		header('Location: webInfo.php?Info=users');
		exit();

	} elseif ($Delete == 'history') {

		$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
		$UserDeleteStmt = $con-> prepare("DELETE FROM history WHERE His_ID = :User_ID");
		$UserDeleteStmt-> bindparam(':User_ID', $ArtID);
		$UserDeleteStmt-> execute();
		header('Location: webInfo.php?Info=history');
		exit();
		
	} elseif ($Delete == 'culture') {

		$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
		$UserDeleteStmt = $con-> prepare("DELETE FROM culture WHERE Cul_ID = :User_ID");
		$UserDeleteStmt-> bindparam(':User_ID', $ArtID);
		$UserDeleteStmt-> execute();
		header('Location: webInfo.php?Info=culture');
		exit();
		
	} elseif ($Delete == 'community') {

		$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
		$UserDeleteStmt = $con-> prepare("DELETE FROM community WHERE Com_ID = :User_ID");
		$UserDeleteStmt-> bindparam(':User_ID', $ArtID);
		$UserDeleteStmt-> execute();
		header('Location: webInfo.php?Info=community');
		exit();
		
	} elseif ($Delete == 'tourism') {

		$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
		$UserDeleteStmt = $con-> prepare("DELETE FROM tourism WHERE Tou_ID = :User_ID");
		$UserDeleteStmt-> bindparam(':User_ID', $ArtID);
		$UserDeleteStmt-> execute();
		header('Location: webInfo.php?Info=tourism');
		exit();
		
	} elseif ($Delete == 'sport') {

		$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
		$UserDeleteStmt = $con-> prepare("DELETE FROM sport WHERE Spo_ID = :User_ID");
		$UserDeleteStmt-> bindparam(':User_ID', $ArtID);
		$UserDeleteStmt-> execute();
		header('Location: webInfo.php?Info=sport');
		exit();
		
	} elseif ($Delete == 'websites') {

		$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
		$UserDeleteStmt = $con-> prepare("DELETE FROM websites WHERE Web_ID = :User_ID");
		$UserDeleteStmt-> bindparam(':User_ID', $ArtID);
		$UserDeleteStmt-> execute();
		header('Location: webInfo.php?Info=websites');
		exit();
		
	} elseif ($Delete == 'security-and-defense') {

		$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
		$UserDeleteStmt = $con-> prepare("DELETE FROM security_and_defense WHERE SAD_ID = :User_ID");
		$UserDeleteStmt-> bindparam(':User_ID', $ArtID);
		$UserDeleteStmt-> execute();
		header('Location: webInfo.php?Info=security-and-defense');
		exit();
		
	} elseif ($Delete == 'economy') {

		$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
		$UserDeleteStmt = $con-> prepare("DELETE FROM economy WHERE Eco_ID = :User_ID");
		$UserDeleteStmt-> bindparam(':User_ID', $ArtID);
		$UserDeleteStmt-> execute();
		header('Location: webInfo.php?Info=economy');
		exit();
		
	} elseif ($Delete == 'politics') {

		$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
		$UserDeleteStmt = $con-> prepare("DELETE FROM politics WHERE Pol_ID = :User_ID");
		$UserDeleteStmt-> bindparam(':User_ID', $ArtID);
		$UserDeleteStmt-> execute();
		header('Location: webInfo.php?Info=politics');
		exit();
		
	} elseif ($Delete == 'comments') {

		$CommeID = isset($_GET['CommeID']) && is_numeric($_GET['CommeID']) ? intval($_GET['CommeID']) : 0;
		$UserDeleteStmt = $con-> prepare("DELETE FROM comments WHERE Com_ID = :User_ID");
		$UserDeleteStmt-> bindparam(':User_ID', $CommeID);
		$UserDeleteStmt-> execute();
		header('Location: webInfo.php?Info=comments');
		
	} elseif ($Delete == 'news') {

		$ArtID = isset($_GET['ArtID']) && is_numeric($_GET['ArtID']) ? intval($_GET['ArtID']) : 0;
		$UserDeleteStmt = $con-> prepare("DELETE FROM news WHERE News_ID = :User_ID");
		$UserDeleteStmt-> bindparam(':User_ID', $ArtID);
		$UserDeleteStmt-> execute();
		header('Location: webInfo.php?Info=news');
		
	} elseif ($Delete == 'connect-us') {

		$Con_Message = isset($_GET['Con-Message']) && is_numeric($_GET['Con-Message']) ? intval($_GET['Con-Message']) : 0;
		$UserDeleteStmt = $con-> prepare("DELETE FROM connect_us WHERE Con_ID = :User_ID");
		$UserDeleteStmt-> bindparam(':User_ID', $Con_Message);
		$UserDeleteStmt-> execute();
		header('Location: webInfo.php?Info=connect-us');
		
	}

	include $TempDir . 'footer.php';

} else {

	header('Location: AdminLogin.php');
	exit();

}