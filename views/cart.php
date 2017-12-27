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
                <li class="nav-item active">
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
            Shopping cart
            <a href="/" class="btn btn-outline-info btn-sm pull-right">Continue shopping</a>
            <div class="clearfix"></div>
        </div>

        <div class="card-body">
            <?php foreach ($products as $product): ?>
                <div class="row">
                    <input name="products[<?php print $product->getId() ?>][id]"
                           value="<?php print $product->getId() ?>" type="hidden">
                    <div class="col-12 col-sm-12 col-md-2 text-center">
                        <img class="img-responsive" src="<?php print $product->image ?>" alt="prewiew" width="120"
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
                                <form action="/product/<?php print $product->getId() ?>/quantity" method="post">
                                    <input name="csrf_token" value="<?php print csrf_token() ?>" type="hidden">
                                    <input name="add" type="submit" value="+" class="plus">
                                    <input name="products[<?php print $product->getId() ?>][quantity]" type="textfield"
                                           value="<?php print $product->quantity ?>" title="Qty"
                                           readonly="readonly"
                                           class="qty" size="4">
                                    <input name="csrf_token" value="<?php print csrf_token() ?>" type="hidden">
                                    <input name="remove" type="submit" value="-" class="minus">
                                </form>
                            </div>
                        </div>
                        <div class="col-2 col-sm-2 col-md-2 text-right">
                            <form action="/product/<?php print $product->getId() ?>/remove" method="post">
                                <input name="csrf_token" value="<?php print csrf_token() ?>" type="hidden">
                                <button name="products[<?php print $product->getId() ?>][delete]" type="submit"
                                        class="btn btn-outline-danger btn-xs"
                                        value="1"
                                        onclick='this.form.submit();'>
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <hr>
            <?php endforeach; ?>
            <div class="row">
                <div class="col-md-10">
                    <?php if (!empty($bonus)): ?>
                        <h5>Discount from coupon - <strong><?php print $bonus ?>%</strong></h5>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-10">
                    <?php if ($amount > 2): ?>
                        <h5>Discount by amount of items - <strong>10%</strong></h5>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <?php if (count($products) > 0 && empty($bonus)): ?>
                <form action="/cart/bonus" method="post">
                    <input name="csrf_token" value="<?php print csrf_token() ?>" type="hidden">
                    <div class="coupon col-md-5 col-sm-5 no-padding-left pull-left">
                        <div class="row">
                            <div class="col-6">
                                <input required name="coupon_code" type="text" class="form-control"
                                       placeholder="Coupon code">
                            </div>
                            <div class="col-6">
                                <input name="submit_coupon" type="submit" class="btn btn-default" value="Use coupon">
                            </div>
                        </div>
                    </div>
                </form>
            <?php endif; ?>


            <div class="pull-right" style="margin: 10px">
                <form action="/cart/checkout" method="post">
                    <input name="csrf_token" value="<?php print csrf_token() ?>" type="hidden">
                    <input name="submit_checkout" type="submit" class="btn btn-success pull-right" value="Checkout">
                </form>
                <div class="pull-right" style="margin: 5px">
                    Total price: <b><?php print $price ?> рублей</b>
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
