<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2>Add a New Movie/Director Relation</h2>
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
                            <label for="directorid" class="">Director:</label>
                            <select name="directorid">
                                <?php 
                                    $db = new mysqli('localhost', 'cs143', '', 'CS143');
                                    if($db->connect_errno > 0){
                                      die('Unable to connect to database [' . $db->connect_error . ']');
                                    }
                                    $rs = $db->query('SELECT * FROM Director');
                                    while($row = $rs->fetch_assoc()) {
                                        echo "<option value=" . $row['id'] . ">" . $row['first'] . " " . $row['last'] . " (" . $row['dob']  .")</option>";
                                    }
                                ?>
                            </select>
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
    $directorid = $_GET['directorid'];

    // TODO: error checking
    if (isset($movieid, $directorid)) {
        $db = new mysqli('localhost', 'cs143', '', 'CS143');

        if($db->connect_errno > 0){
          die('Unable to connect to database [' . $db->connect_error . ']');
        }

        // Add movie to Movie & MovieGenre tables
        $rs = $db->query("INSERT INTO MovieDirector VALUES ($movieid,$directorid)");

        //Error handle
        if (!$rs) { 
            $errmsg = $db->error;
            print "Query failed: $errmsg <br />";
            exit(1);
        }

        echo "Added the movie/director relation: movie=$movieid director=$directorid";

        $rs->free();
        $db->close();
    }
?>
            </div>
        </div>

    </body> 
</html>