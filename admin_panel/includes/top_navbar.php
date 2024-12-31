<?php

include_once('../../database/koneksi.php');

// Count the number of "Ordering" statuses
$orderCountResult = mysqli_query($conn, "SELECT COUNT(*) as orderCount FROM orderinfo WHERE customer_status = 'Ordering'");
$orderCountRow = mysqli_fetch_assoc($orderCountResult);
$orderCount = $orderCountRow['orderCount'];
?>
<div class="top-navbar">
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">

      <button type="button" id="sidebarCollapse" class="d-xl-block d-lg-block d-md-mone d-none">
        <span class="material-icons">arrow_back_ios</span>
      </button>

      <a class="navbar-brand" href="#"> <?php echo $section ?> </a>

      <button class="d-inline-block d-lg-none ml-auto more-button" type="button" data-toggle="collapse"
        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="material-icons">more_vert</span>
      </button>

      <div class="collapse navbar-collapse d-lg-block d-xl-block d-sm-none d-md-none d-none"
        id="navbarSupportedContent">
        <ul class="nav navbar-nav ml-auto">
          <li class="dropdown nav-item active">
            <a href="#" class="nav-link" data-toggle="dropdown" id="notificationDropdown">
              <span class="material-icons">notifications</span>
              <span class="notification"><?php echo $orderCount; ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown">
              <div class="notification-item">
                <a href="#">You have 5 new messages</a>
              </div>
              <div class="notification-item">
                <a href="#">You're now friend with Mike</a>
              </div>
              <div class="notification-item">
                <a href="#">Wish Mary on her birthday!</a>
              </div>
              <div class="notification-item">
                <a href="#">5 warnings in Server Console</a>
              </div>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span class="material-icons">apps</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span class="material-icons">person</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span class="material-icons">settings</span>
            </a>
          </li>

          <li class="nav-item" id="logout">
            <a class="nav-link" href="../logout.php">
              logout
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</div>