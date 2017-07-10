<?php 

session_start();

if (isset($_SESSION['username'])) {

	include 'init.php';

	$ContinueUser = '';

	if (isset($_GET['ContinueUser'])) {

		$ContinueUser = $_GET['ContinueUser'];

	} else {

		$ContinueUser = 'ContinueUser';

	}

	

	if ($ContinueUser == 'Following') {

		$UsWrID = isset($_GET['UserID']) && is_numeric($_GET['UserID']) ? intval($_GET['UserID']) : 0;

		$UserID = $_SESSION['UserID'];

		$ContinueUserStmt = $con-> prepare("SELECT * FROM users WHERE User_ID = ?");
		$ContinueUserStmt-> execute(array($UserID));
		$Count = $ContinueUserStmt-> rowCount();

			if ($Count > 0) {

				$SESSIONUserInfo = $ContinueUserStmt-> fetch();

				$User_Following = $SESSIONUserInfo['User_Following'];

				$User_Followers_New = $User_Following . $UsWrID . ',';

				 		$UserFollowersStmt = $con-> prepare("UPDATE users SET User_Following = ? WHERE User_ID = ?");
						$UserFollowersStmt-> execute(array($User_Followers_New ,$UserID));

						header("Location: Continue-User.php?ContinueUser=Follower&UsWrID=" . $UsWrID);
						exit();

			}

	} elseif ($ContinueUser == 'unFollowing') {

		$UsWrID = isset($_GET['UserID']) && is_numeric($_GET['UserID']) ? intval($_GET['UserID']) : 0;

		$UserID = $_SESSION['UserID'];

		$ContinueUserStmt = $con-> prepare("SELECT * FROM users WHERE User_ID = ?");
		$ContinueUserStmt-> execute(array($UserID));
		$Count = $ContinueUserStmt-> rowCount();

			if ($Count > 0) {

				$SESSIONUserInfo = $ContinueUserStmt-> fetch();

				$User_Following = $SESSIONUserInfo['User_Following'];

				$Follow = explode(',', $User_Following);

				$UnFollow = array_diff($Follow, [$UsWrID]);

				$User_Followers_New_After_delete = implode(',', $UnFollow);

				 	if ($Count > 0) {

				 		$UserFollowersStmt = $con-> prepare("UPDATE users SET User_Following = ? WHERE User_ID = ?");
						$UserFollowersStmt-> execute(array($User_Followers_New_After_delete ,$UserID));

						header("Location: Continue-User.php?ContinueUser=UnFollower&UsWrID=" . $UsWrID);
						exit();

				 	}
			}

	} elseif ($ContinueUser == 'Follower') {

		$UsWrID = isset($_GET['UsWrID']) && is_numeric($_GET['UsWrID']) ? intval($_GET['UsWrID']) : 0;

		$UserID = $_SESSION['UserID'];

		$UserFollowingStmt = $con-> prepare("SELECT * FROM users WHERE User_ID = ?");
		$UserFollowingStmt-> execute(array($UsWrID));
		$FollowingCount = $UserFollowingStmt-> rowCount();

		if ($FollowingCount > 0) {

			$FollowingInfo = $UserFollowingStmt-> fetch();

			$User_Followers = $FollowingInfo['User_Followers'];

			$User_Followers_New = $User_Followers . $UserID . ',';

			$UFollowingStmt = $con-> prepare("UPDATE users SET User_Followers = ? WHERE User_ID = ?");
			$UFollowingStmt-> execute(array($User_Followers_New, $UsWrID));

			header("Location: UserProfile.php?UserWriteID=". $UsWrID);
			exit();

		}

	} elseif ($ContinueUser == 'UnFollower') {

		$UsWrID = isset($_GET['UsWrID']) && is_numeric($_GET['UsWrID']) ? intval($_GET['UsWrID']) : 0;

		$UserID = $_SESSION['UserID'];

		$UserFollowingStmt = $con-> prepare("SELECT * FROM users WHERE User_ID = ?");
		$UserFollowingStmt-> execute(array($UsWrID));
		$FollowingCount = $UserFollowingStmt-> rowCount();

		if ($FollowingCount > 0) {

			$FollowingInfo = $UserFollowingStmt-> fetch();

			$User_Followers = $FollowingInfo['User_Followers'];

			$Following = explode(',', $User_Followers);
			$UnFollowing = array_diff($Following, [$UserID]);
			$User_Followers_New_After_delete = implode(',', $UnFollowing);

			$UFollowingStmt = $con-> prepare("UPDATE users SET User_Followers = ? WHERE User_ID = ?");
			$UFollowingStmt-> execute(array($User_Followers_New_After_delete, $UsWrID));

			header("Location: UserProfile.php?UserWriteID=". $UsWrID);
			exit();

	}

	} else {

		header("Location: UserProfile.php");
		exit();

	}


} else {

	header('Location: login.php');
	exit();

}

include $TempDir . 'footer.php';