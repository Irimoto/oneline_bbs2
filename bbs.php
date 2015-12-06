<?php
    session_start();
    $db = mysqli_connect('localhost','root','');
    mysqli_select_db($db,'oneline_bbs');
    mysqli_set_charset($db,'utf8');

?>
<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $nickname = mysqli_real_escape_string($db,$_POST['nickname']);
      $comment = mysqli_real_escape_string($db,$_POST['comment']);

      $sql = sprintf('INSERT INTO posts SET nickname="%s", comment="%s", created=NOW()',
            $nickname,
            $comment
      );

      $_SESSION["nickname"] = $nickname;

      mysqli_query($db,$sql);
      header('Location: bbs.php');
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>セブ掲示版</title>

  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="assets/css/form.css">
  <link rel="stylesheet" href="assets/css/timeline2.css">
  <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>

  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
          <div class="navbar-header page-scroll">
              <a class="navbar-brand" href="#page-top"><span class="strong-title"><i class="fa fa-twitter-square"></i> Oneline bbs Twiiter</span></a>
          </div>
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          </div>
      </div>
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-12 content-margin-top">
        <form action="bbs.php" method="post">
          <div class="form-group">
            <div class="input-group">
              <?php // echo '<input type="text" name="nickname" class="form-control" id="validate-text" placeholder="nickname" value="' . $_SESSION["nickname"] . '" required>'  ?>
              
              <?php 
                  if (isset($_SESSION["nickname"])) {
                      echo sprintf('<input type="text" name="nickname" class="form-control"
                       id="validate-text" placeholder="nickname" value="%s" required>',
                          $_SESSION["nickname"]
                      );
                  } else {
                      echo '<input type="text" name="nickname" class="form-control"
                       id="validate-text" placeholder="nickname" required>';
                  }
              ?>

              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
            
          </div>

          <div class="form-group">
            <div class="input-group" data-validate="length" data-length="4">
              <textarea type="text" class="form-control" name="comment" id="validate-length" placeholder="comment" required></textarea>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
          </div>

          <button type="submit" class="btn btn-primary col-xs-12" disabled>つぶやく</button>
        </form>
      </div>

      <div class="col-md-12 content-margin-top">
        <?php
            // データの取得と表示
            $sql = 'SELECT * FROM posts ORDER BY `created` DESC';
            $posts = mysqli_query($db,$sql) or die(mysqli_error($db));
        ?>

        <div class="timeline-centered">

        <?php while ($post = mysqli_fetch_assoc($posts)): ?>

        <article class="timeline-entry">

            <div class="timeline-entry-inner">

                <div class="timeline-icon bg-success">
                    <i class="entypo-feather"></i>
                    <i class="fa fa-cogs"></i>
                </div>

                <div class="timeline-label">
                    <h2><a href="#"><?php echo $post['nickname'] ?></a> <span><?php echo $post['created'] ?></span></h2>
                    <p><?php echo $post['comment'] ?></p>
                </div>
            </div>

        </article>
        <?php endwhile; ?>

        <article class="timeline-entry begin">

            <div class="timeline-entry-inner">

                <div class="timeline-icon" style="-webkit-transform: rotate(-90deg); -moz-transform: rotate(-90deg);">
                    <i class="entypo-flight"></i> +
                </div>

            </div>

        </article>

      </div>

    </div>
  </div>





  
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/form.js"></script>
</body>
</html>



