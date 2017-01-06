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
                    <h2>Browse Movie Information</h2>
                    <form method = "GET" action="#">
                        <div class="form-group">
                            <label for="mid" class="">By Title:</label>
                            <?php 
                                $db = new mysqli('localhost', 'cs143', '', 'CS143');
                                if($db->connect_errno > 0){
                                  die('Unable to connect to database [' . $db->connect_error . ']');
                                }
                            ?>
                            <select name="mid">
                                <option disabled selected value> -- Select a Title -- </option>
                                <?php
                                    $rs = $db->query('SELECT * FROM Movie');
                                    while($row = $rs->fetch_assoc()) {
                                        $key = $row['id'];
                                        $value = $row['title'];
                                        echo "<option ";?> <?php if ($_GET['mid'] == $row['id']) { ?>selected="true" <?php }; ?> <?php echo "value=\"" . $key . "\">" . $value . "</option>";
                                    }
                                ?>
                            </select>
                            
                        </div>
                        <h6> Or, </h6>

                        <div class="form-group">
                            <label for="rating">MPAA rating: </label>
                            <select name="rating">
                                <option disabled selected value> -- Select the MPAA rating -- </option>
                                <option value="G">G</option>
                                <option value="PG">PG</option>
                                <option value="PG-13">PG-13</option>
                                <option value="NC-17">NC-17</option>
                                <option value="R">R</option>
                                <option value="surrendere">surrendere</option>
                                <option value="Unrated">Unrated</option>
                            </select>
                        </div>

                        <h6> Or, </h6>

                        <div class="form-group">
                            <label for="company" class="">By Production Company:</label>
                            <select name="company">
                                <option disabled selected value> -- Select the Production Company-- </option>
                                <?php
                                    //$rs->data_seek(0);
                                    $rs = $db->query('SELECT DISTINCT company FROM Movie');
                                    while($row = $rs->fetch_assoc()) {
                                        $value = $row['company'];
                                        echo "<option ";?> <?php if ($_GET['company'] == $row['company']) { ?>selected="true" <?php }; ?> <?php echo "value=\"" . $value . "\">" . $value . "</option>";
                                    }
                                ?>
                            </select>
                            
                        </div>

                        <button type="submit" class="btn btn-primary" name="submit" value="submit">Browse</button>
                    </form>
                </div>
            </div>
            <br>
            <div class="col-xs-10">
                <table class="table table-striped">
                    <?php
                        $mid = $_GET['mid'];
                        $rating = $_GET['rating'];
                        $company = $_GET['company'];

                        if (isset($_GET['submit'])) {
                            if (isset($mid)) {
                                // Go to the show movie page
                                $URL="show_movie.php?mid=$mid";
                                echo '<META HTTP-EQUIV="content-type" content="0;URL=' . $URL . '">';
                                echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
                            } else if (isset($rating)) {
                                echo "<tr><th>Title</th><th>Producing company</th><th>Rating</th></tr>";
                                $rs1 = $db->query("SELECT * FROM Movie WHERE rating=\"$rating\"");
                                while($row1 = $rs1->fetch_assoc()) {
                                    $mid = $row1['id'];
                                    $company = $row1['company'];
                                    echo "<tr><td>" . "<a href=\"show_movie.php?mid=$mid\">" . $row1['title'] . "</a></td><td>" . $company . "</td><td>" . $rating . "</td></tr>";
                                }
                            } else if (isset($company)) {
                                echo "<tr><th>Title</th><th>Producing company</th><th>Rating</th></tr>";
                                $rs1 = $db->query("SELECT * FROM Movie WHERE company=\"$company\"");
                                while($row1 = $rs1->fetch_assoc()) {
                                    $mid = $row1['id'];
                                    $rating = $row1['rating'];
                                    echo "<tr><td>" . "<a href=\"show_movie.php?mid=$mid\">" . $row1['title'] . "</a></td><td>" . $company . "</td><td>" . $rating . "</td></tr>";
                                }
                            } else {
                                echo "ERROR: maybe you are trying to mix and match? or not making any choices?";
                            }
                        }

                        $rs->free();
                        $db->close();
                    ?>               
                </table>
            </div>
        </div>
    </body> 
</html>