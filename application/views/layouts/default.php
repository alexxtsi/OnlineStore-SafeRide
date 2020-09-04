<? use application\controllers\CartController; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/SafeRideStore/public/styles/mycss.css?version=54">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" type="text/javascript"></script>
    </script>
    <title> <?php

            use application\components\Cart;

            echo $title; ?></title>

</head>
<header>
    <div class=" top-bar ">
        <div class="row">
            <div class="col-4">
                <a href="#" class="nav-link top-link"><span class="fa fa-phone"></span>
                    <span class="d-none d-md-inline-block">1+ (234) 5678 9101</span></a>
            </div>
            <div class="col-8">
                <ul class="nav justify-content-end mr-auto">

                    <li class="nav-item">
                        <?php if (Cart::checkLoged())
                            echo ' <a class="nav-link top-link" href="#" data-toggle="modal" data-target="#account"><i class="fas fa-user"></i> Account</a>';
                        else
                            echo ' <a class="nav-link top-link" href="#" data-toggle="modal" data-target="#logIn"><i class="fas fa-sign-in-alt"> </i> Log-In</a>';

                        ?>


                    </li>
                    <li class="nav-item">
                        <?php if (Cart::checkLoged())
                            echo '<a class="nav-link top-link" href="/SafeRideStore/cart">';
                        else
                            echo '<a class="nav-link top-link" href="#" onclick="cartClick()">';
                        ?>
                        <span class="fas fa-shopping-cart"></span>
                        Cart<span id="cartCount"> (<?= Cart::countItems(); ?>)</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg  navbar-drak main-nav">
        <a class="navbar-brand" href="/SafeRideStore"><img src="/SafeRideStore/public/images/MyLogo.jpg" alt="logo" height="100%" width="140"></a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/SafeRideStore">Home </a>
                </li>
                <li class="nav-item dropdown active ">
                    <a class="nav-link dropdown-toggle" href="SafeRideStore/products/helmets" id="dropdowHelmets" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Helmets</a>
                    <ul class="dropdown-menu dropHelmets pl-2 " aria-labelledby="dropdowHelmets">
                        <h6>Helmets</h6>
                        <div class="row">
                            <li class="col-3 ">
                                <a href="/SafeRideStore/products/full-face-helmets" title="FullFace">
                                    <img src="/SafeRideStore/public/images/Full-Face-Helmets.jpg" width="75" height="75">Full Face</a>
                            </li>
                            <li class="col-3">
                                <a href="/SafeRideStore/products/Helmets-Modular" title="Modular">
                                    <img src="/SafeRideStore/public/images/Helmets-Modular.jpg" width="75" height="75">Modular</a>
                            </li>
                            <li class="col-3">
                                <a href="#" title="Dual Sport">
                                    <img src="/SafeRideStore/public/images/Dual-Sport-Helmets.jpg" width="75" height="75">Dual Sport</a>
                            </li>
                            <li class="col-3">
                                <a href="#" title="Dirt">
                                    <img src="/SafeRideStore/public/images/Dirt-Helmets.jpg" width="75" height="75">Dirt Helmet</a li>
                        </div>
                        <div class="row">
                            <li class="col-3">
                                <a href="#" title="Half">
                                    <img src="/SafeRideStore/public/images/Half-Helmets.jpg" width="75" height="75">Half Helmet</a>
                            </li>
                            <li class="col-3">
                                <a href="#" title="Open Face">
                                    <img src="/SafeRideStore/public/images/Open-Face-Helmets.jpg" width="75" height="75">Open Face</a>
                            </li>
                            <li class="col-3">
                                <a href="#" title="Accessories">
                                    <img src=" /SafeRideStore/public/images/accessories.jpg" width="75" height="75">Accessories</a>
                            </li>
                            <li class="col-3 ">
                                <div class="">
                                    <a href="SafeRideStore/products/helmets" class="" title="all"> View All</a>
                                </div>
                            </li>

                        </div>

                    </ul>
                </li>
                <li class=" nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdowGear" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Riding Gear</a>
                    <ul class="dropdown-menu dropGear pl-2" aria-labelledby="dropdowGear">
                        <h6>Riding Gear</h6>
                        <div class="row">
                            <li class="col"><a href="index.html" title="home 1"><img src="logo_w3s.gif" width="50" height="50">Home 1</a></li>
                            <li class="col"><a href="home-2.html" title="home 2"><img src="logo_w3s.gif" width="50" height="50">Home 2</a></li>
                            <li class="col"><a href="home-3.html" title="home 3"><img src="logo_w3s.gif" width="50" height="50">Home 3</a></li>
                            <li class="col"><a href="home-4.html" title="home 4"><img src="logo_w3s.gif" width="50" height="50">Home 4</a></li>
                            <li class="col"><a href="home-4.html" title="home 4"><img src="logo_w3s.gif" width="50" height="50">Home 4</a></li>

                        </div>
                        <div class="row">
                            <li class="col"><a href="home-5.html" title="home 5"><img src="logo_w3s.gif" width="50" height="50">Home 5</a></li>
                            <li class="col"><a href="home-6.html" title="home 6"><img src="logo_w3s.gif" width="50" height="50">Home 6</a></li>
                            <li class="col"><a href="home-5.html" title="home 5"><img src="logo_w3s.gif" width="50" height="50">Home 5</a></li>
                            <li class="col"><a href="home-6.html" title="home 6"><img src="logo_w3s.gif" width="50" height="50">Home 6</a></li>
                            <li class="col"><a href="home-4.html" title="home 4"><img src="logo_w3s.gif" width="50" height="50">Home 4</a></li>

                        </div>

                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="#">Brands</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="#">Gear Guid</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="#">Contuct Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="/SafeRideStore/admin">admin</a>
                </li>
            </ul>
            <form class="form-inline">
                <input type="text" class="form-control h-75 mr-sm-2" placeholder="Search" aria-label="Search">
                <button class=" btn btn-search my-2 my-sm-0">Search</button>
            </form>
        </div>

    </nav>
    <?php
    require_once 'logInDialog.php';
    require_once 'accountDialog.php';
    ?>
