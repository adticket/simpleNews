<?php

include "mysqlFunctions.php";

session_start();

$mysql = createMysqlConnection();

?>

<html>
<head>
    <title>MyBlog</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <meta charset="UTF-8">
</head>
<body>

<!-- Navigation -->
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

<!-- which entries are shown -->
<p><div class="container">
    <h3 align="center">Alle Einträge
        <?php
            if(isset($_GET["author"])) {
                $filter = $_GET["author"];
                if ($filter !== null && $filter !== "null") {
                    echo 'von ' . $filter;
                }
            }
        ?>
    </h3>
</div></p>

<div class="container">
    <div class="row">
        <div class="col">
<!-- author selection -->
<div class="d-flex justify-content-start">
    <form class="form-group" method="get">
        <div class="input-group mb-2">
        <div class="input-group-prepend">
            <input class="btn btn-primary" type="submit" value="Filtern">
        </div>
        <select class="costum-select" name="author" id="author" aria-labelledby="Example select with button addon">
            <option class="dropdown-item" value="null">Alle Autoren</option>
            <?php
                $myquery = "SELECT DISTINCT author FROM BlogEntries";
                $result = $mysql->query($myquery);
                if($result->num_rows > 0){
                    while($author = $result->fetch_assoc()){ ?>
                    <option class="dropdown-item" value="<?php echo $author['author'] ?>"><?php echo $author['author'] ?></option><?php
                    }
                }
            ?>
        </select>
        </div>
    </form>
</div>
        </div>
        <div class="col-6">
<!-- Pagination -->
<div class="d-flex justify-content-end">
<nav aria-label="Page navigation example">
    <ul class="pagination" >
        <?php
            if(isset($_GET['author']) && $_GET['author'] != 'null')
            {
                $entries = getEntriesByAuthor($mysql, $_GET['author']);
                $num_pages = $entries->num_rows/10;
                if($num_pages > 1) {
                    if ($entries->num_rows % 10 > 0) {
                        $num_pages++;
                    }
                    for ($i = 1; $i <= $num_pages; $i++) {
                        echo "<li class='page-item'><a class='page-link' href='?author=" . $_GET['author'] . "&limit=10&page=" . $i . "'>$i</a>";
                    }
                }
            } else {
                $entries = getEntries($mysql);
                $num_pages = $entries->num_rows/10;
                if($num_pages > 1) {
                    if ($entries->num_rows % 10 > 0) {
                        $num_pages++;
                    }
                    for ($i = 1; $i <= $num_pages; $i++) {
                        echo "<li class='page-item'><a class='page-link' href='?limit=10&page=" . $i . "'>$i</a>";
                    }
                }
            }
        ?>
    </ul>
</nav>
</div>
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
if(!isset($_GET['author'])){
    $filter= "null";
}
if ($filter == null || $filter == "null") {
        $myquery = $mysql->prepare("SELECT * FROM BlogEntries ORDER BY dateofentry DESC LIMIT ? OFFSET ?");
        $myquery->bind_param("ss", $limit, $start);
} else {
    $myquery = $mysql->prepare("SELECT * FROM BlogEntries WHERE author = ? ORDER BY dateofentry DESC LIMIT ? OFFSET ?");
    $myquery->bind_param("sss", $_GET['author'], $limit, $start);
}
$myquery->execute();
$filteredresult = $myquery->get_result();
?>
        </div>
    </div>
</div>

<!--Show filtered results-->
<div class="container">
    <ul class="list-group">
<?php
    if($filteredresult->num_rows>0){
        while($rows = $filteredresult->fetch_assoc()){
            echo '<li class="list-group-item"><h5><b>' . $rows["blogtitle"] . '</b></h5><p>' . nl2br($rows["blogcontent"]) . '</p>' . $rows["dateofentry"] . ' von <i>' . $rows["author"] . '</i></li>';
        }
    }
?>
    </ul>
</div>


</body>
</html>
