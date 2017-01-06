<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>

    <body>
        <?php include ('navbar.php'); ?>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2>Show Movie Information</h2>
                    <br>
                    <h4>Movie Info:</h4>
                    <!-- TODO: insert back button -->
                    <div class="col-xs-12">
                        <table class="table table-striped">
                            <?php 
                                $db = new mysqli('localhost', 'cs143', '', 'CS143');
                                if($db->connect_errno > 0){
                                  die('Unable to connect to database [' . $db->connect_error . ']');
                                }
                            
                                $mid = $_GET['mid'];

                                if (isset($mid)) {
                                    echo "<tr><th>Title</th><th>Producer</th><th>Rating</th><th>Director</th><th>Genre</th><th>Release Year</th><th>Avg Rating</th></tr>";
                                    $rs = $db->query("SELECT * FROM Movie m WHERE m.id=$mid");
                                    $rs00 = $db->query("SELECT * FROM MovieGenre mg WHERE mg.mid=$mid");
                                    $rs3 = $db->query("SELECT avg(rating) avgRate FROM Review WHERE mid=$mid");

                                    while($row00 = $rs00->fetch_assoc()) {
                                        (strcmp($genre, $row00['genre'] . "/")) ? $genre .= $row00['genre'] . "/" : $genre = $row00['genre'];
                                    }
                                    $genre = trim($genre, "/");


                                    // director can be null - handle it
                                    $rs0 = $db->query("SELECT * FROM MovieDirector md WHERE md.mid=$mid"); 
                                    $did_array = array();
                                    while ($row0 = $rs0->fetch_assoc()) {
                                        array_push($did_array, $row0['did']);
                                    }

                                    $director_names = "";
                                    // Only look for the director info, if available
                                    // Multiple directors possible
                                    if (!is_null($did_array)) {
                                        foreach ($did_array as $did) {
                                            $rs1 = $db->query("SELECT * FROM Director d WHERE d.id=$did");
                                            while($row1 = $rs1->fetch_assoc()) {
                                                $first = $row1['first'];
                                                $last = $row1['last'];
                                                $fullName = $first . " " . $last;
                                                $director_names .= $fullName . "/";
                                            }
                                        }
                                    }
                                    $director_names = trim($director_names, "/");

                                    while($row = $rs->fetch_assoc()) {
                                        $title = $row['title'];
                                        $company = $row['company'];
                                        $rating = $row['rating'];
                                        $year = $row['year'];
                                    }

                                    while($row3 = $rs3->fetch_assoc()) {
                                        $avgRate = $row3['avgRate'];
                                    }

                                    echo "<tr><td>" . "<a href=\"show_movie.php?mid=$mid\">" . $title . "</a></td><td>" . $company . "</td><td>" . $rating . "</td><td>" . $director_names . "</td><td>" . $genre . "</td><td>" . $year . "</td><td>" . $avgRate . "</td></tr>";
                                }
                            ?>               
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <!-- User add comment -->
                    <div class="h4">
                        User Comments:
                        <small><a href="#"><span class="glyphicon glyphicon-plus" data-toggle="modal" data-target="#myModal" data-mid="<?php echo $_GET['mid']; ?>"></span></a></small>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">
                            <form method="GET" action="show_movie.php?mid=$mid">

                              <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">Add Comment for the Movie</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="newname">Your Name:</label>
                                        <input class="form-control" placeholder="Tony Stark" id="newname" type="text" name="newname"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="newrating">Your Rating (0-10):</label>
                                        <input class="form-control" id="newrating" type="number" name="newrating" min=0 max=10/>
                                    </div>
                                    <div class="form-group">
                                        <label for="newcomment">Comment to Add:</label>
                                        <input class="form-control" placeholder="This movie rocks!" id="newcomment" type="text" name="newcomment"/>
                                    </div>
                                    <input type="hidden" value="<?php echo htmlspecialchars($_GET['mid']); ?>" name="mid" />
                                </div>
                                <div class="modal-footer">
                                  <input type="submit" class="btn btn-primary" name="submit" value="submit" onclick="this.form.timeField.value=getTimeStamp()">
                                </div>
                              </div>
                            </form>
                            </div>
                        </div>
                    </div>
                                <?php
                                    if (isset($_GET['submit'])) {
                                        $name = $_GET['newname'];
                                        $comment = $_GET['newcomment'];
                                        $time = date('Y-m-d G:i:s'); // get current time
                                        $rating = $_GET['newrating'];

                                        echo "ADDING: $name, $time, $mid, $rating, comment";
                                        $db->query("INSERT INTO Review VALUE (\"$name\", \"$time\", $mid, $rating, \"$comment\")");
                                        $URL="show_movie.php?mid=$mid";
                                        echo '<META HTTP-EQUIV="content-type" content="0;URL=' . $URL . '">';
                                        echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
                                    }
                                ?>

                    <div class="col-xs-12">
                        <table class="table table-striped">
                            <?php
                                if (isset($mid)) {
                                    //$rs3->data_seek(0);
                                    $rs4 = $db->query("SELECT * FROM Review WHERE mid=$mid");

                                    while($row4 = $rs4->fetch_assoc()) {
                                        if (!empty($row4['comment'])) { //don't show anything if there's no comment
                                            echo "<tr><td><b>" . $row4['name'] . "</b> - \"" . $row4['comment'] . "\"</td></tr>";
                                        }
                                    }
                                }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h4>Actors in this Movie:</h4>
                    <div class="col-xs-8">
                        <table class="table table-striped">
                            <?php
                                if (isset($mid)) {
                                    echo "<tr><th>Actor Name</th><th>Role</th></tr>";
                                    $rs2 = $db->query("SELECT * FROM MovieActor ma, Actor a WHERE ma.mid=$mid AND ma.aid=a.id");
                                    while($row2 = $rs2->fetch_assoc()) {
                                        $aid = $row2['id'];
                                        echo "<tr><td>" . "<a href=\"show_actor.php?aid=$aid\">". $row2['first'] . " " . $row2['last'] . "</a></td><td>" . $row2['role'] . "</td></tr>";
                                    }
                                }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body> 
</html>