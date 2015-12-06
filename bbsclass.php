<?php
    session_start();
    $db = mysqli_connect('mysql105.phy.lolipop.lan','LAA0685945','nexseed');
    mysqli_select_db($db,'LAA0685945-onelinebbs');
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

  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="assets/css/form.css">
  <link rel="stylesheet" href="assets/css/timeline.css">
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/timeline2.css">
</head>
<body>

  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">

          <div class="navbar-header page-scroll">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#page-top"><span class="strong-title"><i class="fa fa-twitter-square"></i> Oneline bbs twitter</span></a>
          </div>
          
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
<!--                  <li class="hidden">
                      <a href="#page-top"></a>
                  </li>
                  <li class="page-scroll">
                      <a href="#portfolio">Portfolio</a>
                  </li>
                  <li class="page-scroll">
                      <a href="#about">About</a>
                  </li>
                  <li class="page-scroll">
                      <a href="#contact">Contact</a>
                  </li> -->
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-4 content-margin-top">
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

        <ul class="timeline">
          <li>
            <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>

            <div class="timeline-panel">
              <div class="timeline-heading">
                  <h4 class="timeline-title"><a href="#"><?php echo $post['nickname'] ?></a>
                   <span><?php echo $post['created'] ?></span>
                  </h4>
                    <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>
                      <?php echo $post['comment'] ?></small>
                    </p>
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

<?php
      //$dsn = 'mysql:dbname=phpkiso;host=localhost';
      //$user = 'root';
      //$password = '';

      //$dsn = 'mysql:dbname=LAA0685945-onelinebbs;host=mysql105.phy.lolipop.lan ';
      //$user = 'LAA0685945-onelinebbs';
      //$password = 'nexseed1204';
      //$dbh = new PDO($dsn,$user,$password);
      //$dbh->query('SET NAMES utf8')

?>






