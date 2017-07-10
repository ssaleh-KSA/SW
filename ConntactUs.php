<?php 

	session_start();
	
	include 'init.php'; 

?>

<div class="container">
<h3 class="Page-First text-center">تواصل معنا</h3>
	<article class="row">
		<aside class="col-lg-8 Sections-Articles">
			<div class="Conntact-Us">
				<div class="panel panel-info">
				<div class="panel-heading">أرسل, شكوى, أقتراح, ملاحظة, طلب, أو أي شيء ترغب بإيصاله لنا وسيتم الرد في أقرب فرصة.</div>
					<div class="panel-body">
						<form class="input-textarea form-group" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
							<label>الأسم</label>			
								<input class="form-control" type="text" name="TheSenderName">
							<label>الأيميل</label>
								<input class="form-control" type="email" name="TheSenderEmail">
							<label>نوع الرسالة</label>
								<select class="form-control" name="MessageParent">
									<option value="0">---</option>
									<option value="1">شكوى</option>
									<option value="2">أقتراح</option>
									<option value="3">ملاحظة</option>
									<option value="4">طلب</option>
									<option value="5">أخرى</option>
								</select>
							<label>الموضوع</label>
								<input class="form-control" type="text" name="TheSenderSubject">
							<label>الرسالة</label>
								<textarea class="form-control" name="TheSenderMessage"></textarea>
								<input class="btn btn-primary" type="submit" name="SendTheMessage">
						</form>
					</div>
				</div>
			</div>
			<?php 

				if(isset($_POST['SendTheMessage'])) {

					$TheSenderName = filter_var($_POST['TheSenderName'], FILTER_SANITIZE_STRING);
					$TheSenderEmail = filter_var($_POST['TheSenderEmail'], FILTER_SANITIZE_EMAIL);
					$TheSenderSubject = filter_var($_POST['TheSenderSubject'], FILTER_SANITIZE_STRING);
					$TheSenderMessage = filter_var($_POST['TheSenderMessage'], FILTER_SANITIZE_STRING);
					$MessageParent = $_POST['MessageParent'];

					$ConntactUsFormErrors = array();
					if ($MessageParent == 0) {
						$ConntactUsFormErrors[] = 'يجب أن تختار نوع الرسالة';
					}

					foreach($ConntactUsFormErrors as $ConntactErrors) {
						echo "<div class='alert alert-danger'>". $ConntactErrors ."</div>";
					}

					if (empty($ConntactUsFormErrors)) {

						$TheSenderUsername = '';
						if (isset($_SESSION['UserID'])) {
							$TheSenderUsername = $_SESSION['UserID'];
						} else {
							$TheSenderUsername = '0';
						}

						$SendMessageStmt = $con-> prepare("INSERT INTO connect_us(Con_Name, Con_Email, Con_Parent, Con_Subject, Con_Message, Con_UserName, Con_Date, Con_Answered, alerts) VALUES(:SenderName, :SenderEmail, :MessageParent, :SenderSubject, :SenderMessage, :SenderUserName, now(), 0, :alerts)");
						$SendMessageStmt-> execute(array(

							'SenderName' => $TheSenderName,
							'SenderEmail' => $TheSenderEmail,
							'MessageParent' => $MessageParent,
							'SenderSubject' => $TheSenderSubject,
							'SenderMessage' => $TheSenderMessage,
							'SenderUserName' => $TheSenderUsername,
							'alerts' 		=> '1'

						));

						echo "<div class='alert alert-success'>تم أرسال رسالتك... سيتم الرد عليك في أقرب فرصة</div>";

					}

				}

			?>
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

<?php include $TempDir . 'footer.php'; ?>