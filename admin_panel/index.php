<?php
session_start();

include_once('../database/koneksi.php');

$message = null;

if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	// Cek apakah user adalah Admin
	$query = "SELECT admin_id, admin_username, admin_image FROM admin WHERE admin_username=? AND admin_password=?";
	$stmt = mysqli_prepare($conn, $query);
	mysqli_stmt_bind_param($stmt, "ss", $username, $password);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$row = mysqli_fetch_assoc($result);

	if ($row) {
		// Jika ditemukan di tabel admin
		$_SESSION['admin_id'] = $row['admin_id'];
		$_SESSION['admin_username'] = $row['admin_username'];
		$_SESSION['admin_image'] = $row['admin_image'];
		header("location:session/dashboard.php");
		exit();
	} else {
		// Jika tidak ditemukan di tabel admin, cek tabel manager
		$query = "SELECT manager_id, manager_username, manager_image FROM manager WHERE manager_username=? AND manager_password=?";
		$stmt = mysqli_prepare($conn, $query);
		mysqli_stmt_bind_param($stmt, "ss", $username, $password);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$row = mysqli_fetch_assoc($result);

		if ($row) {
			// Jika ditemukan di tabel manager
			$_SESSION['manager_id'] = $row['manager_id'];
			$_SESSION['manager_username'] = $row['manager_username'];
			$_SESSION['manager_image'] = $row['manager_image'];
			header("location:session/dashboard.php");
			exit();
		} else {
			// Jika tidak ditemukan di kedua tabel
			$message = "<font color=red><br><center>Invalid login. Try Again</center></font>";
		}
	}
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, maximum-scale=1">
  <title>Shop Management System</title>
  <link rel="stylesheet" type="text/css" href="css/login.css">

</head>

<body>

  <div class="content">

    <div class="header">
      <h1>Shop Management System</h1>
    </div>

    <div class="main">

      <section class="container">

        <div class="login">
          <img src="../images/login.png">

          <?php echo $message; ?>

          <form method="post" action="" align="center">
            <input type="text" name="username" value="" placeholder="Username" required>
            <input type="password" name="password" value="" placeholder="Password" required>
            <input type="submit" name="submit" value="Login">
          </form>
        </div>
      </section>
    </div>
  </div>

</body>

</html>