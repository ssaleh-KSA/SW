<?php 

session_start();

?>
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
      <div class="navbar-header navbar-right">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="../index.php">السعودية</a>
      </div>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
        <?php 
            if (isset($_SESSION['Ad-Un-SESSION'])) { ?>
              <li class="dropdown">
            <?php echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">' . $_SESSION['Ad-Un-SESSION'] . '<span class="caret"></span></a>'; ?>
            <ul class="dropdown-menu">
              <li><a href="../Profile.php">الملف الشخصي</a></li>
              <li><a href="../logout.php">تسجيل الخروج</a></li>
            </ul>
          </li>
          <li><a href="Admin.php">لوحة التحكم</a></li>
              <?php
            } else {
              echo "<li><a href='../login.php'>دخول</a></li>";
            }
        ?>
          <li><a href="../ConntactUs.php">تواصل معنا</a></li>
          <li><a href="../AboutUs.php">من نحن؟</a></li>
          <li><a href="../News.php">الأخبار</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">الأقسام <span class="caret"></span></a>
            <ul class="dropdown-menu">
             <li>
                <a href="../History.php"> التاريخ </a>
             </li>
             <li>
                <a href="../Culture.php"> الثقافة </a>
             </li>
             <li>
                <a href="../Community.php"> المجتمع </a>
             </li>
             <li>
                <a href="../Tourism.php"> السياحة </a>
             </li>
             <li>
                <a href="../Sport.php"> رياضة </a>
             </li>
             <li>
                <a href="../Websites.php"> مواقع الكترونية </a>
             </li>
             <li>
                <a href="../SecurityAndDefense.php"> الأمن والدفاع </a>
             </li>
             <li>
                <a href="../Economy.php"> الأقتصاد </a>
             </li>
             <li>
                <a href="../Politics.php"> السياسة </a>
             </li>
            </ul>
          </li>
        </ul>
      </div>
  </div>
</nav>