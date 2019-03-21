<?php

include "mysqlFunctions.php";

session_start();

$mysql = createMysqlConnection();


$myquery = $mysql->prepare("SELECT blogtitle, dateofentry, blogcontent, author FROM BlogEntries");
$myquery->execute();
$allresults = $myquery->get_result();
?>

<html>
<head>
    <title>MyBlog</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <meta charset="UTF-8">
</head>
<body>

<div class="container">
    <nav class="navbar navbar-expand navbar-dark bg-dark">
        <span class="navbar-brand mb-0 h1">Navigation</span>
        <div class="navbar-nav" id="navbarNav">
            <a class="nav-item nav-link active" href="index.php">Startseite</a>
            <?php
            if(isset($_SESSION['username'])) {
                echo '<a class="nav-item nav-link" href="author.php">Eintrag verfassen</a>';
                echo '<a class="nav-item nav-link" href="editor.php">Eintrag bearbeiten</a>';
            }
            if(!isset($_SESSION['username'])){
                echo '<a class="nav-item nav-link" href="login.php">Login</a>';
            } else {
                echo '<a class="nav-item nav-link" href="logout.php">Logout</a>';
            }
            ?>
        </div>
    </nav>
</div>

<p></p>

<div class="container">
    <h3>Alle Einträge
        <?php
            $filter = $_POST["author"];
            if($filter !== null && $filter !== "null") {
                echo 'von ' . $filter;
            }
        ?>
    </h3>
</div>

<p></p>

<div class="container">
    <form class="form-group" method="post" action="index.php">
        <label for="author"></label>
        <select name="author" id="author">
            <option value="null">Alle Autoren</option>
            <?php
                $myquery = "SELECT DISTINCT author FROM BlogEntries";
                $result = $mysql->query($myquery);
                if($result->num_rows > 0){
                    while($author = $result->fetch_assoc()){ ?>
                        <option value="<?php echo $author['author'] ?>"><?php echo $author['author'] ?></option><?php
                    }
                }
            ?>
        </select>
        <input type="submit" name="filter" value="Filtern">
    </form>
</div>

<p></p>

<?php
    if(!isset($_GET['limit'])) {
        $limit = 10;
        $page = 1;
    } else {
        $limit = $_GET['limit'];
        $page = $_GET['page'];
        $start = ($page - 1) * $limit;
    }
    if($filter == "null" || $filter == null) {
        $myquery = $mysql->prepare("SELECT blogtitle, dateofentry, blogcontent, author FROM BlogEntries ORDER BY dateofentry DESC LIMIT ? OFFSET ?");
        $myquery->bind_param("ss", $limit, $page);
    } else {
        $myquery = $mysql->prepare("SELECT blogtitle, dateofentry, blogcontent, author FROM BlogEntries WHERE author = ? ORDER BY dateofentry DESC  LIMIT ? OFFSET ?");
        $myquery->bind_param("sss", $filter, $limit, $page);
    }
    $myquery->execute();
    $result = $myquery->get_result();
?>


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
    if($result->num_rows>0){
        while($rows = $result->fetch_assoc()){
            echo '<div class="form-group"><b>' . $rows["blogtitle"] . '</b><br>' . $rows["blogcontent"] . '<br>' . $rows["dateofentry"] . "\tvon " . $rows["author"] . '</div>';
        }
    }
?>

</div>


</body>
</html>
