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
    <link href="/css/checkout.css" rel="stylesheet">

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
<div class="container py-4">
    <?php if (session()->has('errors')): ?>
        <?php foreach (session()->getErrors() as $error): ?>
            <div class="alert alert-danger" role="alert">
                <?php print $error ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <form action="checkout/save" method="post">
        <input name="csrf_token" value="<?php print csrf_token() ?>" type="hidden">
        <div class="form-group row">
            <label for="name" class="col-2 col-form-label">Name</label>
            <div class="col-10">
                <input name="name" class="form-control" type="text" placeholder="Voicov Alexandr" id="name">
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-2 col-form-label">Email</label>
            <div class="col-10">
                <input name="email" class="form-control" type="email" placeholder="bootstrap@example.com" id="email">
            </div>
        </div>
        <div class="form-group row">
            <label for="card_number" class="col-2 col-form-label">Card number</label>
            <div class="col-10">
                <input name="card_number" class="form-control" size="16" maxlength="16" type="textfield"
                       placeholder="1111 1111 1111 1111"
                       id="card_number">
            </div>
        </div>
        <div class="form-group row">
            <label for="cvv" class="col-2 col-form-label">CVV</label>
            <div class="col-10">
                <input name="cvv" class="form-control" type="textfield" size="4" maxlength="4" placeholder="0000"
                       id="cvv">
            </div>
        </div>

        <div class="form-group row">
            <label for="phone" class="col-2 col-form-label">Telephone</label>
            <div class="col-10">
                <input name="phone" class="form-control" type="tel" placeholder="1-(555)-555-5555" id="phone">
            </div>
        </div>
        <button type="submit" class="btn btn-primary pull-right">Make order</button>
    </form>
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
