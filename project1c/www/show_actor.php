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
                    <h2>Show Actor Information</h2>
                    <br>
                    <h4>Actor Info:</h4>
                    <!-- TODO: insert back button -->
                    <div class="col-xs-12">
                        <table class="table table-striped">
                            <?php 
                                $db = new mysqli('localhost', 'cs143', '', 'CS143');
                                if($db->connect_errno > 0){
                                  die('Unable to connect to database [' . $db->connect_error . ']');
                                }
                            
                                $aid = $_GET['aid'];

                                if (isset($aid)) {
                                    echo "<tr><th>Name</th><th>Sex</th><th>Date of Birth</th><th>Date of Death</th></tr>";
                                    $rs = $db->query("SELECT DISTINCT * FROM Actor a WHERE a.id=$aid");
                                    while($row = $rs->fetch_assoc()) {
                                        $sex = $row['sex'];
                                        $first = $row['first'];
                                        $last = $row['last'];
                                        $dob = $row['dob'];
                                        $dod = $row['dod'];
                                    }
                                    echo "<tr><td>" . "<a href=\"show_actor.php?aid=$aid\">" . $first . " " . $last . "</a></td><td>" . $sex . "</td><td>" . $dob . "</td><td>" . $dod . "</td></tr>";
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
                    <h4>Movies featured:</h4>
                    <div class="col-xs-8">
                        <table class="table table-striped">
                            <?php
                                if (isset($aid)) {
                                    echo "<tr><th>Movie Name</th><th>Role</th></tr>";
                                    $rs2 = $db->query("SELECT * FROM MovieActor ma, Movie m WHERE ma.aid=$aid AND ma.mid=m.id");
                                    while($row2 = $rs2->fetch_assoc()) {
                                        $mid = $row2['id'];
                                        echo "<tr><td>" . "<a href=\"show_movie.php?mid=$mid\">". $row2['title'] . "</a></td><td>" . $row2['role'] . "</td></tr>";
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