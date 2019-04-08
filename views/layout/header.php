<html>
<head>
    <title>simpleNews</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <meta charset="UTF-8">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


    <!-- FAVICON -->
    <link rel="icon" type="image/x-icon" sizes="32x32" href="favicon.ico">

</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <div class="navbar-brand mb-0">P-1.1</div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mynav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mynav">
            <ul class="navbar-nav mr-auto">
                <?php echo $navigation; ?>
            </ul>
            <form class="form-inline my-sm-0" method="get" action="search">
                <input class="form-control my-sm-0" name="search" type="search" placeholder="Suche" aria-label="Search">
                <button class="btn btn-secondary my-sm-0" type="submit">Suchen</button>
            </form>
        </div>
    </nav>
</div>
<br />