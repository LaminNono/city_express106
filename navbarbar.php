<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
    
        <?php  if(!isset($_SESSION['loginSuccess'])&& !isset($_SESSION['adminEmail'])) {?>
          <li class="nav-item">
          <a class="nav-link active" href="signup.php" tabindex="-1" >Sign Up</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="login.php" tabindex="-1" aria-disabled="true">login</a>
        </li>
      <?php } else {


      ?>
        <li class="nav-item">
          <a class="nav-link active" href="logout.php" tabindex="-1" aria-disabled="true">Log Out</a>
        </li>
        <?php  echo "<li class=nav-item><a class=nav-link text-bg-dark> $_SESSION[adminEmail]</a> </li>";  } ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
            

          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disable</a>
        </li>
      
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" name="kSearch"type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-primary" name = "bSearch"type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>