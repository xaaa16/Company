<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("location:../index.php");
    exit();
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Admin</title>

    <!-- Bootstrap css file -->
    <link rel="stylesheet" href="../../plugins/bootstrap-5.1.3/css/bootstrap.min.css">

    <!-- Font Awesome css cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Iconify SVG framework link -->
    <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>

    <!-- Custom css file link -->
    <link rel="stylesheet" href="../css/custom.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/top_navbar.css">

    <!-- Google Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
</head>

<body>

    <?php include_once('../../database/koneksi.php'); ?>

    <div class="wrapper">
        <div class="body-overlay"></div>

        <?php include('../includes/admin_sidebar.php'); ?>

        <div id="content">
            <?php
            $section = "Reviews";
            include('../includes/top_navbar.php');
            ?>

            <div class="main-content">
                <h4>View All Reviews</h4>
                <hr />

                <div class="stars_container">
                    <div class="star_element">
                        <i class="fas fa-star submit_star mr-1" id="submit_star_1" data-rating="1"></i>
                        <span> 1 star reviews</span>
                    </div>
                    <div class="star_element">
                        <i class="fas fa-star submit_star mr-1" id="submit_star_2" data-rating="2"></i>
                        <span> 2 star reviews </span>
                    </div>
                    <div class="star_element">
                        <i class="fas fa-star submit_star mr-1" id="submit_star_3" data-rating="3"></i>
                        <span> 3 star reviews </span>
                    </div>
                    <div class="star_element">
                        <i class="fas fa-star submit_star mr-1" id="submit_star_4" data-rating="4"></i>
                        <span> 4 star reviews </span>
                    </div>
                    <div class="star_element">
                        <i class="fas fa-star submit_star mr-1" id="submit_star_5" data-rating="5"></i>
                        <span> 5 star reviews </span>
                    </div>
                </div>

                <hr />
                <h4>Statistics & Reports</h4>
                <hr />

                <div class="reviews_stat">
                    <?php
                    // Initialize arrays
                    $month_array = array_fill(0, 12, 0);
                    $average_rating_month_array = array_fill(0, 12, 0);
                    $star_array = array_fill(0, 5, 0);

                    $query = "SELECT user_rating, datetime FROM review_table WHERE datetime LIKE CONCAT('%-%-', YEAR(CURRENT_DATE));";
                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $values = explode('-', $row["datetime"]); // date: YYYY-MM-DD
                        $monthValue = (int)$values[1];
                        $starValue = (int)$row["user_rating"];

                        if ($monthValue >= 1 && $monthValue <= 12) {
                            $month_index = $monthValue - 1;
                            $month_array[$month_index]++;
                            $average_rating_month_array[$month_index] += $starValue;
                        }

                        if ($starValue >= 1 && $starValue <= 5) {
                            $star_index = $starValue - 1;
                            $star_array[$star_index]++;
                        }
                    }

                    for ($i = 0; $i < 12; $i++) {
                        if ($month_array[$i] != 0) {
                            $average_rating_month_array[$i] = number_format($average_rating_month_array[$i] / $month_array[$i], 1);
                        }
                    }

                    $month_array = implode('-', $month_array);
                    $star_array = implode('-', $star_array);
                    $average_rating_month_array = implode('-', $average_rating_month_array);
                    ?>

                    <input type="hidden" id="hidden-year" value="<?php echo $values[0]; ?>" />
                    <input type="hidden" id="hidden-stats" value="<?php echo $month_array; ?>" />
                    <input type="hidden" id="hidden-stars" value="<?php echo $star_array; ?>" />
                    <input type="hidden" id="hidden-average" value="<?php echo $average_rating_month_array; ?>" />

                    <div class="container1">
                        <div>
                            <canvas id="myChart" style="width:40vw;"></canvas>
                        </div>

                        <button class="status">
                            <span class="shadow"></span>
                            <span class="edge"></span>
                            <span class="front text"> View Status </span>
                        </button>
                    </div>

                    <div style="position:relative; width:40vw;">
                        <canvas id="myChart2"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for viewing reviews -->
    <div id="add_modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="NAME"></h3>
                </div>
                <form method="post" class="form-horizontal">
                    <div class="modal-body">
                        <div class="content-wrapper">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <div class="review"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input class="btn btn-primary" type="button" name="cancel" id="cancel" value="Cancel">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for viewing shop status -->
    <div id="add_modal2" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="NAME"></h3>
                </div>
                <form method="post" class="form-horizontal">
                    <div class="modal-body">
                        <div class="content-wrapper">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <div style="position:relative; width:50vw;">
                                                    <canvas id="myChart3"></canvas>
                                                </div>
                                                <div class="status_info">
                                                    <h2 class="status_elm">Total average</h2>
                                                    <hr />
                                                    <h3 class="status_elm2"></h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input class="btn btn-primary" type="button" name="cancel" id="cancel2" value="Cancel">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script files -->
    <script src="../../plugins/jquery-3.6.0/jquery.min.js"></script>
    <script src="../../plugins/bootstrap-5.1.3/js/bootstrap.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../../plugins/sweetalert2/sweetalert2.js"></script>
    <script src="../../plugins/chart.js-3.7.1/chart.min.js"></script>
    <script src="../js/script.js" type="text/javascript"></script>
    <script src="../js/charts.js" type="text/javascript"></script>
</body>

</html>