<!DOCTYPE html>
<html lang="en">
<head>
    <title>AV store</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        /* Remove the navbar's default margin-bottom and rounded borders */
        .navbar {
            border-radius: 0;
        }

        /* Add a gray background color and some padding to the footer */
        .footer {
            background-color: #f2f2f2;
            padding: 25px;
        }

    </style>
</head>
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">AV store</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/">Home</a></li>
                <li><a href="/contact">Contact</a></li>
                <li><a href="/about">About</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><span class="glyphicon glyphicon-shopping-cart"></span> Shoping</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container text-center">
    <h3>Items</h3><br>
    <div class="row">
        <div class="col-sm-4">
            <img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image">
            <p>Item 1</p>
        </div>
        <div class="col-sm-4">
            <img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image">
            <p>Item 2</p>
        </div>

        <div class="col-sm-4">
            <img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image">
            <p>Item 3</p>
        </div>
    </div>
</div>
<br>

<div class="footer navbar-fixed-bottom">
    <div class="container-fluid">
        <ul class="nav navbar-nav navbar-right">
            <li>(C) voicovalexandr@gmail.com</li>
        </ul>
    </div>
</div>

</body>
</html>
