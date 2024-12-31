<?php session_start();
date_default_timezone_set('Asia/Jakarta');

include_once('../../database/koneksi.php');
if (!isset($_SESSION['manager_id']) && !isset($_SESSION['admin_id'])) {
  header("location:../index.php");
  exit();
}
$user_name = isset($_SESSION['manager_username']) ? ucfirst($_SESSION['manager_username']) : (isset($_SESSION['admin_username']) ? ucfirst($_SESSION['admin_username']) : 'Unknown');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $order_id = $_POST['order_id'];
  $customer_name = $_POST['customer_name'];
  $customer_email = $_POST['customer_email'];
  // Gunakan username dari session sebagai updated_by
  $updated_by = $user_name;
  $order_total = $_POST['order_total'];
  $customer_status = $_POST['customer_status'];

  // Perbarui data order di database
  $stmt = $conn->prepare("UPDATE orderinfo SET customer_name = ?, customer_email = ?, updated_by = ?, order_total = ?, customer_status = ? WHERE order_id = ?");
  $stmt->bind_param("sssisi", $customer_name, $customer_email, $updated_by, $order_total, $customer_status, $order_id);

  if ($stmt->execute()) {
    header("Location: view_orders.php?success=1");
  } else {
    header("Location: view_orders.php?error=1");
  }
  $stmt->close();
  $conn->close();
}
?>


?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>Manager</title>

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

  <style>
  .icon-small {
    font-size: 16px;
    /* Ukuran ikon lebih kecil */
  }
  </style>


</head>

