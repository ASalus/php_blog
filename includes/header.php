
<header id="header">
    <div class="header__top">
        <div class="container">
          <div class="header__top__logo">
            <h1><?php echo $config['title'] ?></h1>
          </div>
          <nav class="header__top__menu">
            <ul>
              <li><a href="/" class="mainmenu">Main</a></li>
              <li><a href="/pages/about_me.php" class="mainmenu">About Me</a></li>
              <li><a href=<?php echo $config['twitter']?>>Twitter</a></li>
              <?php 
              if (isset($_SESSION['logged_user'])){
                ?>
                <li><a href="/includes/sign_out.php">Logout [<?php echo $_SESSION['logged_user']["login"]?>]</a></li>
                <?php
              } else
              {?>
                <li><a href="/pages/login.php">Log In</a></li>
                <?php
              }
              ?>
            </ul>
          </nav>
        </div>
      </div>
      <?php  
        $categories = mysqli_query($connection, "SELECT * FROM `articles_categories`")
      ?>
      <div class="header__bottom">
        <div class="container">
          <nav>
            <ul>
              <?php
                while ($cat = mysqli_fetch_assoc($categories))
                {
                  ?>
                  <li><a href="/articles.php?category=<?php echo $cat['id']; ?>"><?php echo $cat['title']; ?></a></li>
                  <?php
                }
              ?>
            </ul>
          </nav>
        </div>
      </div>
</header>