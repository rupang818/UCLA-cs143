<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2>Add a New Movie</h2>
                    <form method = "GET" action="#">
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input class="form-control" placeholder="Enter the title" id="title" type="text" name="title"/>
                        </div>
                        <div class="form-group">
                            <label for="year" class="">Release Year:</label>
                            <input class="form-control" placeholder="e.g. 2016" id="year" type="number" name="year" min="0" max="2016"/>
                        </div>

                        <div class="form-group">
                            <label for="rating">MPAA rating: </label>
                            <select name="rating">
                                <option value="G">G</option>
                                <option value="PG">PG</option>
                                <option value="PG-13">PG-13</option>
                                <option value="NC-17">NC-17</option>
                                <option value="R">R</option>
                                <option value="surrendere">surrendere</option>
                                <option value="Unrated">Unrated</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="company">Production company: </label>
                            <input class="form-control" id="company" name="company" type="text">
                        </div>

                        <div class="form-group">
                            <label for="genre_list[]">Genre: </label>
                            <br><small>
                                <label><input type="checkbox" name="genre_list[]" value="Thriller"> Thriller</label>
                                <label><input type="checkbox" name="genre_list[]" value="Action"> Action</label>
                                <label><input type="checkbox" name="genre_list[]" value="Adult"> Adult</label>
                                <label><input type="checkbox" name="genre_list[]" value="Romance"> Romance</label>
                                <label><input type="checkbox" name="genre_list[]" value="Romantic-Comedy"> Romantic-Comedy</label>
                                <label><input type="checkbox" name="genre_list[]" value="Drama"> Drama</label>
                                <label><input type="checkbox" name="genre_list[]" value="Comedy"> Comedy</label>
                                <label><input type="checkbox" name="genre_list[]" value="Crime"> Crime</label>
                                <label><input type="checkbox" name="genre_list[]" value="Horror"> Horror</label>
                                <label><input type="checkbox" name="genre_list[]" value="Mystery"> Mystery</label>
                                <label><input type="checkbox" name="genre_list[]" value="Adventure"> Adventure</label>
                                <label><input type="checkbox" name="genre_list[]" value="Documentary"> Documentary</label>
                                <label><input type="checkbox" name="genre_list[]" value="Family"> Family</label>
                                <label><input type="checkbox" name="genre_list[]" value="Sci-Fi"> Sci-Fi</label>
                                <label><input type="checkbox" name="genre_list[]" value="Animation"> Animation</label>
                                <label><input type="checkbox" name="genre_list[]" value="Musical"> Musical</label>
                                <label><input type="checkbox" name="genre_list[]" value="War"> War</label>
                                <label><input type="checkbox" name="genre_list[]" value="Western"> Western</label>
                                <label><input type="checkbox" name="genre_list[]" value="Short"> Short</label>
                                <label><input type="checkbox" name="genre_list[]" value="Foreign"> Foreign</label>
                            </small>
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

    // set variables
    $title = $_GET['title'];
    $year = $_GET['year'];
    $rating = $_GET['rating'];
    $company = $_GET['company'];
    $genre_list = $_GET['genre_list'];

    // TODO: error checking
    if (isset($title, $year, $rating, $company, $genre_list)) {
        $db = new mysqli('localhost', 'cs143', '', 'CS143');

        if($db->connect_errno > 0){
          die('Unable to connect to database [' . $db->connect_error . ']');
        }

        $rs = $db->query('SELECT id FROM MaxMovieID');

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
        $newMovieID = $maxID + 1;

        // Handle MaxMovie ID
        //TODO: uncomment the following lines
        $db->query("DELETE FROM MaxMovieID WHERE id=$maxID");
        $db->query("INSERT INTO MaxMovieID VALUES ($newMovieID)");

        // // Add movie to Movie & MovieGenre tables
        $db->query("INSERT INTO Movie VALUES ($newMovieID,\"$title\",\"$year\",\"$rating\",\"$company\")");
        // Handle multiple Genres
        foreach($genre_list as $selected){
            $db->query("INSERT INTO MovieGenre VALUES ($newMovieID,\"$selected\")");
            $genres .= $selected . "/";
        }
        $genres = trim($genres, "/");
        echo "Added the movie: $title, $year, $rating, $company, $genres";

        $rs->free();
        $db->close();
    }
?>
            </div>
        </div>

    </body> 
</html>