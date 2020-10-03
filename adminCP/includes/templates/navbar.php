<nav class="navbar navbar-expand-lg text-center">
  <a class="navbar-brand color col-lg-5" href="dashbord.php"><?php echo lang("home") ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto col-lg-7 text-right">
      <li class="nav-item active">
        <a class="nav-link color" href="categor.php"><?php echo lang("cate") ?></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link color" href="item.php"><?php echo lang("item") ?></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link color" href="<?php echo'member.php?do=mange'?>"><?php echo lang("members") ?></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link color" href="comment.php"><?php echo lang("comm") ?></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link color" href="#"><?php echo lang("stat") ?></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link color" href="#"><?php echo lang("logs") ?></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle color" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $_SESSION["user"]; ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="../index.php">Visit Shop</a>
          <a class="dropdown-item" href="member.php?do=edit&userid=<?php echo $_SESSION["id"] ?>">edit porfile</a>
          <a class="dropdown-item" href="#">setting</a>
          <a class="dropdown-item" href="logout.php">log out</a>
        </div>
      </li>
    </ul>
  </div>
</nav>