<?php   include_once __DIR__ . "/../layout/header.php"; ?>

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
</div>

<?php include_once __DIR__ . "/../layout/footer.php"; ?>
