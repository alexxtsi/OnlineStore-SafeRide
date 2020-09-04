<div class="modal fade" id="account" tabindex="-1" role="dialog" aria-labelledby="account" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title " id="account">Hello, <?= $_SESSION['fullName'] ?></h5>

                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <div class="container-fluid">
                    <div class="row m-2">
                        <a class="nav-link top-link" href="">
                            <span class="fas fa-user-edit"> </span> Edit Profile
                        </a>
                    </div>
                    <div class="row m-2">
                        <a class="nav-link top-link" href="/SafeRideStore/cart">
                            <span class="fas fa-shopping-cart"> </span> Go To Cart
                        </a>
                    </div>
                    <div class="row m-2">
                        <a class="nav-link top-link" href="/SafeRideStore/account/logout">
                            <span class="fas fa-sign-out-alt"> </span> Log-Out
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>