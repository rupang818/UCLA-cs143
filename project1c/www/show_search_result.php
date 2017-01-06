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
                    <h2>Search Results</h2>
                    <br>
                    <div class="col-xs-12">
                        <h4>Matching Actors/Actresses:</h4>
                        <table class="table table-striped">
                            <?php
                                $db = new mysqli('localhost', 'cs143', '', 'CS143');
                                if($db->connect_errno > 0){
                                  die('Unable to connect to database [' . $db->connect_error . ']');
                                }
                                $kw = urldecode($kw);

                                $keywords = preg_split('/\s+/', $kw);
                                $q = "SELECT DISTINCT a1.last, a1.first, a1.sex, a1.dob, a1.dod, a1.id  FROM Actor a1 INNER JOIN Actor a2 ON a1.id=a2.id WHERE "; 
                                foreach ($keywords as $keyword) {
                                    $keyword = mysqli_real_escape_string($db, $keyword);
                                    $q .= "(a2.first LIKE '%$keyword%' OR a2.last LIKE '%$keyword%')" . " AND ";
                                }
                                $q = trim($q, " AND ");

                                //echo "QUERY: $q";
                                $rs=$db->query($q);

                                if (mysqli_num_rows($rs) == 0) {
                                    echo "No match!";
                                } else {
                                    echo "<tr><th>Name</th><th>Sex</th><th>Date of Birth</th><th>Date of Death</th></tr>";
                                    while($row = $rs->fetch_assoc()) {
                                        $aid = $row['id'];
                                        $first = $row['first'];
                                        $last = $row['last'];
                                        $sex = $row['sex'];
                                        $dob = $row['dob'];
                                        $dod = $row['dod'];
                                        echo "<tr><td>" . "<a href=\"show_actor.php?aid=$aid\">" . $first . " " . $last . "</a></td><td>" . $sex . "</td><td>" . $dob . "</td><td>" . $dod . "</td></tr>";
                                    }
                                }
                            ?>               
                        </table>

                        <h4>Matching Movies:</h4>
                        <table class="table table-striped">
                            <?php
                                $db = new mysqli('localhost', 'cs143', '', 'CS143');
                                if($db->connect_errno > 0){
                                  die('Unable to connect to database [' . $db->connect_error . ']');
                                }
                                
                                $keywords = preg_split('/\s+/', $kw);
                                $q = "SELECT DISTINCT m1.title, m1.year, m1.rating, m1.company, m1.id FROM Movie m1 INNER JOIN Movie m2 ON m1.id=m2.id WHERE "; 
                                foreach ($keywords as $keyword) {
                                    $keyword = mysqli_real_escape_string($db, $keyword);
                                    $q .= "m2.title LIKE '%$keyword%'" . " AND ";
                                }
                                $q = trim($q, " AND ");

                                //echo "QUERY: $q";

                                $rs=$db->query("$q");
                                if (mysqli_num_rows($rs) == 0) {
                                    echo "No match!";
                                } else {
                                    echo "<tr><th>Title</th><th>Release Year</th><th>MPAA Rating</th><th>Production Company</th></tr>";
                                    while($row = $rs->fetch_assoc()) {
                                        $mid = $row['id'];
                                        $title = $row['title'];
                                        $year = $row['year'];
                                        $rating = $row['rating'];
                                        $company = $row['company'];
                                        echo "<tr><td>" . "<a href=\"show_movie.php?mid=$mid\">" . $title . "</a></td><td>" . $year . "</td><td>" . $rating . "</td><td>" . $company . "</td></tr>";
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