</header>

<?= $content; ?>
<!-- Footer -->
<footer class="footer ">
    <div class="container">

        <ul class="list-unstyled list-inline text-center">
            <li class="list-inline-item">
                <a href="/SafeRideStore/" class="btn-floating btn-fb mx-1 top-link">
                    <i class="fab fa-facebook-f"> </i>
                </a>
            </li>
            <li class="list-inline-item">
                <a class="btn-floating btn-tw mx-1 top-link">
                    <i class="fab fa-twitter"> </i>
                </a>
            </li>
            <li class="list-inline-item">
                <a class="btn-floating btn-gplus mx-1 top-link">
                    <i class="fab fa-google-plus-g"> </i>
                </a>
            </li>
            <li class="list-inline-item">
                <a class="btn-floating btn-li mx-1 top-link">
                    <i class="fab fa-linkedin-in"> </i>
                </a>
            </li>
            <li class="list-inline-item">
                <a class="btn-floating btn-dribbble mx-1 top-link">
                    <i class="fab fa-dribbble"> </i>
                </a>
            </li>
        </ul>


    </div>
    <!-- Copyright -->
    <div class="footer-copyright text-center ">© 2020 Copyright:
        <a href="/SafeRideStore/" class="top-link"> SaferideStore.com</a>
    </div>
    <!-- Copyright -->

</footer>
<script>
    $(document).ready(function() {
        $(".addToCart").click(function() {
            var id = $(this).attr("data-id");
            var amount = document.getElementById("count").value;
            var size = getRadioValue();
            var element = document.getElementById("colors");
            var color = element.options[element.selectedIndex].text
            $.post("/SafeRideStore/cart/addAjax/" + color + "/" + size + "/" + amount + "/" + id, {}, function(data) {
                $("#cartCount").html(data);
            });

            return false;
        });
    });

    function getRadioValue() {
        var element = document.getElementsByName('sizes');
        for (i = 0; i < element.length; i++) {
            if (element[i].checked)
                return element[i].value;
        }
    }


    $(document).ready(function() {
        $(".minus").click(function() {
            var id = $(this).attr("data-id");
            console.log(document.getElementById("count" + id).value)
            if (document.getElementsByClassName("count")[0].value > 1) {
                this.parentNode.querySelector('input[type=number]').stepDown()

                $.post("/SafeRideStore/cart/decAjax/" + id, {}, function(data) {
                    $("#totalPrice").html(data);

                });
            }
            return false;
        });
    });

    $(document).ready(function() {
        $(".plus").click(function() {
            var id = $(this).attr("data-id");
            if (document.getElementById("count" + id).value < 99) {
                this.parentNode.querySelector('input[type=number]').stepUp()
                $.post("/SafeRideStore/cart/incAjax/" + id, {}, function(data) {
                    $("#totalPrice").html(data);
                });
                return false;
            }
        });

    });

    function cartClick() {
        window.alert('Plese log-in to view your cart');
    }
</script>
<?= debug($_COOKIE); ?>

</html>