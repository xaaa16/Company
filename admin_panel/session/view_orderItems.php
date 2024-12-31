<?php session_start();

if (!isset($_SESSION['manager_id']) && !isset($_SESSION['admin_id'])) {
  header("location:../index.php");
  exit();
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
  <?php
  if (isset($_SESSION['manager_id'])) {
    echo '<title>Manager</title>';
  } elseif (isset($_SESSION['admin_id'])) {
    echo '<title>Admin</title>';
  }
  ?>

  <!-- Bootstrap css file -->
  <link rel="stylesheet" href="../../plugins/bootstrap-5.1.3/css/bootstrap.min.css">


  <!--  Iconify SVG framework link -->
  <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>

  <!-- custom css file link  -->
  <link rel="stylesheet" href="../css/custom.css">
  <link rel="stylesheet" href="../css/sidebar.css">
  <link rel="stylesheet" href="../css/top_navbar.css">
  <link rel="stylesheet" href="../css/tabbed_box.css">

  <!--google material icon-->
  <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">


</head>

<body>

  <?php

  include_once('../../database/koneksi.php');
  ?>
  <div class="wrapper">
    <div class="body-overlay"></div>
    <?php
    if (isset($_SESSION['manager_id'])) {
      include('../includes/manager_sidebar.php');
    } elseif (isset($_SESSION['admin_id'])) {
      include('../includes/admin_sidebar.php');
    }
    ?>

    <div id="content">

      <?php
      $section = "Orders";

      include('../includes/top_navbar.php'); ?>

      <div class="main-content">
        <div id="tabbed_box" class="tabbed_box">
          <h4>View Orders Information</h4>
          <hr />
          <div class="tabbed_area">
            <?php
            $id = $_GET["id"];
            $result = mysqli_query($conn, "SELECT customer_name, customer_status, customer_email, customer_phone, order_datetime, order_lasttime, updated_by FROM orderinfo WHERE order_id = $id");
            ?>
            <ul class="tabs">
              <li><a href="javascript:tabSwitch('tab_1', 'content_1');" id="tab_1" class="active">Items</a></li>
            </ul>
            <ul class="row">
              <?php
              while ($row = mysqli_fetch_assoc($result)) {
                $customer_name = $row["customer_name"];
                $customer_email = $row["customer_email"];
                $customer_phone = $row["customer_phone"];
                $order_datetime = $row["order_datetime"];
                $order_lasttime = $row["order_lasttime"];
                $updated_by = $row["updated_by"];

                // Array nama hari dalam bahasa Indonesia
                $days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];

                // Mendapatkan nama hari dari timestamp
                $order_datetime_ts = strtotime($order_datetime);
                $day_name = $days[date('w', $order_datetime_ts)];
                $order_datetime = date('d F Y H:i:s', $order_datetime_ts);
                $order_datetime = $day_name . ', ' . $order_datetime;

                $order_lasttime_ts = strtotime($order_lasttime);
                $day_last_name = $days[date('w', $order_lasttime_ts)];
                $order_lasttime = date('d F Y H:i:s', $order_lasttime_ts);
                $order_lasttime = $day_last_name . ', ' . $order_lasttime;

                echo "<div style='display: flex;'><div style='width: 100px;'><strong>Order id</strong></div><div>: $id</div></div>";
                echo "<div style='display: flex;'><div style='width: 100px;'><strong>Nama</strong></div><div>: $customer_name</div></div>";
                echo "<div style='display: flex;'><div style='width: 100px;'><strong>Email</strong></div><div>: $customer_email</div></div>";
                echo "<div style='display: flex;'><div style='width: 100px;'><strong>Phone</strong></div><div>: $customer_phone</div></div>";
                echo "<div style='display: flex;'><div style='width: 100px;'><strong>Date</strong></div><div>: $order_datetime</div></div>";
                echo "<div style='display: flex;'><div style='width: 100px;'><strong>Payment</strong></div><div>: Cash On Delivery</div></div>";
                echo "<div style='display: flex;'><div style='width: 100px;'><strong>Lastupdate</strong></div><div>: $order_lasttime</div></div>";
                echo "<div style='display: flex;'><div style='width: 100px;'><strong>Updated By</strong></div><div>: $updated_by</div></div>";
              }
              ?>
            </ul>

            <div id="content_1" class="content">
              <div class="row ">
                <div class="col-lg-12 col-md-12">
                  <div class="card">
                    <div class="card-content table-responsive">
                      <table class="table table-hover">
                        <thead class="text-primary">
                          <tr>
                            <th></th>
                            <th>Nama Menu </th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Toppings</th>
                            <th>Toppings price</th>
                            <th>Total </th>
                            <th>Status </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $id = $_GET["id"];
                          $result = mysqli_query($conn, "SELECT order_item_id, order_items.order_id, item_name, item_quantity, toppings_price, customer_name, customer_email, customer_phone, customer_status, item_quantity, item_total, order_currency, order_total, customer_note FROM orderinfo , order_items WHERE orderinfo.order_id=$id and order_items.order_id=$id;");
                          while ($row = mysqli_fetch_assoc($result)) {
                            $query2 = "SELECT item_image,item_price From menuitem where item_name='" . $row['item_name'] . "'";
                            $result2 = mysqli_query($conn, $query2);
                            $row2 = mysqli_fetch_assoc($result2);
                          ?>
                            <tr>
                              <td><img src="../../<?php echo $row2['item_image']; ?>" class="round_img" /></td>
                              <td><?php echo $row['item_name']; ?></td>
                              <td>Rp <?php echo number_format($row2['item_price'], 0, ',', '.'); ?></td>
                              <td><?php echo $row['item_quantity']; ?></td>

                              <td>
                                <?php
                                // Query untuk mengambil nama topping
                                $query3 = "SELECT topping_name FROM extra_toppings WHERE order_item_id =" . $row['order_item_id'];
                                $result3 = mysqli_query($conn, $query3);

                                // Loop untuk menampilkan nama topping
                                while ($row3 = mysqli_fetch_assoc($result3)) {
                                  echo ucwords($row3['topping_name']) . '<br>';
                                }
                                ?>
                                <?php
                                $query3 = "SELECT topping_image From toppings,extra_toppings where toppings.topping_name = extra_toppings.topping_name and order_item_id =" . $row['order_item_id'];
                                $result3 = mysqli_query($conn, $query3);
                                while ($row3 = mysqli_fetch_assoc($result3)) { ?>

                                  <img src="../../<?php echo $row3['topping_image']; ?>" class="img_toppings">

                                <?php } ?>
                              </td>

                              <td>
                                <?php echo ($row['toppings_price'] != 0) ? 'Rp ' . number_format($row['toppings_price'], 0, ',', '.') : ''; ?>
                              </td>


                              <td>Rp <?php echo number_format($row['item_total'], 0, ',', '.'); ?></td>
                              <td>
                                <?php if ($row['customer_status'] == "Accept") : ?>
                                  <button type="button" class="btn-sm btn-outline-primary">Accept</button>
                                <?php elseif ($row['customer_status'] == "Success") : ?>
                                  <button type="button" class="btn-sm btn-outline-success">Selesai</button>
                                <?php elseif ($row['customer_status'] == "Ordering") : ?>
                                  <button type="button" class="btn-sm btn-outline-warning">Ordering</button>
                                <?php elseif ($row['customer_status'] == "Pending") : ?>
                                  <button type="button" class="btn-sm btn-outline-info">Pending</button>
                                <?php endif; ?>
                              </td>
                            <?php } ?>
                        </tbody>
                      </table>
                      <?php
                      $id = $_GET["id"]; // Ambil order_id dari parameter GET atau dari mana pun yang sesuai dengan aplikasi Anda
                      $result = mysqli_query($conn, "SELECT * FROM orderinfo WHERE order_id = $id");
                      $row = mysqli_fetch_assoc($result); // Mengambil baris pertama yang sesuai dengan order_id yang diberikan
                      ?>
                      <div style="display: flex; justify-content: space-between; margin: 30px;">
                        <div style="text-align: left;">
                          <strong>Note:</strong><br>
                          <button type="button" class="btn btn-outline-primary disabled">
                            <?php echo !empty($row['customer_note']) ? $row['customer_note'] : '_____'; ?>
                          </button>
                        </div>
                        <div style="text-align: right;">
                          <strong>Total Order:</strong><br>
                          <button type="button" class="btn btn-outline-primary">
                            Rp <?php echo number_format($row['order_total'], 0, ',', '.'); ?>
                          </button>
                          <!-- Menggunakan number_format untuk format Rupiah -->
                          <!-- sudah dengan pajak + kode unik -->
                        </div>
                      </div>

                      <div style="display: flex; justify-content: flex-end; gap: 10px;">
                        <?php if ($row) : // Memeriksa apakah query mengembalikan baris 
                          if ($row['customer_status'] == "Accept") : ?>
                            <button class="success_order" id="<?php echo $row['order_id'] ?>">
                              <span class="btn btn-success">Success</span>
                            </button>
                          <?php elseif ($row['customer_status'] == "Ordering") : ?>
                            <button class="accept_order" id="<?php echo $row['order_id'] ?>">
                              <span class="btn btn-primary">Accept</span>
                            </button>
                          <?php elseif ($row['customer_status'] == "Success") : ?>
                            <button class="ordering_order" id="<?php echo $row['order_id'] ?>">
                              <span class="btn btn-info">Pending</span>
                            </button>
                          <?php elseif ($row['customer_status'] == "Pending") : ?>
                            <button class="accept_order" id="<?php echo $row['order_id'] ?>">
                              <span class="btn btn-primary">Accept</span>
                            </button>
                          <?php endif; ?>

                          <button class="delete_order" id="<?php echo $row['order_id'] ?>">
                            <span class="btn btn-danger">Delete</span>
                          </button>

                          <button onclick="goBack()" id="<?php echo $row['order_id'] ?>">
                            <span class="btn btn-outline-success">Back</span>
                          </button>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="js/popper.min.js"></script>

  <!-- bootstrap js file-->
  <script src="../../plugins/bootstrap-5.1.3/js/bootstrap.min.js"></script>

  <!-- jquery js file  -->
  <script src="../../plugins/jquery-3.6.0/jquery.min.js"></script>

  <!-- sweetalert2 js file -->
  <script src="../../plugins/sweetalert2/sweetalert2.js"></script>

  <script src="../js/script.js" type="text/javascript"></script>
  <script src="../js/update_delete.js" type="text/javascript"></script>


</body>

</html>