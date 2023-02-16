<?php
include_once("./layout/header.php");

$sql = "SELECT * FROM users";
$stmt = $conn->prepare($sql);
$stmt->execute();
$row_count = $stmt->rowCount();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
//$balances = $row['acct_balance']->rowCount();
?>



<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">

<div class="page-header">
    <div class="page-title">
        <h3>Admin Analytics</h3>
    </div>
</div>

<div class="row layout-top-spacing">

    <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-one">
            <div class="widget-heading">
                <h6 class="">Users Statistics</h6>
            </div>
            <div class="w-chart">
                <div class="w-chart-section">
                    <div class="w-detail">
                        <p class="w-title">Total Users</p>
                        <p class="w-stats"><?= $row_count ?></p>
                    </div>
                    <div class="w-chart-render-one">
                        <div id="total-users"></div>
                    </div>
                </div>

                <div class="w-chart-section">
                    <div class="w-detail">
                        <p class="w-title">Total Balance</p>
                        <?php
                        $sql = "SELECT SUM(acct_balance) FROM users";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();

                        $total = $stmt->fetch(PDO::FETCH_NUM);
                        $sum = $total[0];
                        ?>
                        <p class="w-stats"><?="$".$sum ?></p>
                    </div>
                    <div class="w-chart-render-one">
                        <div id="paid-visits"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
        <div class="widget widget-account-invoice-two">
            <div class="widget-content">
                <div class="account-box">
                    <div class="info">
                        <h5 class="">Total Wire Transfer</h5>
                        <?php
                        $sql = "SELECT SUM(amount) FROM wire_transfer";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();

                        $total = $stmt->fetch(PDO::FETCH_NUM);
                        $sum = $total[0];
                        ?>
                        <p class="inv-balance"><?="$". $sum?></p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
        <div class="widget widget-card-four">
            <div class="widget-content">
                <div class="w-content">
                    <div class="w-info">
                        <?php
                        $sql = "SELECT SUM(amount) FROM deposit";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();

                        $total = $stmt->fetch(PDO::FETCH_NUM);
                        $sum = $total[0];
                        ?>
                        <h6 class="value"><?="$".$sum ?></h6>
                        <p class="">Total Deposit</p>
                    </div>
                    <div class="">
                        <div class="w-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        </div>
                    </div>
                </div>
                <div class="progress">
                    <div class="progress-bar bg-gradient-secondary" role="progressbar" style="width: 57%" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-chart-three">
            <div class="widget-heading">
                <div class="">
                    <h5 class="">Unique Visitors</h5>
                </div>

                <div class="dropdown  custom-dropdown">
                    <a class="dropdown-toggle" href="#" role="button" id="uniqueVisitors" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="uniqueVisitors">
                        <a class="dropdown-item" href="javascript:void(0);">View</a>
                        <a class="dropdown-item" href="javascript:void(0);">Update</a>
                        <a class="dropdown-item" href="javascript:void(0);">Download</a>
                    </div>
                </div>
            </div>

            <div class="widget-content">
                <div id="uniqueVisits"></div>
            </div>
        </div>
    </div>
<!--  END CONTENT AREA  -->


<?php
include_once("./layout/footer.php");
?>
