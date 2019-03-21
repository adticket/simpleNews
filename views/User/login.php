<?php   include_once __DIR__ . "/../layout/header.php"; ?>

<div class="container">
    <form method="post" action="login" class="form-horizontal">
        <div class="form-group">
            <label class="control-label">
                Benutzername oder E-Mail-Adresse:
            </label>
            <input type="text" name="login" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="control-label">
                Passwort:
            </label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Einloggen" />
            <a href="register" class="btn btn-dark">Registrieren</a>
        </div>
    </form>
</div>


<?php include_once __DIR__ . "/../layout/footer.php"; ?>
