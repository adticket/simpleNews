<?php

include "mysqlFunctions.php";
include "sessionvalidation.php";

session_start();

$mysql = createMysqlConnection();


$myquery = $mysql->prepare("SELECT * FROM BlogEntries WHERE author = ? ORDER BY dateofentry DESC");
$myquery->bind_param("s", $_SESSION['username']);
$result = $myquery->execute();
$allresults = $myquery->get_result();
?>

<html>
<head>
    <title>Einträge bearbeiten</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <meta charset="UTF-8">
</head>
<body>

<div class="container">
    <nav class="navbar navbar-expand navbar-dark bg-dark">
        <span class="navbar-brand mb-0 h1">Navigation</span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav" id="navbarNav">
            <ul class="navbar-nav">
                <a class="nav-item nav-link" href="index.php">Startseite</a>
                <?php
                if(isset($_SESSION['username'])) {
                    echo '<a class="nav-item nav-link" href="author.php">Eintrag verfassen</a>';
                    echo '<a class="nav-item nav-link active" href="editor.php">Eintrag bearbeiten</a>';
                }
                if(!isset($_SESSION['username'])){
                    echo '<a class="nav-item nav-link" href="login.php">Login</a>';
                } else {
                    echo '<a class="nav-item nav-link" href="logout.php">Logout</a>';
                }
                ?>
            </ul>
    </nav>
</div>

<?php
sessionValidation();
?>

<div class="container">
    <p><h1>Hallo <?php echo $_SESSION['username'] ?>!</h1></p>
</div>

<!-- Pagination -->
<div class="container">
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php
            if($allresults->num_rows>10){
                $num_pages = $allresults->num_rows/10;
                if($allresults->num_rows%10 > 0){
                    $num_pages++;
                }
                for($i = 1; $i <= $num_pages; $i++) {
                    echo "<li class='page-item'><a class='page-link' href='?limit=10&page=" . $i . "'>$i</a>";
                }
            }
            ?>
        </ul>
    </nav>
</div>

<div class="container">
        <?php
        if(!isset($_GET['limit'])) {
            $limit = 10;
            $page = 1;
            $start = 0;
        } else {
            $limit = $_GET['limit'];
            $page = $_GET['page'];
            $start = ($page - 1) * $limit;
        }

        $myquery = $mysql->prepare("SELECT * FROM BlogEntries WHERE author = ? ORDER BY dateofentry DESC LIMIT ? OFFSET ?");
        $myquery->bind_param("sss", $_SESSION['username'], $limit, $start);
        $result = $myquery->execute();
        $entries = $myquery->get_result();

        if($entries->num_rows > 0){
            echo "<h5>Anzahl deiner Einträge: " . $allresults->num_rows . "</h5>";

            while($entry = $entries->fetch_assoc()){
                echo    '<form method="post" action="editpage.php">
                            <div class="form-group">
                                <input type="text" class="form-control" id="entrytitle" name="entrytitle" size="50" value="'. $entry["blogtitle"] . '" required readonly> 
                            </div>
                            <div class="form-group">
                                <textarea type="comment" name="blogcontent" class="form-control" id="content" cols="50" rows="7" required readonly>' . $entry["blogcontent"] . '</textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" name="action" value="Eintrag bearbeiten">
                            </div>
                            <input type="hidden" name="entryID" value="' . $entry["entryID"] .'">
                        </form>';

            }
        } else {
            echo "Sie haben bisher noch keine Einträge erstellt, die Sie bearbeiten können!";
        }


    ?>
</div>

</body>
</html>
