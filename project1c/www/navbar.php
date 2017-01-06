<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title> Jihoon's Movie Database </title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">

        <!-- Custom theme -->
        <link rel="stylesheet" href="css/custom.css">
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="home.php"><small>Jihoon's Movie DB</small></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li class="active"><a href="home.php">Home <span class="sr-only">(current)</span></a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Browse <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="browse_actor.php">Actor information</a></li>
                    <li><a href="browse_movie.php">Movie information</a></li>
                  </ul>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Add <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="add_actor_director.php">Actor/Director</a></li>
                    <li><a href="add_movie.php">Movie info</a></li>
                    <li><a href="add_m_a_rel.php">Movie/Actor Relation</a></li>
                    <li><a href="add_m_d_rel.php">Movie/Director Relation</a></li>
                  </ul>
                </li>
              </ul>
              <form class="navbar-form navbar-right">
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Search" id="keyword" name="keyword">
                </div>
                <button type="submit" class="btn btn-default" value="submit" name="searchsubmit">Submit</button>
              </form>
            </div><!-- /.navbar-collapse -->
            </div><!-- /.container -->
        </nav>

        <?php
          $kw = $_GET['keyword'];
          if (isset($_GET['searchsubmit'])) {
            $URL="show_search_result.php?keyword=" . urlencode($kw);
            echo '<META HTTP-EQUIV="content-type" content="0;URL=' . $URL . '">';
            echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
          }
        ?>

        <!-- Jquery needs to be above Javascript-->
        <script src="js/jquery.min.js"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>