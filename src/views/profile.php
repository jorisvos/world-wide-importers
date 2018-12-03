<div class="row">
    <div class="col-md-12">
        <?php
            $loggedInMess = '<h4>Welkom <strong>'.$_SESSION['user'].'</strong></h4>';
            print(($loggedInMess));
        ?>
    </div>
    <div class="col-md-12">
        <div class="card-deck">
            <div class="card">
                <a href="address.php">
                    <img class="card-img-top" src="img/image_not_found.png" alt="Card image cap">
                </a>
                <div class="card-body">
                    <h5 class="card-title">Mijn adresen</h5>
                    <p class="card-text">Wijzig hier de adressen die je hebt indegesteld in je account.</p>
                    <a href="address.php" class="btn btn-primary">Naar adressen</a>
                </div>
            </div>
            <div class="card">
                <a href="orders.php">
                    <img class="card-img-top" src="img/image_not_found.png" alt="Card image cap">
                </a>
                <div class="card-body">
                    <h5 class="card-title">Mijn orders</h5>
                    <p class="card-text">Hier vindt je alle informatie over je bestellingen.</p>
                    <a href="orders.php" class="btn btn-primary">Naar orders</a>
                </div>
            </div>
            <div class="card">
                <a href="my_settings.php">
                    <img class="card-img-top" src="img/image_not_found.png" alt="Card image cap">
                </a>
                <div class="card-body">
                    <h5 class="card-title">Account instellingen</h5>
                    <p class="card-text">Wijzig hier alle instellingen binnen je account.</p>
                    <a href="my_settings.php" class="btn btn-primary disabled" role="button" aria-disabled="true">Naar
                        instellingen</a>
                </div>
            </div>
        </div>
    </div>
</div>