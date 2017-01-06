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
                    <h2>Browse Actor Information</h2>
                    <form method = "GET" action="#">
                        <div class="form-group">
                            <label for="actorid" class="">Actor:</label>
                            <?php 
                                $db = new mysqli('localhost', 'cs143', '', 'CS143');
                                if($db->connect_errno > 0){
                                  die('Unable to connect to database [' . $db->connect_error . ']');
                                }
                            ?>
                            <select name="actorid">
                                <option disabled selected value> -- Select an Actor -- </option>
                                <?php
                                    $rs = $db->query('SELECT * FROM Actor');
                                    while($row = $rs->fetch_assoc()) {
                                        $key = $row['id'];
                                        $value = $row['first'] . " " . $row['last'] . " (" . $row['sex'] . "," . $row['dob']  .")";
                                        echo "<option ";?> <?php if ($_GET['actorid'] == $row['id']) { ?>selected="true" <?php }; ?> <?php echo "value=\"" . $key . "\">" . $value . "</option>";


                                        
                                    }
                                ?>
                            </select>
                            
                        </div>
                        <br>
                        <h6> Or, </h6>
                        <br>
                        <div class="form-group">
                            <label for="role">Actor/Actress Role:</label>
                            <input class="form-control" placeholder="i.e. pilot" id="role" type="text" name="role"/>
                        </div>

                        <!-- TODO: filter the movies by the actor selected currently -->
                        <!-- <div class="form-group">
                            <label for="movieid">Movie Title:</label>
                            <select name="movieid">
                                <?php 
                                    $db = new mysqli('localhost', 'cs143', '', 'CS143');
                                    if($db->connect_errno > 0){
                                      die('Unable to connect to database [' . $db->connect_error . ']');
                                    }
                                    $rs = $db->query('SELECT * FROM Movie');
                                    while($row = $rs->fetch_assoc()) {
                                          echo "<option value=\"" . $row['id'] . "\">" . $row['title'] . "</option>";
                                    }
                                ?>
                            </select>
                        </div> -->
                        <button type="submit" class="btn btn-primary" name="submit" value="submit">Browse</button>
                    </form>
                </div>
            </div>
            <br>
                <div class="col-xs-10">
                    <table class="table table-striped">
                        <?php
                            $actorid = $_GET['actorid'];
                            $role = $_GET['role'];

                            if (isset($_GET['submit'])) {
                                if (isset($actorid)) {
                                    echo "<tr><th>Actor Name</th><th>Featured Movie</th></tr>";
                                //TODO: allow query and use regexp to generalize the query
                                //TODO: turn the movie title into a link
                                    $rs = $db->query("SELECT * FROM Actor WHERE id=$actorid");
                                    while($row = $rs->fetch_assoc()) {
                                        $currAid = $row['id'];
                                        $rs2 = $db->query("SELECT * FROM MovieActor ma, Movie m WHERE ma.aid=$currAid AND ma.mid=m.id");
                                        //echo $row['id'];
                                        while($row2 = $rs2->fetch_assoc()) {
                                            $currmid = $row2['mid'];
                                            echo "<tr><td><a href=\"show_actor.php?aid=$actorid\">" . $row['first'] . " " . $row['last'] . "</a></td><td><a href=\"show_movie.php?mid=$currmid\">" . $row2['title'] . "</a></td></tr>";
                                        }
                                    }
                                } else if (isset($role)) {
                                    echo "<tr><th>Actor Name</th><th>Featured Movie</th><th>Role</th></tr>";
                                    $rs = $db->query("SELECT DISTINCT * FROM Actor a, MovieActor ma WHERE a.id=ma.aid AND ma.role LIKE '%pilot%'");
                                    while($row = $rs->fetch_assoc()) {
                                        $currMid = $row['mid'];
                                        $rs2 = $db->query("SELECT * FROM Movie m WHERE m.id=$currMid");
                                        //echo $row['id'];
                                        while($row2 = $rs2->fetch_assoc()) {
                                            echo "<tr><td>" . $row['first'] . " " . $row['last'] . "</td><td>" . $row2['title'] . "</td><td>" . $row['role']. "</td></tr>";
                                        }
                                    }
                                }
                            }
                        ?>               
                    </table>
                </div>
        </div>
    </body> 
</html>