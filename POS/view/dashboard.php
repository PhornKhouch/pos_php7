<?php
require_once '../Config/conect.php';

// Set default date range to current month
$startDate = date('Y-m-01'); // First day of current month
$endDate = date('Y-m-t');    // Last day of current month

// Get stock summary data
$summaryQuery = "SELECT 
    COALESCE(COUNT(DISTINCT id), 0) as total_products,
    COALESCE(SUM(stockqty), 0) as total_quantity,
    COALESCE(SUM(stockqty * unitcose), 0) as total_value
    FROM prdmaster 
    WHERE DATE(stockdate) BETWEEN ? AND ?";

$stmt = $con->prepare($summaryQuery);
$stmt->bind_param("ss", $startDate, $endDate);
$stmt->execute();
$summary = $stmt->get_result()->fetch_assoc();

// Initialize summary values to 0 if NULL
$summary['total_products'] = $summary['total_products'] ?? 0;
$summary['total_quantity'] = $summary['total_quantity'] ?? 0;
$summary['total_value'] = $summary['total_value'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../Style/summary.css">
</head>
<body>
    <div class="container-fluid mt-4">
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                       
                            <div class="d-flex justify-content-between">
                                <?php
                                    $select = "SELECT COUNT(*) AS total_sales, DATE_FORMAT(?, '%b-%Y') AS date 
                                    FROM `salemaster` 
                                    WHERE DATE(saledate) BETWEEN ? AND ?";
                                    $stmt = $con->prepare($select);
                                    $stmt->bind_param("sss", $startDate, $startDate, $endDate);
                                    $stmt->execute();
                                    $row = $stmt->get_result()->fetch_assoc();
                                ?>
                                <div>
                                    <h6 class="card-title">Total Sales</h6>
                                    <h3 class="mb-0"><?php echo $row['total_sales']; ?></h3>
                                    <small><?php echo $row['date']; ?></small>
                                </div>
                                <div>
                                    <i class="fas fa-shopping-cart fa-2x"></i>
                                </div>
                            </div>
                       
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <?php
                                    $Revenue = "SELECT COALESCE(SUM(tax), 0) AS total_revenue 
                                    FROM `salemaster` 
                                    WHERE DATE(saledate) BETWEEN ? AND ?";
                                    $stmt = $con->prepare($Revenue);
                                    $stmt->bind_param("ss", $startDate, $endDate);
                                    $stmt->execute();
                                    $row = $stmt->get_result()->fetch_assoc();
                                ?>
                                <h6 class="card-title">Total Revenue</h6>
                                <h3 class="mb-0">$<?php echo number_format($row['total_revenue'], 2); ?></h3>
                                <small>Including Tax</small>
                            </div>
                            <div>
                                <i class="fas fa-dollar-sign fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <?php
                                    $average = "SELECT COALESCE(AVG(subtotal), 0) AS total_average 
                                    FROM `salemaster` 
                                    WHERE DATE(saledate) BETWEEN ? AND ?";
                                    $stmt = $con->prepare($average);
                                    $stmt->bind_param("ss", $startDate, $endDate);
                                    $stmt->execute();
                                    $row = $stmt->get_result()->fetch_assoc();
                                ?>
                                <h6 class="card-title">Average Sale</h6>
                                <h3 class="mb-0">$<?php echo number_format($row['total_average'], 2); ?></h3>
                                <small>Per Transaction</small>
                            </div>
                            <div>
                                <i class="fas fa-chart-line fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <?php
                                    $avgperday = "SELECT 
                                        COALESCE(AVG(daily_total), 0) as total_average
                                    FROM (
                                        SELECT DATE(saledate) as sale_date, SUM(subtotal) as daily_total
                                        FROM `salemaster`
                                        WHERE DATE(saledate) BETWEEN ? AND ?
                                        GROUP BY DATE(saledate)
                                    ) as daily_sales";
                                    $stmt = $con->prepare($avgperday);
                                    $stmt->bind_param("ss", $startDate, $endDate);
                                    $stmt->execute();
                                    $row = $stmt->get_result()->fetch_assoc();
                                ?>
                                <h6 class="card-title">Daily Average</h6>
                                <h3 class="mb-0">$<?php echo number_format($row['total_average'], 2); ?></h3>
                                <small>Per Day</small>
                            </div>
                            <div>
                                <i class="fas fa-calendar-alt fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock Summary -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Stock Summary</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <a href="../view/reportstock/stock_report.php" target="content" style="text-decoration: none;">
                            <div class="summary-card products-card white-card position-relative">
                                <i class="fas fa-boxes summary-icon"></i>
                                <h6 class="card-subtitle">Total Products</h6>
                                <h4 class="card-value"><?php echo number_format($summary['total_products']); ?></h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                    <a href="../view/reportstock/stock_report.php" target="content">
                        <div class="summary-card quantity-card white-card position-relative">
                            <i class="fas fa-cubes summary-icon"></i>
                            <h6 class="card-subtitle">Total Quantity</h6>
                            <h4 class="card-value"><?php echo number_format($summary['total_quantity']); ?></h4>
                        </div>
</a>
                    </div>
                    <div class="col-md-4">
                    <a href="../view/reportstock/stock_report.php" target="content">
                        <div class="summary-card value-card white-card position-relative">
                            <i class="fas fa-dollar-sign summary-icon"></i>
                            <h6 class="card-subtitle">Total Stock Value</h6>
                            <h4 class="card-value">$<?php echo number_format($summary['total_value'], 2); ?></h4>
                        </div>
</a>
                    </div>
                </div>
            </div>
        </div>

        
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.0/dist/xlsx.full.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#dailySalesTable').DataTable({
                order: [[0, 'desc']],
                pageLength: 25
            });
        });

        function exportToExcel() {
            const table = document.getElementById('dailySalesTable');
            const wb = XLSX.utils.table_to_book(table, {sheet: "Sales Report"});
            XLSX.writeFile(wb, `Sales_Report_${document.getElementById('start_date').value}_to_${document.getElementById('end_date').value}.xlsx`);
        }
    </script>
</body>
</html>
