<html>
<head>
    <title>MyBlog</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
   <meta charset="UTF-8">
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
                <?php foreach($navigation as $item => $value): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $item; ?>"><?php echo $value;?></a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </nav>
</div>
<br />