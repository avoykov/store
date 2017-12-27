<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>AV Store</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/shop-item.css" rel="stylesheet">

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/">AV store</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/cart">Cart</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <div class="offset-md-2 col-md-8">
            <div class="card my-4 card-outline-secondary">
                <img class="card-img-top img-fluid" src="/<?php print $product->image ?>" alt="">
                <div class="card-body">
                    <h3 class="card-title"><?php print $product->name ?></h3>
                    <h4><?php print $product->price ?> рублей</h4>
                    <p class="card-text"><?php print $product->description ?></p>
                    <form action="/product/<?php print $product->getId() ?>/add" method="post">
                        <input name="csrf_token" value="<?php print csrf_token() ?>" type="hidden">
                        <input name="add" type="submit" class="btn btn-success" value="Add to cart">
                    </form>
                </div>
            </div>

        </div>

    </div>

</div>
<!-- /.container -->

<!-- Footer -->
<footer class="py-2 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; voicovalexandr@gmail.com</p>
    </div>
    <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="/js/jquery.min.js"></script>
<script src="/js/bootstrap.bundle.min.js"></script>
</body>

</html>
