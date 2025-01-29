<?php
require_once '../Config/conect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container-fluid mt-4">
        
        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <?php
                                $select="SELECT COUNT(*) AS total_sales, DATE_FORMAT('2025-01-01', '%b-%Y') AS date 
                                FROM `salemaster` 
                                WHERE saledate BETWEEN '2025-01-01' AND '2025-01-31';";
                                $result = $con->query($select);
                                $row = $result->fetch_assoc();
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
                                    $Revenue="SELECT SUM(tax) AS total_revenue FROM `salemaster` WHERE saledate BETWEEN '2025-01-01' AND '2025-01-31';";
                                    $result = $con->query($Revenue);
                                    $row = $result->fetch_assoc();
                                ?>
                                <h6 class="card-title">Total Revenue</h6>
                                <h3 class="mb-0">$<?php echo $row['total_revenue']; ?></h3>
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
                                    $average="SELECT AVG(subtotal) AS total_average FROM `salemaster` WHERE saledate BETWEEN '2025-01-01' AND '2025-01-31';";
                                    $result = $con->query($average);
                                    $row = $result->fetch_assoc();
                                ?>
                                <h6 class="card-title">Average Sale</h6>
                                <h3 class="mb-0">$<?php echo round($row['total_average'],2); ?></h3>
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
                                    $avgperday="SELECT AVG(subtotal) AS total_average FROM `salemaster` WHERE saledate BETWEEN '2025-01-01' AND '2025-01-31';";
                                    $result = $con->query($avgperday);
                                    $row = $result->fetch_assoc();
                                ?>
                                <h6 class="card-title">Daily Average</h6>
                                <h3 class="mb-0">$<?php echo round($row['total_average'],2); ?></h3>
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
