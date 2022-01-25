<?php
require "../includes/config.php";
require "../includes/handler.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?php echo $config['title'] ?></title>

  <!-- Bootstrap Grid -->
  <link rel="stylesheet" type="text/css" href="../media/assets/bootstrap-grid-only/css/grid12.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

  <!-- Custom -->
  <link rel="stylesheet" type="text/css" href="../media/css/style.css">
</head>

<body>

  <div id="wrapper">

    <?php include "../includes/header.php"; ?>

    <div id="content">
      <div class="container">
        <div class="row">
          <section class="content__left col-md-8">
            <div class="block">
              <h3>Log In</h3>
              <div class="block__content">
                <div class="block__content">
                  <?php
                  ?>
                  <form class="form" method="post" action="login.php">
                    <?php
                    if (isset($_POST['do_post'])) {
                      list($logged_in, $errors, $user) = login_check($_POST['nickname'], $_POST['password'], $connection);
                      if ($logged_in == true) {
                        $_SESSION['logged_user'] = mysqli_fetch_assoc($user);
                        echo '<span style="color: green; font-weight: bold; margin-bottom: 10px;
                        display: block">Walcome!</span>';
                        header("Location: /");
                      } else {
                        if (empty($errors) == false) {
                          echo '<span style="color: red; font-weight: bold; margin-bottom: 10px; 
                          display: block">' . $errors[0] . '</span>';
                        } else {
                          echo '<span style="color: red; font-weight: bold; margin-bottom: 10px; 
                          display: block">Wrong nickname or password</span>';
                        }
                      }
                    }
                    ?>
                    <div class="form__log">
                      <div class="row bottom-space">
                        <div class="col-md-6">
                          <input type="text" name="nickname" class="form__control" placeholder="Nickname" value="<?php if (isset($_POST['nickname'])) {
                                                                                                                    echo $_POST["nickname"];
                                                                                                                  } ?>">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <input type="password" name="password" class="form__control" placeholder="Password" value="<?php if (isset($_POST['password'])) {
                                                                                                                        echo $_POST["password"];
                                                                                                                      } ?>">
                        </div>
                      </div>
                    </div>
                      <div class="form__btn">
                        <input type="submit" class="form__control" name="do_post" value="Log In"></input>
                        <p>Not a member? <a href="sign_up.php">Sign up now</a></p>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
          </section>
          <section class="content__right col-md-4">
            <?php include "../includes/sidebar.php"; ?>
          </section>
        </div>
      </div>
    </div>

    <?php
    include '../includes/footer.php';
    ?>

  </div>

</body>

</html>