<body>

  <?php
  include_once('../../database/koneksi.php');
  ?>

  <div class="wrapper">
    <div class="body-overlay"></div>

    <?php
    // sidebar
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
          <B style="color:red">FIX BIAR NYAMBUNG KE BAGIAN INDEX.PHP</B>
          <!-- ALFIN -->
          <hr />

          <!-- Form Pencarian -->
          <form method="GET" action="">
            <div class="input-group mb-3 position-relative">
              <input type="text" class="form-control" placeholder="Cari Nama atau Email Customer" name="search"
                value="<?php echo isset($_GET['search']) ? $_GET['search'] : '' ?>" id="searchInput">
              <button class="btn btn-primary" type="submit">Cari</button>
              <span id="clearSearch" class="clear-search">X</span>
            </div>
          </form>

          <div class="tabbed_area">

            <ul class="tabs">
              <li><a href="javascript:tabSwitch('tab_1', 'content_1');" id="tab_1" class="active">View Orders</a></li>
            </ul>

            <div id="content_1" class="content">
              <div class="row">
                <div class="col-lg-12 col-md-12">
                  <div class="card">
                    <div class="card-content table-responsive">
                      <table class="table table-hover">
                        <thead class="text-primary">
                          <tr>
                            <th>Order Id</th>
                            <th>Nama</th>
                            <th>Email </th>
                            <th>Pelayan </th>
                            <th>Total </th>
                            <th>Tanggal </th>
                            <th>Status </th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          // Ambil data pencarian
                          $search = isset($_GET['search']) ? $_GET['search'] : '';

                          // Query untuk mendapatkan data dari database
                          if ($search) {
                            $stmt = $conn->prepare("SELECT * FROM orderinfo WHERE customer_name LIKE ? OR customer_email LIKE ? ORDER BY order_id DESC");
                            $search_param = "%" . $search . "%";
                            $stmt->bind_param("ss", $search_param, $search_param);
                          } else {
                            $stmt = $conn->prepare("SELECT * FROM orderinfo ORDER BY order_id DESC");
                          }

                          $stmt->execute();
                          $result = $stmt->get_result();

                          if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                              $rowStyle = ($row['customer_status'] == "Ordering") ? 'background-color: #ededed;' : '';
                              // Mengambil dan memformat order_datetime
                              $order_datetime = $row['order_datetime'];

                              // Array nama hari dalam bahasa Indonesia
                              $days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];

                              // Mendapatkan nama hari dari timestamp
                              $timestamp = strtotime($order_datetime);
                              $day_name = $days[date('w', $timestamp)];

                              $formatted_datetime = date('l, d F Y', $timestamp);
                              $formatted_datetime = str_replace(
                                ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                                $days,
                                $formatted_datetime
                              );
                          ?>
                          <tr style="<?php echo $rowStyle; ?>">
                            <td><?php echo $row['order_id']; ?></td>
                            <td><?php echo $row['customer_name']; ?></td>
                            <td><?php echo $row['customer_email']; ?></td>
                            <td><button type="button" class="" data-toggle="tooltip" data-placement="top"
                                title="<?php echo $row['updated_by']; ?>">
                                <?php echo $row['updated_by'] ?>
                              </button>
                            </td>
                            <td style="color: green;">Rp <?php echo number_format($row['order_total'], 0, ',', '.'); ?>
                            <td><?php echo $formatted_datetime; ?></td>

                            <td>
                              <?php if (!empty($row['customer_status'])) : ?>
                              <?php if ($row['customer_status'] == "Accept") : ?>
                              <button class="btn btn-sm btn-primary">
                                <?php echo $row['customer_status']; ?>
                              </button>
                              <?php elseif ($row['customer_status'] == "Success") : ?>
                              <button class="btn btn-sm btn-success">
                                <?php echo $row['customer_status']; ?>
                              </button>
                              <?php elseif ($row['customer_status'] == "Ordering") : ?>
                              <button class="btn btn-sm btn-warning">
                                <?php echo $row['customer_status']; ?>
                              </button>
                              <?php elseif ($row['customer_status'] == "Pending") : ?>
                              <button class="btn btn-sm btn-info">
                                <?php echo $row['customer_status']; ?>
                              </button>
                              <?php endif; ?>
                              <?php else : ?>
                              <!-- apabila terjadi error -->
                              <button class="btn btn-sm btn-danger">
                                Check Database
                              </button>
                              <?php endif; ?>
                            </td>

                            <td>
                              <div class="btn-group gap-1" role="group" aria-label="Button group with icons">
                                <!-- Visibility Button with Link -->
                                <a class="btn btn-primary btn-sm"
                                  href="view_orderItems.php?id=<?php echo $row['order_id'] ?>"
                                  id="<?php echo $row['order_id'] ?>">
                                  <span class="material-icons icon-small">visibility</span>
                                </a>
                                <!-- Edit Button -->
                                <button type="button" class="btn btn-warning btn-sm edit-btn" data-bs-toggle="modal"
                                  data-bs-target="#editModal" data-id="<?php echo $row['order_id']; ?>"
                                  data-name="<?php echo $row['customer_name']; ?>"
                                  data-email="<?php echo $row['customer_email']; ?>"
                                  data-pelayan="<?php echo $row['updated_by']; ?>"
                                  data-total="<?php echo $row['order_total']; ?>"
                                  data-status="<?php echo $row['customer_status']; ?>">
                                  <span class="material-icons icon-small">edit</span>
                                </button>
                                <!-- Delete Button -->
                                <a class="btn btn-danger btn-sm delete_order" id="<?php echo $row['order_id'] ?>">
                                  <span class="material-icons icon-small">delete</span>
                                </a>
                              </div>
                            </td>
                            <!-- <td>
                              <?php if ($row['customer_status'] == "Accept") : ?>
                              <button class="success_order" id="<?php echo $row['order_id'] ?>">
                                <span type="button" class="btn-sm btn-success">Success</span>
                              </button>
                              <?php elseif ($row['customer_status'] == "Success") : ?>
                              <button id="<?php echo $row['order_id'] ?>">
                                <span type="button" class="btn-sm btn-outline-success">Selesai</span>
                              </button>
                              <?php else : ?>
                              <button class="accept_order" id="<?php echo $row['order_id'] ?>">
                                <span type="button" class="btn-sm btn-primary">Accept</span>
                              </button>
                              <?php endif; ?> -->
                            <!-- apabila dibutuhkan -->
                            <!-- <button class="delete_order" id="<?php echo $row['order_id'] ?>">
														<span class="btn-sm btn-danger">Delete</span>
													</button> -->
                            <?php } ?>
                            <?php
                          } else {
                            ?>
                          <tr>
                            <td colspan="8" class="text-center fw-bold">Data tidak ditemukan</td>
                          </tr>
                          <?php
                          }
                            ?>
                        </tbody>
                        <!-- apabila dibutuhkan -->
                        <!-- <button class="delete_order_all">
                          <span class=" btn-sm btn-danger">Delete All</span>
                        </button> -->
                      </table>
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

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Order - <span id="orderIdPlaceholder">{id}</span></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editForm" method="POST" action="view_orders.php">
            <input type="hidden" name="order_id" id="editOrderId">
            <div class="mb-3">
              <label for="editName" class="form-label">Nama Customer</label>
              <input type="text" class="form-control" id="editName" name="customer_name" required>
            </div>
            <div class="mb-3">
              <label for="editEmail" class="form-label">Email Customer</label>
              <input type="email" class="form-control" id="editEmail" name="customer_email" required>
            </div>
            <div class="mb-3">
              <label for="editPelayan" class="form-label">Pelayan</label>
              <input type="text" class="form-control" id="editPelayan" name="updated_by" readonly>
            </div>
            <div class="mb-3">
              <label for="editTotal" class="form-label">Total</label>
              <input type="text" class="form-control" id="editTotal" name="order_total" required>
            </div>
            <div class="mb-3">
              <label for="editStatus" class="form-label">Status</label>
              <select class="form-select" id="editStatus" name="customer_status" required>
                <option value="Accept">Accept</option>
                <option value="Success">Success</option>
                <option value="Ordering">Ordering</option>
                <option value="Pending">Pending</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary edit_accept">Save changes</button>
          </form>
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

  <script>
  document.getElementById('clearSearch').addEventListener('click', function() {
    document.getElementById('searchInput').value = '';
  });

  <?php if ($search) : ?>
  Swal.fire({
    title: "Search Results",
    text: "Displaying results for '<?php echo $search; ?>'",
    icon: "info",
    confirmButtonText: "OK",
    timer: 2000, // Menampilkan notifikasi selama 2 detik
    timerProgressBar: true
  });
  <?php endif; ?>

  // Mengisi form edit dengan data yang sesuai
  $(document).on("click", ".edit-btn", function() {
    var orderId = $(this).data('id');
    var customerName = $(this).data('name');
    var customerEmail = $(this).data('email');
    var orderTotal = $(this).data('total');
    var customerStatus = $(this).data('status');
    var pelayan = $(this).data('pelayan');

    $("#editOrderId").val(orderId);
    $("#editName").val(customerName);
    $("#editEmail").val(customerEmail);
    $("#editTotal").val(orderTotal);
    $("#editStatus").val(customerStatus);
    $('#editPelayan').val(pelayan);

    // Update judul modal dengan ID order
    $("#orderIdPlaceholder").text(orderId);
  });

  $(document).on("submit", "#editForm", function(event) {
    event.preventDefault(); // Mencegah pengiriman form secara default

    var form = $(this);
    var formData = form.serialize(); // Mengambil data dari form

    $.ajax({
      type: "POST",
      url: form.attr("action"), // URL untuk mengirim data form
      data: formData,
      success: function(response) {
        // Menampilkan notifikasi berhasil
        Swal.fire({
          title: 'Success!',
          text: 'Order has been updated successfully.',
          icon: 'success',
          confirmButtonText: 'OK',
          timer: 2000, // Menampilkan notifikasi selama 2 detik
          timerProgressBar: true
        }).then(function() {
          window.location.href = 'view_orders.php?success=1';
        });
      },
      error: function(xhr, status, error) {
        // Menampilkan notifikasi gagal
        Swal.fire({
          title: 'Error!',
          text: 'Failed to update the order. Please try again.',
          icon: 'error',
          confirmButtonText: 'OK'
        });
      }
    });
  });
  </script>

</body>

</html>