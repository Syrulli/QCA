<nav class="navbar navbar-expand-lg fixed-top" id="header">
  <div class="container">
    <a href="login.php" class="navbar-brand text-white">
     <img href="login.php" src="../img/logo.png" alt="">
    </a>
    <button class="navbar-toggler custom-toggler" style="border: none !important;" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" style="color:#fff !important;">
      </span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <?php
          if (isset($_SESSION['auth'])) {
            ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <?= $_SESSION['auth_user']['name']; ?>
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item text-black" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                </ul>
              </li>
            <?php
          } else {
          ?>
            <!-- <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
            </li> -->
          <?php
          }
        ?>
      </ul>
    </div>
  </div>
</nav>