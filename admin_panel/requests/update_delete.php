<?php session_start();

include_once('../../database/koneksi.php');
// Mengatur zona waktu ke WIB (Waktu Indonesia Barat)
date_default_timezone_set('Asia/Jakarta');

if (isset($_POST['action'])) {
    $response = array();
    // Ambil nama pengguna dari sesi dan kapitalisasi huruf pertama
    $user_name = isset($_SESSION['manager_username']) ? ucfirst($_SESSION['manager_username']) : (isset($_SESSION['admin_username']) ? ucfirst($_SESSION['admin_username']) : 'Unknown');

    // success order
    if ($_POST["action"] == "remove_success") {

        $order_id = $_POST['order_id'];

        // Ambil nama pengguna dari sesi

        $customer_status = "Success";
        $order_lasttime = date('Y-m-d H:i:s');
        $query = "UPDATE orderinfo SET customer_status=?, order_lasttime=?, updated_by=? WHERE order_id=?";
        $stmt = $conn->prepare($query);

        // Check if prepare() succeeded
        if ($stmt === false) {
            $response['error'] = "Failed to prepare statement.";
        } else {
            $stmt->bind_param("sssi", $customer_status, $order_lasttime, $user_name, $order_id);

            $response = array();
            if ($stmt->execute()) {
                $response['success'] = true;
            } else {
                $response['error'] = "Failed to update customer status.";
            }

            $stmt->close(); // Close statement
        }
    }

    // remove order
    if ($_POST["action"] == "remove_ordering") {

        $order_id = $_POST['order_id'];

        $customer_status = "Pending";
        $order_lasttime = date('Y-m-d H:i:s');
        $query = "UPDATE orderinfo SET customer_status=?, order_lasttime=?, updated_by=? WHERE order_id=?";
        $stmt = $conn->prepare($query);

        // Check if prepare() succeeded
        if ($stmt === false) {
            $response['error'] = "Failed to prepare statement.";
        } else {
            $stmt->bind_param("sssi", $customer_status, $order_lasttime, $user_name, $order_id);

            $response = array();
            if ($stmt->execute()) {
                $response['success'] = true;
            } else {
                $response['error'] = "Failed to update customer status.";
            }

            $stmt->close(); // Close statement
        }
    }

    // remove order
    if ($_POST["action"] == "remove_accept") {

        $order_id = $_POST['order_id'];

        $customer_status = "Accept";
        $order_lasttime = date('Y-m-d H:i:s');
        $query = "UPDATE orderinfo SET customer_status=?, order_lasttime=?, updated_by=? WHERE order_id=?";
        $stmt = $conn->prepare($query);

        // Check if prepare() succeeded
        if ($stmt === false) {
            $response['error'] = "Failed to prepare statement.";
        } else {
            $stmt->bind_param("sssi", $customer_status, $order_lasttime, $user_name, $order_id);

            $response = array();
            if ($stmt->execute()) {
                $response['success'] = true;
            } else {
                $response['error'] = "Failed to update customer status.";
            }

            $stmt->close(); // Close statement
        }
    }

    // remove order all
    if ($_POST["action"] == "remove_order_all") {

        // Delete all rows from order_items
        $query1 = "DELETE FROM order_items";
        $result1 = mysqli_query($conn, $query1);

        // Delete all rows from orderinfo
        $query2 = "DELETE FROM orderinfo";
        $result2 = mysqli_query($conn, $query2);
    }

    // remove order
    if ($_POST["action"] == "remove_order") {

        $order_id = $_POST['order_id'];

        $query = "DELETE FROM order_items where order_id=$order_id";
        mysqli_query($conn, $query);

        $query = "DELETE FROM orderinfo where order_id=$order_id";
        mysqli_query($conn, $query);
    }

    // remove manager
    if ($_POST["action"] == "remove_manager") {

        $manager_id = $_POST['manager_id'];

        $query = "DELETE FROM manager where manager_id=$manager_id";
        mysqli_query($conn, $query);
    }


    // remove team
    if ($_POST["action"] == "remove_member") {

        $member_id = $_POST['member_id'];

        $query = "DELETE FROM data_rumah where member_id=$member_id";
        mysqli_query($conn, $query);
    }

    // remove admin
    if ($_POST["action"] == "remove_admin") {

        $admin_id = $_POST['admin_id'];

        $query = "DELETE FROM admin where admin_id=$admin_id";
        mysqli_query($conn, $query);
    }
}