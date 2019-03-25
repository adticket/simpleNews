<html>
<head>
    <title>MyBlog</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <meta charset="UTF-8">
</head>
<body>

<div class="container">
    <nav class="navbar navbar-expand navbar-dark bg-dark">
        <div class="navbar-header">
            <span class="navbar-brand mb-0 h1">PP-1.1</span>
        </div>
        <div class="navbar-nav" id="navbarNav">
            <?php foreach($navigation as $item => $value): ?>
            <a class="nav-item nav-link" href="<?php echo $item; ?>"><?php echo $value;?></a>
            <?php endforeach; ?>
        </div>
    </nav>
</div>
<br />