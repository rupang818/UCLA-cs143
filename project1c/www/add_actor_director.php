<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2>Add a New Actor or a Director</h2>
                    <form method = "GET" action="#">
                        <label class="radio-inline">
                            <input type="radio" checked="checked" name="job" value="Actor"/>Actor
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="job" value="Director"/>Director
                        </label>

                        <div class="form-group">
                            <label for="lastname">Last Name:</label>
                            <input class="form-control" placeholder="Enter the last name" id="lastname" type="text" name="lname"/>
                        </div>
                        <div class="form-group">
                            <label for="firstname">First Name:</label>
                            <input class="form-control" placeholder="Enter the first name" id="firstname" type="text" name="fname"/>
                        </div>

                        <label class="radio-inline">
                            <input type="radio" checked="checked" name="sex" value="Male"/>Male
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="sex" value="Female"/>Female
                        </label>

                        <div class="form-group">
                            <label for="dob">Date of birth:</label>
                            <input class="form-control" id="dob" name="dob" type="date">
                        </div>
                        <div class="form-group">
                            <label for="dod">Date of death <small>(leave blank, if alive)</small>:</label>
                            <input class="form-control" id="dod" name="dod" type="date">
                        </div>

                        <button type="submit" class="btn btn-primary" value="Submit">Add</button>
                    </form>
                </div>
            </div>
        </div>


        <div class="container">
            <div class="row">
<?php 
    include ('navbar.php');

    // TODO: error checking
    // set variables
    $job = $_GET['job'];
    $last = $_GET['lname'];
    $first = $_GET['fname'];
    $sex = $_GET['sex'];
    $dob = $_GET['dob'];
    (isset($_GET['dod'])) ? $dod = $_GET['dod'] : $dod ='';

    if (isset($job, $last, $first, $sex, $dob, $dod)) {
        $db = new mysqli('localhost', 'cs143', '', 'CS143');

        if($db->connect_errno > 0){
          die('Unable to connect to database [' . $db->connect_error . ']');
        }

        // 1. Get the current maxpersonID
        // 2. DELETE the existing maxpersonID and increment
        // 3. Insert the incremented id back to the table
        $rs = $db->query('SELECT id FROM MaxPersonID');

        //Error handle
        if (!$rs) { 
            $errmsg = $db->error;
            print "Query failed: $errmsg <br />";
            exit(1);
        }


        while($row = $rs->fetch_row()) {
            foreach ($row as $rowField) {
              $maxID = $rowField;
            }
        }
        $newPersonID = $maxID + 1;

        $db->query("DELETE FROM MaxPersonID WHERE id=$maxID");
        $db->query("INSERT INTO MaxPersonID VALUES ($newPersonID)");
        
        // Empty dod IS 0000-00-00
        if ($job == "Actor") {
            $db->query("INSERT INTO Actor VALUES ($newPersonID,\"$last\",\"$first\",\"$sex\",\"$dob\",\"$dod\")");
        } else {
            $db->query("INSERT INTO Director VALUES ($newPersonID,\"$last\",\"$first\",\"$dob\",\"$dod\")");
        }
        echo "Added the $job: $first $last, $sex, $dob, $dod";

        $rs->free();
        $db->close();
        
    }
?>
            </div>
        </div>

    </body> 
</html>