<div class="container">
    <form method="get" action="index">
        <div class="form-inline">
            <select id="author" class="form-control mr-sm-2">
                <?php foreach($authors AS $author):?>
                    <option <?php if(isset($_GET['author'])){ if(($_GET['author']==$author)) echo "selected"; }?>><?php echo $author; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-outline-secondary my-sm-0">Suchen</button>
        </div>
    </form>
</div>