<div class="container">
    <div class="card">
        <div class="card-header">
            <?php echo nl2br($entry['blogtitle']); ?>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <?php echo nl2br($entry['blogcontent']); ?>
            </li>
            <li class="list-group-item">
                <?php echo "{$entry['dateofentry']} von {$entry['author']}"; ?>
            </li>
        </ul>
    </div>
    <br />

    <a href="index?page=<?php echo $_GET['page']; ?>" class="btn btn-primary">Zurück</a>

</div>

<?php include_once __DIR__ . "/../layout/footer.php"; ?>
