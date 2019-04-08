<div class="container">
    <?php foreach ($entries AS $entry): ?>
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
                ?>&eid=<?php echo $entry['entryID'];
                if(isset($_GET['author']))
                {
                    echo '&author=' . $_GET['author'];
                }
                ?>"
               class="text-dark font-weight-bold">
                   <?php echo nl2br($entry['blogtitle']); ?>
            </a>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <?php echo $entry['shortContent']; ?>
            </li>
            <li class="list-group-item">
                <?php echo "{$entry['dateofentry']} von {$entry['author']}"; ?>
            </li>
        </ul>
    </div>
    <br />
    <?php endforeach; ?>
</div>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>
