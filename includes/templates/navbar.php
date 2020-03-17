<!-- ############ navbar file ############ -->
<nav class="navbar navbar-expand-lg navbar-light">
<div class="container">
  <a class="navbar-brand" href="dashboard.php"><?php echo lang('title')?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    <div class="left_nav">
      <li class="nav-item">
        <a class="nav-link" href="dashboard.php"><?php echo lang("HomeTitle")?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="members.php">Members</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="categories.php?do=Mange">Categories</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">products</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">logs</a>
      </li>
    </div>
      <!-- <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form> -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <!-- <php echo $_SESSION['username'] ?> -->
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="members.php?do=Edit&userID=<?php echo $_SESSION['userID'];?>">Edit Profil</a>
          <a class="dropdown-item" href="members.php?do=Add">Add</a>
          <a class="dropdown-item" href="members.php?do=Delete">Delete</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php">Logout</a>
        </div>
      </li>
    </ul>    
  </div>
  </div>
</nav>