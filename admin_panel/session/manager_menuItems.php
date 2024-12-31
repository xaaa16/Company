<?php session_start();

if (!isset($_SESSION['manager_id'])) {
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
  <title>Admin</title>

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

	if (isset($_POST["submit"])) {

		$nama = trim($_POST['name']);
		$gambar = trim($_POST['gambar']);
		$alamat = trim($_POST['alamat']);
		$tanah = trim($_POST['tanah']);
		$bangunan = trim($_POST['bangunan']);
		$tidur = trim($_POST['tidur']);
		$mandi = trim($_POST['mandi']);
		$att = trim($_POST['att']);

		if (isset($_FILES['gambar']['name'])) {
			$filename = $_FILES['gambar']['name'];

			$location = "../../images/team/" . $filename;

			// if folder doesn't exist -> create one
			if (!file_exists("../../images/team")) {
				mkdir("../../images/team", 0700, true);
			}

			move_uploaded_file($_FILES['gambar']['tmp_name'], $location);
		}


		$query = "INSERT INTO `team` (`name`,`gambar`,`alamat`,`tanah`,`bangunan`,`tidur`,`mandi`,`att`) VALUES 
	('$member_name','$filename','$alamat','$tanah','$bangunan','$tidur','$mandi','$att')";

		mysqli_query($conn, $query);
		header("Refresh: 0;");
	}

	if (isset($_POST["update_info"])) {

		$new_name = trim($_POST["mn"]);
		$new_gambar = trim($_POST["mg"]);
		$new_alamat = trim($_POST["ma"]);
		$new_tanah = trim($_POST["mt"]);
		$new_bangunan = trim($_POST["mb"]);
		$new_tidur = trim($_POST["mt"]);
		$new_mandi = trim($_POST["mm"]);
		$new_att = trim($_POST["ma"]);

		$id = $_POST['hidden_id'];

		if ($_FILES['new_image']['size'] > 0) {
			$filename = $_FILES['new_image']['name'];

			$location = "../../images/team/" . $filename;

			move_uploaded_file($_FILES['new_image']['tmp_name'], $location);

			$query = "UPDATE `team` set gambar='" . $filename . "' WHERE member_id=$id";

			mysqli_query($conn, $query);
		}

		$query = "UPDATE `team` set nama='" . $new_name . "', 
							  gambar='" . $new_gambar . "', 
							  alamat='" . $new_alamat . "', 
							  tanah='" . $new_tanah . "',
							  bangunan='" . $new_bangunan . "',
							  tidur='" . $new_tidur . "',  
							  mandi='" . $new_mandi . "',
								att='" . $new_att . "' 
					WHERE member_id=$id";

		if (mysqli_query($conn, $query)) {
			header("Refresh: 0;");
		} else {
			echo mysqli_error($conn);
		}
	}

	?>
  <div class="wrapper">
    <div class="body-overlay"></div>
    <?php
		// sidebar
		include('../includes/manager_sidebar.php');
		?>

    <div id="content">

      <?php
			$section = "Team Members";

			include('../includes/top_navbar.php');
			?>
      <div class="main-content">

        <div id="tabbed_box" class="tabbed_box">

          <h4>Manage Team Members</h4>
          <hr />

          <div class="tabbed_area">

            <ul class="tabs">
              <li><a href="javascript:tabSwitch('tab_1', 'content_1');" id="tab_1" class="active">View Team</a></li>
              <li><a href="javascript:tabSwitch('tab_2', 'content_2');" id="tab_2">Add Member</a></li>
            </ul>

            <!--##################################################################################### 
	View all team members
	##################################################################################### -->

            <div id="content_1" class="content">
              <div class="row ">
                <div class="col-lg-12 col-md-12">
                  <div class="card">

                    <div class="card-content table-responsive">
                      <table class="table table-hover">
                        <thead class="text-primary">
                          <tr>
                            <th></th>
                            <th>Name</th>
                            <th>alamat</th>
                            <th>tanah</th>
                            <th>bangunan </th>
                            <th>tidur</th>
                            <th>mandi </th>
                            <th></th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
													$result = mysqli_query($conn, "SELECT * FROM team");
													while ($row = mysqli_fetch_assoc($result)) { ?>

                          <tr>
                            <td><img src="../../images/team/<?php echo $row['gambar']; ?>" class="round_img"
                                id="image_<?php echo $row['member_id'] ?>" /></td>
                            <td id="name_<?php echo $row['member_id'] ?>"><?php echo $row['nama']; ?></td>
                            <td id="alamat_<?php echo $row['member_id'] ?>"><?php echo $row['alamat']; ?></td>
                            <td id="tanah_<?php echo $row['member_id'] ?>"><?php echo $row['tanah']; ?></td>
                            <td id="bangunan_<?php echo $row['member_id'] ?>"><?php echo $row['bangunan']; ?></td>
                            <td id="tidur_<?php echo $row['member_id']; ?>"><?php echo $row['tidur']; ?></td>
                            <td id="mandi_<?php echo $row['member_id'] ?>"><?php echo $row['mandi']; ?>
                            <td>
                              <button class="update_member" id="<?php echo $row['member_id'] ?>">
                                <span class="iconify" data-icon="bx:edit" style="color: green;" data-width="30"
                                  data-height="30"></span>
                              </button>
                            </td>
                            <td>
                              <button class="delete_member" id="<?php echo $row['member_id'] ?>">
                                <span class="iconify" data-icon="fluent:delete-24-filled" style="color: red;"
                                  data-width="30" data-height="30"></span>
                              </button>
                            </td>
                            <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!--##################################################################################### 
	Add a new team member
	##################################################################################### -->

            <div id="content_2" class="content">

              <form action="" method="post" enctype="multipart/form-data">
                <table width="220" height="106" border="0">
                  <tr>
                    <td align="center"><input name="image" type="file" style="width:100%" required="required"
                        id="uploadFile" accept=".jpg, .jpeg, .png" /></td>
                  </tr>
                  <tr>
                    <td align="center"><input name="name" type="text" style="width:100%" placeholder="Name"
                        required="required" id="add_member_name" /></td>
                  </tr>
                  <tr>
                    <td align="center"><input name="alamat" type="text" style="width:100%" placeholder="alamat"
                        required="required" id="add_member_alamat" /></td>
                  </tr>
                  <tr>
                    <td align="center"><input name="tanah" type="text" style="width:100%" placeholder="tanah"
                        required="required" id="add_member_tanah" /></td>
                  </tr>
                  <tr>
                    <td align="center"><input name="bangunan" type="text" style="width:100%" placeholder="bangunan"
                        required="required" id="add_member_bangunan" /></td>
                  </tr>
                  <tr>
                    <td align="center"><input name="tidur" type="text" style="width:100%" placeholder="tidur"
                        required="required" id="add_member_tidur" /></td>
                  </tr>
                  <tr>
                    <td align="center"><input name="mandi" type="text" style="width:100%" placeholder="mandi"
                        required="required" id="add_member_mandi" /></td>
                  </tr>
                  <tr>
                    <td align="center"><input name="att" type="text" style="width:100%" placeholder="att"
                        required="required" id="add_member_att" /></td>
                  </tr>
                  <tr>
                    <td align="right"><input type="submit" value="add" name="submit" class="add_member" /></td>
                  </tr>
                </table>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!--##################################################################################### 
        when the admin click on edit button
        a popup modal appears -> let the admin update a member's details
    ##################################################################################### -->

  <div id="add_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">

        <!-- modal title -->
        <div class="modal-header">
          <h3 class="modal-title" id="NAME"></h3>
        </div>

        <!--  modal body -->
        <form method="post" action="" enctype="multipart/form-data" class="form-horizontal">
          <div class="modal-body">
            <div class="content-wrapper">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="panel panel-default">
                          <div class="panel-body">
                            <form action="" method="post" enctype="multipart/form-data">
                              <div class="hr-dashed"></div>

                              <input type="hidden" name="hidden_id" id="hidden_id" value="" />

                              <div class="form-group">
                                <img class="image" id="mi" src="" />
                                <label class="col-sm-3 control-label">Click to change photo</label>
                                <div class="col-sm-8">
                                  <input type="file" class="form-control new_image" name="new_image" id="new_image">
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="col-sm-3 col-md-4 control-label">Name</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" name="mn" id="mn" required="required">
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="col-sm-3 col-md-4 control-label">alamat</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" name="ma" id="ma" required="required">
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="col-sm-3 col-md-4 control-label">tanah</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" name="mt" id="mt" required="required">
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="col-sm-3 col-md-4 control-label">bangunan</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" name="mb" id="mb" required="required">
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="col-sm-3 col-md-4 control-label">tidur</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" name="mt" id="mt" required="required">
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="col-sm-3 col-md-4 control-label">mandi</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" name="mm" id="mm" required="required">
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="col-sm-3 col-md-4 control-label">att</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" name="ma" id="ma" required="required">
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <input class="btn btn-primary" type="submit" name="update_info" id="update_info" value="Update">
              <input class="btn btn-primary" type="submit" name="cancel" id="cancel" value="Cancel">
            </div>
          </div>
        </form>
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