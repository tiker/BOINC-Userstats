<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
    <div class = "container">
        <a class="navbar-brand" href="./index.php">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo03">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link" href="<?php echo $hp_nav_link01; ?>" class="btn btn-neutral"><?php echo $hp_nav_name01; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $hp_nav_link02; ?>" class="btn btn-neutral"><?php echo $hp_nav_name02; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $hp_nav_link03; ?>" class="btn btn-neutral"><?php echo $hp_nav_name03; ?></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">weitere Links</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownId">
                        <a class="dropdown-item" href="https://www.timo-schneider.de">Timo Schneider</a>
                        <a class="dropdown-item" href="https://gedichte.timo-schneider.de">Gedichte</a>
                        <a class="dropdown-item" href="https://www.timo-schneider.de/boinc">XSmeagolX</a>
                        <a class="dropdown-item" href="https://ritterdeslichts.de">Ritter des Lichts</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="https://www.seti-germany.de">SETI.Germany</a>
                    </div>
                </li>
            </ul>
            <!--form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form-->
        </div>
    </div>
</nav>

    <!-- End Navbar -->
