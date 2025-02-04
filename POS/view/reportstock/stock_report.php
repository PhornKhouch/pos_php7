<?php
require_once '../../Config/conect.php';

// Set default date range to current month
$startDate = date('Y-m-01');
$endDate = date('Y-m-t');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $startDate = isset($_POST['start_date']) ? $_POST['start_date'] : $startDate;
    $endDate = isset($_POST['end_date']) ? $_POST['end_date'] : $endDate;
}


// Get detailed stock data
$stockQuery = "SELECT 
    id,
    prdname,
    prdcategroy as category,
    prdbrand as brand,
    COALESCE(stockqty, 0) as stockqty,
    COALESCE(unitcose, 0) as unit_cost,
    stockdate,
    expdate,
    unit,
    COALESCE(stockqty * unitcose, 0) as stock_value
    FROM prdmaster 
    WHERE DATE(stockdate) BETWEEN ? AND ?
    ORDER BY stockdate DESC";

$stmt = $con->prepare($stockQuery);
$stmt->bind_param("ss", $startDate, $endDate);
$stmt->execute();
$stockResults = $stmt->get_result();

// Get category-wise summary
$categoryQuery = "SELECT 
    C.name as category,
    COUNT(*) as product_count,
    COALESCE(SUM(stockqty), 0) as total_quantity,
    COALESCE(SUM(stockqty * unitcose), 0) as category_value
    FROM prdmaster M
    INNER  JOIN category C On M.prdcategroy=C.code
    WHERE DATE(stockdate) BETWEEN ? AND ?
    GROUP BY prdcategroy";

$stmt = $con->prepare($categoryQuery);
$stmt->bind_param("ss", $startDate, $endDate);
$stmt->execute();
$categoryResults = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Report</title>
    <link rel="stylesheet" href="../../Style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   
</head>
<body>
    <div class="container-fluid mt-4">
        <h2 class="mb-4">Stock Report</h2>

        <!-- Date Filter Form -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" class="row g-3">
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

        
        <!-- Category Summary -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Category Summary</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Number of Products</th>
                                <th>Total Quantity</th>
                                <th>Category Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($category = $categoryResults->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($category['category']); ?></td>
                                    <td><?php echo number_format($category['product_count']); ?></td>
                                    <td><?php echo number_format($category['total_quantity']); ?></td>
                                    <td>$<?php echo number_format($category['category_value'], 2); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Detailed Stock Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Detailed Stock List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="stockTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Stock Value</th>
                                <th>Last Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($stock = $stockResults->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($stock['id']); ?></td>
                                    <td><?php echo htmlspecialchars($stock['prdname']); ?></td>
                                    <td><?php echo number_format($stock['stockqty']); ?></td>
                                    <td>$<?php echo number_format($stock['unit_cost'], 2); ?></td>
                                    <td>$<?php echo number_format($stock['stock_value'], 2); ?></td>
                                    <td><?php echo date('Y-m-d', strtotime($stock['stockdate'])); ?></td>
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
            $('#stockTable').DataTable({
                order: [[5, 'desc']],
                pageLength: 25
            });
        });

        function exportToExcel() {
            const table = document.getElementById('stockTable');
            const wb = XLSX.utils.table_to_book(table, {sheet: "Stock Report"});
            XLSX.writeFile(wb, `Stock_Report_${document.getElementById('start_date').value}_to_${document.getElementById('end_date').value}.xlsx`);
        }
    </script>
</body>
</html>
