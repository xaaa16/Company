<?php

include_once('../../database/koneksi.php');

// Count the number of "Ordering" statuses
$orderCountResult = mysqli_query($conn, "SELECT COUNT(*) as orderCount FROM orderinfo WHERE customer_status = 'Accept'");
$orderCountRow = mysqli_fetch_assoc($orderCountResult);
$orderCount = $orderCountRow['orderCount'];
?>

<nav id="sidebar">
  <div class="sidebar-header">
    <h3><img src="../../images/managers/<?php echo $_SESSION['manager_image'] ?>"
        class="img-fluid" /><span><?php echo $_SESSION['manager_username'] ?><br>| Manager</span></h3>
  </div>

  <ul class="list-unstyled components">
    <li class="active">
      <a href="dashboard.php" class="dashboard"><i class="material-icons">dashboard</i><span>Dashboard</span></a>
    </li>

    <li class="">
      <a href="manager_managers.php"><i class="material-icons">people</i><span>Managers</span></a>
    </li>

    <li class="">
      <a href="manager_team.php"><i class="material-icons">people</i><span>Data Rumah</span></a>
    </li>

    <li class="">
      <a href="view_orders.php"><i class="material-icons">people</i><span>View Orders</span></a>
    </li>

    <li class="">
      <a href="view_reviews.php"><i class="material-icons">reviews</i><span>Reviews</span></a>
    </li>
  </ul>
</nav>