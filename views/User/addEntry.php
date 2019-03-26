<div class="container">
    <form method="post" action="index">
        <div class="form-group">
            <label for="entrytitle">Schlagzeile</label>
            <input type="text" class="form-control" id="entrytitle" name="entrytitle" size="50" required>
        </div>
        <div class="form-group">
            <label for="content">Artikel</label>
            <textarea type="comment" name="blogcontent" class="form-control" id="content" cols="50" rows="7" required></textarea>
        </div>
        <div class="form-group">
            <input type="submit" value="Eintrag erstellen" class="btn btn-primary">
        </div>
    </form>
</div>

<?php include_once __DIR__ . "/../layout/footer.php"; ?>