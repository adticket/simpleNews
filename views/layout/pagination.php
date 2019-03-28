<div class="container">
    <ul class="pagination justify-content-center pagination-sm">
        <?php for($x=1; $x<=$numPages; $x++): ?>
            <li class="page-item <?php if(
                    (isset($_GET['page']) && $x == $_GET['page']) ||
                    (!isset($_GET['page']) && $x == 1)){
                    echo "active";
                } ?>">
                <?php if(isset($_GET['author'])): ?>
                <a class="page-link" href="?author=<?php echo $_GET['author']; ?>&page=<?php echo $x; ?>">
                    <?php echo $x; ?>
                </a>
                <?php else: ?>
                    <a class="page-link" href="?page=<?php echo $x; ?>">
                        <?php echo $x; ?>
                    </a>
                <?php endif; ?>
            </li>
        <?php endfor; ?>
    </ul>
</div>