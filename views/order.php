<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>AV Store</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/cart.css" rel="stylesheet">

</head>

<body>

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


<div class="container">
    <div class="card shopping-cart">
        <?php if (session()->has('errors')): ?>
            <?php foreach (session()->getErrors() as $error): ?>
                <div class="alert alert-danger" role="alert">
                    <?php print $error ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="card-header bg-dark text-light">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            Order
        </div>

        <div class="card-body">
            <?php foreach ($order->products as $product): ?>
                <div class="row">
                    <input name="products[<?php print $product->getId() ?>][id]"
                           value="<?php print $product->getId() ?>" type="hidden">
                    <div class="col-12 col-sm-12 col-md-2 text-center">
                        <img class="img-responsive" src="<?php print $product->image ?>" alt="preview" width="120"
                             height="80">
                    </div>
                    <div class="col-12 text-sm-center col-sm-12 text-md-left col-md-6">
                        <h4 class="product-name"><strong><?php print $product->name ?></strong></h4>
                        <h4>
                            <small><?php print $product->description ?></small>
                        </h4>
                    </div>
                    <div class="col-12 col-sm-12 text-sm-center col-md-4 text-md-right row">
                        <div class="col-3 col-sm-3 col-md-6 text-md-right" style="padding-top: 5px">
                            <h6><strong><?php print $product->price ?> <span class="text-muted">x</span></strong>
                            </h6>
                        </div>
                        <div class="col-4 col-sm-4 col-md-4">
                            <div class="quantity">
                                <input name="products[<?php print $product->getId() ?>][quantity]" type="textfield"
                                       value="<?php print $product->quantity ?>" title="Qty"
                                       readonly="readonly"
                                       class="qty" size="4">
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            <?php endforeach; ?>
            <div class="row">
                <div class="col-md-10">
                    <?php if (!empty($order->bonus)): ?>
                        <h5>Discount from coupon - <strong><?php print $order->bonus->discount ?>%</strong></h5>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-10">
                    <?php if ($order->amount > 2): ?>
                        <h5>Discount by amount of items - <strong>10%</strong></h5>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-md-3 offset-md-9">
                    <div class="pull-right" style="margin: 5px">
                        Total price: <b><?php print $order->price ?> рублей</b>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="py-2 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; voicovalexandr@gmail.com</p>
    </div>
</footer>

<script src="/js/jquery.min.js"></script>
<script src="/js/bootstrap.bundle.min.js"></script>
<script src="https://use.fontawesome.com/c560c025cf.js"></script>
</body>

</html>
