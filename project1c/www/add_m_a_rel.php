<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2>Add a New Movie/Actor Relation</h2>
                    <form method = "GET" action="#">
                        <div class="form-group">
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
                        </div>

                        <div class="form-group">
                            <label for="actorid" class="">Actor:</label>
                            <select name="actorid">
                                <?php 
                                    $db = new mysqli('localhost', 'cs143', '', 'CS143');
                                    if($db->connect_errno > 0){
                                      die('Unable to connect to database [' . $db->connect_error . ']');
                                    }
                                    $rs = $db->query('SELECT * FROM Actor');
                                    while($row = $rs->fetch_assoc()) {
                                        echo "<option value=" . $row['id'] . ">" . $row['first'] . " " . $row['last'] . " (" . $row['sex'] . "," . $row['dob']  .")</option>";
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="role">Role: </label>
                            <input class="form-control" id="role" name="role" type="text">
                        </div>

                        <button type="submit" class="btn btn-primary" value="Submit">Add Relation</button>
                    </form>
                </div>
            </div>
        </div>


        <div class="container">
            <div class="row">
<?php 
    include ('navbar.php');

    // set variables
    $movieid = $_GET['movieid'];
    $actorid = $_GET['actorid'];
    $role = $_GET['role'];

    // TODO: error checking
    if (isset($movieid, $actorid, $role)) {
        $db = new mysqli('localhost', 'cs143', '', 'CS143');

        if($db->connect_errno > 0){
          die('Unable to connect to database [' . $db->connect_error . ']');
        }

        // Add movie to Movie & MovieGenre tables
        $rs = $db->query("INSERT INTO MovieActor VALUES ($movieid,$actorid,\"$role\")");

        //Error handle
        if (!$rs) { 
            $errmsg = $db->error;
            print "Query failed: $errmsg <br />";
            exit(1);
        }

        echo "Added the movie/actor relation: movie=$movieid actor=$actorid for $role";

        $rs->free();
        $db->close();
    }
?>
            </div>
        </div>

    </body> 
</html>