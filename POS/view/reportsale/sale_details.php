<?php
require_once '../../Config/conect.php';

// Set default date range to current month
$startDate = date('Y-m-01');
$endDate = date('Y-m-t');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $startDate = isset($_POST['start_date']) ? $_POST['start_date'] : $startDate;//short form (ternary operator)
    $endDate = isset($_POST['end_date']) ? $_POST['end_date'] : $endDate;
}

// Get summary data
$summaryQuery = "SELECT 
    COUNT(DISTINCT id) as total_sales,
    SUM(subtotal) as total_subtotal,
    SUM(tax) as total_tax,
    SUM(total) as grand_total,
    COUNT(DISTINCT DATE(saledate)) as total_days
    FROM salemaster 
    WHERE DATE(saledate) BETWEEN ? AND ?";

$stmt = $con->prepare($summaryQuery);
$stmt->bind_param("ss", $startDate, $endDate);
$stmt->execute();
$summary = $stmt->get_result()->fetch_assoc();

// Get daily sales data
$dailyQuery = "SELECT 
    DATE(saledate) as sale_date,
    COUNT(*) as num_sales,
    SUM(subtotal) as daily_subtotal,
    SUM(tax) as daily_tax,
    SUM(total) as daily_total
    FROM salemaster 
    WHERE DATE(saledate) BETWEEN ? AND ?
    GROUP BY DATE(saledate)
    ORDER BY sale_date DESC";

$stmt = $con->prepare($dailyQuery);
$stmt->bind_param("ss", $startDate, $endDate);
$stmt->execute();
$dailyResults = $stmt->get_result();

// Get payment method summary
$paymentQuery = "SELECT 
    paymentmethod,
    COUNT(*) as count,
    SUM(total) as total_amount
    FROM salemaster 
    WHERE DATE(saledate) BETWEEN ? AND ?
    GROUP BY paymentmethod";

$stmt = $con->prepare($paymentQuery);
$stmt->bind_param("ss", $startDate, $endDate);
$stmt->execute();
$paymentResults = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <link rel="stylesheet" href="../../Style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container-fluid mt-4">
        <h2 class="mb-4">Sales Report</h2>

        <!-- Date Filter Form -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" class="row g-3" action="sale_details.php">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $startDate; ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo $endDate; ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary form-control">Generate Report</button>
                    </div>
                </form>
            </div>
        </div>

        

        <!-- Payment Methods Summary -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Payment Methods Summary</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Payment Method</th>
                                <th>Number of Transactions</th>
                                <th>Total Amount</th>
                                <th>Average Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($payment = $paymentResults->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($payment['paymentmethod']); ?></td>
                                    <td><?php echo number_format($payment['count']); ?></td>
                                    <td>$<?php echo number_format($payment['total_amount'], 2); ?></td>
                                    <td>$<?php echo number_format($payment['total_amount'] / $payment['count'], 2); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Daily Sales Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Daily Sales</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dailySalesTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Number of Sales</th>
                                <th>Subtotal</th>
                                <th>Tax</th>
                                <th>Total</th>
                                <th>Average Sale</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($daily = $dailyResults->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo date('Y-m-d', strtotime($daily['sale_date'])); ?></td>
                                    <td><?php echo number_format($daily['num_sales']); ?></td>
                                    <td>$<?php echo number_format($daily['daily_subtotal'], 2); ?></td>
                                    <td>$<?php echo number_format($daily['daily_tax'], 2); ?></td>
                                    <td>$<?php echo number_format($daily['daily_total'], 2); ?></td>
                                    <td>$<?php echo number_format($daily['daily_total'] / $daily['num_sales'], 2); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Export Buttons -->
        <div class="text-end mt-4 mb-4">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print"></i> Print Report
            </button>
            <button onclick="exportToExcel()" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Export to Excel
            </button>
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
