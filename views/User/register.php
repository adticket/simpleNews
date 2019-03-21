<?php   include_once __DIR__ . "/../layout/header.php"; ?>

<div class="container"><h1>REGISTRIERUNG</h1></div>

<div class="container">
    <form method="post" action="register" class="form-horizontal">
        <div class="form-group">
            <label class="control-label">
                Vorname:
            </label>
            <input type="text" name="firstname" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="control-label">
                Nachname:
            </label>
            <input type="text" name="surname" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="control-label">
                Benutzername:
            </label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="control-label">
                E-Mail-Adresse:
            </label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="control-label">
                Passwort:
            </label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="control-label">
                Passwort:
            </label>
            <input type="password" name="password2" class="form-control" required>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Registrieren" />
        </div>
    </form>
</div>


<?php include_once __DIR__ . "/../layout/footer.php"; ?>
