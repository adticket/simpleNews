<?php
/**
 * Created by PhpStorm.
 * User: chrischan
 * Date: 25.03.19
 * Time: 09:36
 */

/* Assoziatives Array: index + Value ausgeben
$navigation = [
  'dashboard' => 'Dashboard',
  'login' => 'Login',
  'index' => 'Startseite',
  'logout' => 'Logout'
];

foreach ($navigation AS $key => $nav)
{
    echo $key . " " . $nav . "<br />";
}

function test()
{
    for($x = 0; $x < 10; $x++)
    {
        var_dump("generator: " . $x);
        yield $x * 2 => $x;
    }
}

foreach (test() as $key => $item) {
    var_dump("foreach: " . $key . ":" . $item);
}
*/
/* Primzahlen
for($x = 0; $x < 20; $x++)
{
    $prim = true;

    for($y = 1; $y <= $x; $y++)
    {
        if((($x%$y) == 0) && ($y!=1) && ($x!=$y))
        {
            $prim = false;
            break;
        }
    }

    if($prim && ($x>1))
    {
        echo $x;
    }
}
*/

$navigation = [
    'index' => 'Startseite',
    'dashboard' => 'Dashboard',
    'logout' => 'Logout'
];

/*
    function allSortedByDate()
    {
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->query("SELECT * FROM {$table} ORDER BY dateofentry DESC");
        $entries = $stmt->fetchAll(PDO::FETCH_CLASS, $model);

        return $entries;
    }
    */
/*
    function findByAuthor($author)
    {
        $table = $this->getTableName();
        $model = $this->getModelName();
        $stmt = $this->pdo->prepare("SELECT * FROM {$table} WHERE author = :author ORDER BY dateofentry DESC ");
        $stmt->execute(['author' => $author]);
        $entries = $stmt->fetchAll(PDO::FETCH_CLASS, $model);

        return $entries;
    }
    */
/*
    function calculatePagination(array $entries, $limitPerPage)
    {
        $numPages = 0;
        if(count($entries)>$limitPerPage)
        {
            $numPages = count($entries)/$limitPerPage;
            if((count($entries)%$limitPerPage)>0)
            {
                $numPages++;
            }
        }
        return $numPages;
    }
    *
    function getPartOfArray(array $entries, $limitPerPage)
    {
        if(isset($_GET['page'])){
            $entries = array_slice($entries, ($_GET['page']-1)*$limitPerPage, $limitPerPage);
        }
        else
        {
            $entries = array_slice($entries, 0, $limitPerPage);
        }
        return $entries;
    }
    */

?>

<!-- AJAX -->
<div id="hallo">
    <h2>
        Let the body hit the floor!
    </h2>
</div>
<div id="change">
    This div is gonna get changed!
</div>
<button type="button" onclick="loadDoc()">Button of Change</button>
<script>
    function loadDoc() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('change').innerHTML = this.statusText;
            }
        };
        xhttp.open("GET", "hallo.txt", true);
        xhttp.send();
    }
</script>