<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>AV store</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/shop-homepage.css" rel="stylesheet">

</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/">AV Store</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/cart">Cart</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="row">
                <?php foreach ($products as $product): ?>
                    <div class="col-lg-4 col-md-6 mb-4 my-4">
                        <div class="card h-100">
                            <a href="#"><img class="card-img-top" src="<?php print $product->image ?>" alt=""></a>
                            <div class="card-body">
                                <h4 class="card-title">
                                    <a href="/product/<?php print $product->getId() ?>"><?php print $product->name ?></a>
                                </h4>
                                <h5><?php print $product->price ?> рублей</h5>
                                <p class="card-text"><?php print $product->description ?></p>
                            </div>
                            <div class="card-footer">
                                <form action="/product/<?php print $product->getId() ?>/add" method="post">
                                    <input name="csrf_token" value="<?php print csrf_token() ?>" type="hidden">
                                    <input name="add" type="submit" class="btn btn-success btn-lg" value="Add to cart">
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</div>
<footer class="py-3 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy;voicovalexandr@gmail.com</p>
    </div>
</footer>

<script src="/js/jquery.min.js"></script>
<script src="/js/bootstrap.bundle.min.js"></script>

</body>

</html>
