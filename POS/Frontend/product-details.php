<?php
require_once '../Config/conect.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit;
}

try {
    $query = "SELECT p.*, b.name as brand_name, c.name as category_name 
        FROM prdmaster p 
        LEFT JOIN brand b ON p.prdbrand = b.code 
        LEFT JOIN category c ON p.prdcategroy = c.code 
        WHERE p.isactive = 'A' AND p.id = ?";
    
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();//result to array 

    if (!$product) {
        header('Location: index.php');
        exit;
    }

    $photo = '../Upload/brand/' . (!empty($product['photo']) ? $product['photo'] : 'default.jpg');
    if (!file_exists($photo)) {
        $photo = '../Upload/brand/default.jpg';
    }
} catch(Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['prdname']); ?> - Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">Product Catalog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Product Details Section -->
    <main class="container my-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($product['prdname']); ?></li>
            </ol>
        </nav>

        <div class="row">
            <!-- Product Image -->
            <div class="col-md-6 mb-4">
                <div class="product-detail-image">
                    <img src="<?php echo htmlspecialchars($photo); ?>" 
                         alt="<?php echo htmlspecialchars($product['prdname']); ?>"
                         class="img-fluid"
                         onerror="this.src='../Upload/brand/default.jpg'">
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-md-6">
                <h1 class="product-detail-title mb-3"><?php echo htmlspecialchars($product['prdname']); ?></h1>
                
                <div class="product-meta mb-4">
                    <span class="badge"><?php echo htmlspecialchars($product['brand_name']); ?></span>
                    <span class="badge"><?php echo htmlspecialchars($product['category_name']); ?></span>
                </div>

                <div class="product-price-large mb-4">
                    $<?php echo number_format($product['unitcose'], 2); ?>
                    <small class="text-muted">/<?php echo htmlspecialchars($product['unit']); ?></small>
                </div>

                <div class="product-details-info mb-4">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <strong>Stock Quantity:</strong>
                            <p class="mb-0">100 <?php echo htmlspecialchars($product['unit']); ?></p>
                        </div>
                        <div class="col-6 mb-3">
                            <strong>Stock Date:</strong>
                            <p class="mb-0"><?php echo date('M d, Y', strtotime($product['stockdate'])); ?></p>
                        </div>
                        <div class="col-6 mb-3">
                            <strong>Created On:</strong>
                            <p class="mb-0"><?php echo date('M d, Y', strtotime($product['createdon'])); ?></p>
                        </div>
                        <div class="col-6 mb-3">
                            <strong>Last Updated:</strong>
                            <p class="mb-0"><?php echo date('M d, Y', strtotime($product['changedon'])); ?></p>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button class="btn btn-primary btn-lg">
                        <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                    </button>
                    <button class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-heart me-2"></i>Add to Wishlist
                    </button>
                </div>
            </div>
        </div>

        <!-- Additional Details -->
        <div class="row mt-5">
            <div class="col-12">
                <ul class="nav nav-tabs" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description">
                            Description
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications">
                            Specifications
                        </button>
                    </li>
                </ul>
                <div class="tab-content p-4 border border-top-0" id="productTabsContent">
                    <div class="tab-pane fade show active" id="description">
                        <p>Product description and details will go here.</p>
                    </div>
                    <div class="tab-pane fade" id="specifications">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Brand</th>
                                        <td><?php echo htmlspecialchars($product['brand_name']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Category</th>
                                        <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Unit</th>
                                        <td><?php echo htmlspecialchars($product['unit']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Stock Quantity</th>
                                        <td><?php echo number_format($product['stockqty']); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3">About Us</h5>
                    <p>Your trusted source for quality products. We provide the best selection of products at competitive prices.</p>
                    <div class="social-links mt-3">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="footer-links">
                        <li class="mb-2"><a href="index.php">Home</a></li>
                        <li class="mb-2"><a href="#">Products</a></li>
                        <li class="mb-2"><a href="#">Categories</a></li>
                        <li class="mb-2"><a href="#">About Us</a></li>
                        <li class="mb-2"><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3">Contact Info</h5>
                    <ul class="contact-info">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> 123 Street, Phnom Penh, Cambodia</li>
                        <li class="mb-2"><i class="fas fa-phone-alt me-2"></i> (855) 123 456 789</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@example.com</li>
                    </ul>
                </div>
            </div>
            <div class="row mt-4 pt-4 border-top">
                <div class="col text-center">
                    <p class="mb-0">&copy; <?php echo date('Y'); ?> ClubCode. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
