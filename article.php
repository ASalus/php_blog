<?php require "includes/config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?php $config['title'] ?></title>

  <!-- Bootstrap Grid -->
  <link rel="stylesheet" type="text/css" href="../media/assets/bootstrap-grid-only/css/grid12.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

  <!-- Custom -->
  <link rel="stylesheet" type="text/css" href="../media/css/style.css">
</head>

<body>

  <div id="wrapper">

    <?php include "includes/header.php"; ?>

    <?php

    $article = mysqli_query($connection, "SELECT * FROM `articles` WHERE `id`=" . (int) $_GET['id']);
    $art = mysqli_fetch_assoc($article);
    if (mysqli_num_rows($article) <= 0) { ?>
      <div id="content">
        <div class="container">
          <div class="row">
            <section class="content__left col-md-8">
              <div class="block">
                <h3>Page not found!</h3>
                <div class="block__content">
                  <div class="full-text">Requested article does not exist!</div>
                </div>
              </div>
            </section>
            <section class="content__right col-md-4">
              <?php include "includes/sidebar.php"; ?>
            </section>
          </div>
        </div>
      </div>
    <?php
    } else {
      mysqli_query($connection, "UPDATE `articles` SET `views` = `views`+1 WHERE `id`=" . (int) $art['id']);
    ?>
      <div id="content">
        <div class="container">
          <div class="row">
            <section class="content__left col-md-8">
              <div class="block">
                <a><?php echo $art['views'] ?> views </a>
                <h3><?php echo $art['title'] ?></h3>
                <div class="block__content">
                  <img src="/static/images/<?php echo $art['image'] ?>" style="max-width: 100%">
                  <div class="full-text"><?php echo strip_tags($art['text']) ?></div>
                </div>
              </div>
              <div class="block">
                <a href="#comment-add-form">Add comment</a>
                <h3>Comments</h3>
                <div class="block__content">
                  <div class="articles articles__vertical">
                    <?php
                    $comments = mysqli_query($connection, "SELECT * FROM `comments` 
                                        WHERE `article_id`=" . (int) $art['id'] . " ORDER BY `id` DESC");
                    if (mysqli_num_rows($comments) <= 0) {
                      echo "No comments...";
                    }
                    while ($comment = mysqli_fetch_assoc($comments)) {
                    ?>
                      <article class="article">
                        <div class="article__image" style="background-image: url(https://www.gravatar.com/avatar/<?php echo md5($comment['email']); ?>?s=125)">
                        </div>
                        <div class="article__info">
                          <a href="#?>">
                            <?php echo $comment['author']; ?></a>
                          <div class="article__info__meta"></div>
                          <div class="article__info__preview">
                            <?php echo strip_tags($comment['text']); ?></div>
                        </div>
                      </article>
                    <?php
                    }
                    ?>

                  </div>
                </div>
              </div>
              <div id="comment-add-form" class="block">
                <h3>Add comment</h3>
                <div class="block__content">
                  <form class="form" method="post" action="article.php?id=<?php echo $art['id']; ?>
                                #comment-add-form">
                    <?php
                    if (isset($_POST['do_post'])) {
                      $errors = array();
                      if ($_POST['name'] == '') {
                        $errors[] = 'Enter your name!';
                      }
                      if ($_POST['nickname'] == '') {
                        $errors[] = 'Enter your nickname!';
                      }
                      if ($_POST['email'] == '') {
                        $errors[] = 'Enter your E-mail!';
                      }
                      if ($_POST['text'] == '') {
                        $errors[] = 'Enter comment text!';
                      }
                      if (empty($errors)) {
                        mysqli_query($connection, "INSERT INTO `comments` 
                                            (`author`, `nickname`, `email`, `text`, `pubdate`, `article_id`) VALUES 
                                            ('" . $_POST['name'] . "','" . $_POST['nickname'] . "','" . $_POST['email'] . "','" .
                          $_POST['text'] . "', NOW(),'" . $art['id'] . "')");
                        echo '<span style="color: green; font-weight: bold; margin-bottom: 10px;
                                            display: block">Your comment successfully added</span>';
                      } else {
                        echo '<span style="color: red; font-weight: bold; margin-bottom: 10px;
                                            display: block">' . $errors[0] . '</span>';
                      }
                    }
                    ?>
                    <div class="form__group">
                      <div class="row">
                        <div class="col-md-4">
                          <input type="text" name="name" class="form__control" placeholder="Name" value="<?php if (isset($_GET['name'])) {
                                                                                                            echo $_GET["name"];
                                                                                                          } ?>">
                        </div>
                        <div class="col-md-4">
                          <input type="text" name="nickname" class="form__control" placeholder="Nickname" value="<?php if (isset($_GET['nickname'])) {
                                                                                                                    echo $_GET["nickname"];
                                                                                                                  } ?>">
                        </div>
                        <div class="col-md-4">
                          <input type="text" name="email" class="form__control" placeholder="E-mail (not gonna be shown)" value="<?php if (isset($_GET['email'])) {
                                                                                                                                    echo $_GET["email"];
                                                                                                                                  } ?>">
                        </div>
                      </div>
                    </div>
                    <div class="form__group">
                      <textarea class="form__control" name="text" placeholder="Comment text..."><?php if (isset($_GET['name'])) {
                                                                                                  echo $_GET["name"];
                                                                                                } ?></textarea>
                    </div>
                    <div class="form__group">
                      <input type="submit" class="form__control" name="do_post" value="Add comment"></input>
                    </div>
                  </form>
                </div>
            </section>
            <section class="content__right col-md-4">
              <?php include "includes/sidebar.php"; ?>
            </section>
          </div>
        </div>
      </div>
    <?php
    }
    ?>


    <?php
    include 'includes/footer.php';
    ?>

  </div>

</body>

</html>