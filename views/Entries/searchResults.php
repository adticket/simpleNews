<div class="container h4">
    Suchergebnisse für: <?php echo $searchQuery; ?>
</div>

<div class="container">
    <?php foreach ($searchResults AS $searchResult): ?>
        <div class="card">
            <div class="card-header">
                <a href="entry?page=<?php if(isset($_GET['page']))
                {
                    echo $_GET['page'];
                }
                else
                {
                    echo 1;
                }
                ?>&eid=<?php echo $searchResult['entryID'];
                if(isset($_GET['author']))
                {
                    echo '&author=' . $_GET['author'];
                }
                ?>"
                   class="text-dark font-weight-bold">
                    <?php echo nl2br($searchResult['blogtitle']); ?>
                </a>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <?php echo $searchResult['shortContent']; ?>
                </li>
                <li class="list-group-item">
                    <?php echo "{$searchResult['dateofentry']} von {$searchResult['author']}"; ?>
                </li>
            </ul>
        </div>
        <br />
    <?php endforeach; ?>
</div>



<?php include_once __DIR__ . '/../layout/footer.php'; ?>
