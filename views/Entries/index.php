<?php   include_once __DIR__ . "/../layout/header.php"; ?>

<?php //var_dump();?>

<div class="container">
    <?php foreach ($entries AS $entry): ?>
    <div class="card">
        <div class="card-header">
            <a href="entry?eid=<?php echo $entry['entryID']; ?>" class="text-dark font-weight-bold">
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

<?php include_once __DIR__ . "/../layout/footer.php"; ?>
