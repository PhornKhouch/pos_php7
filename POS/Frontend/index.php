<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar text-white py-2">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <i class="fas fa-phone-alt me-2"></i> (855) 123 456 789
                    <i class="fas fa-envelope ms-3 me-2"></i> info@example.com
                </div>
                <div class="col-md-6 text-end">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">Product Catalog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Products</a>
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

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-3">Discover Our Products</h1>
                    <p class="lead mb-4">Quality Products at Competitive Prices</p>
                    <div class="search-box">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search products...">
                            <button class="btn btn-light" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container my-5">
        <?php
        require_once '../Config/conect.php';
        ?>

        <!-- Products Grid -->
        <div class="row">
            <?php
            try {
                $stmt = "SELECT p.*, b.name as brand_name, c.name as category_name 
                    FROM prdmaster p 
                    LEFT JOIN brand b ON p.prdbrand = b.code 
                    LEFT JOIN category c ON p.prdcategroy = c.code 
                    WHERE p.isactive = 'A'
                    ORDER BY p.prdname";
                $result = $con->query($stmt);
                $products = [];
                
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $products[] = $row;
                    }
                }

                if (count($products) > 0) {
                    foreach($products as $product) 
                    {
                        $photo = '../Upload/brand/' . (!empty($product['photo']) ? $product['photo'] : 'default.jpg');
                        if (!file_exists($photo)) {
                            $photo = '../Upload/brand/default.jpg';
                        }
                        ?>
                        <div class="col-md-4 col-lg-3 mb-4">
                            <div class="product-card">
                                <div class="product-image">
                                    <img src="<?php echo htmlspecialchars($photo); ?>" 
                                         alt="<?php echo htmlspecialchars($product['prdname']); ?>"
                                         onerror="this.src='../Upload/brand/default.jpg'">
                                    <div class="product-overlay">
                                        <a href="product-details.php?id=<?php echo htmlspecialchars($product['id']); ?>" 
                                           class="btn btn-light">View Details</a>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h3 class="product-title"><?php echo htmlspecialchars($product['prdname']); ?></h3>
                                    <div class="product-meta">
                                        <span class="badge"><?php echo htmlspecialchars($product['brand_name']); ?></span>
                                        <span class="badge"><?php echo htmlspecialchars($product['category_name']); ?></span>
                                    </div>
                                    <div class="product-price">
                                        $<?php echo number_format($product['unitcose'], 2); ?>
                                        <small class="text-muted">/<?php echo htmlspecialchars($product['unit']); ?></small>
                                    </div>
                                    <div class="stock">
                                        <i class="fas fa-box me-1"></i> Stock Date: <?php echo date('M d, Y', strtotime($product['stockdate'])); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<div class="col-12"><div class="alert alert-info">No products found.</div></div>';
                }
            } catch(PDOException $e) {
                echo '<div class="alert alert-danger">Error loading products: ' . htmlspecialchars($e->getMessage()) . '</div>';
            }
            ?>
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
                        <li class="mb-2"><a href="#">Home</a></li>
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
    <script>
        // Search functionality
        document.querySelector('.search-box input').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            document.querySelectorAll('.product-card').forEach(card => {
                const title = card.querySelector('.product-title').textContent.toLowerCase();
                const brand = card.querySelector('.badge').textContent.toLowerCase();
                const parentCol = card.closest('.col-md-4');
                
                if (title.includes(searchText) || brand.includes(searchText)) {
                    parentCol.style.display = '';
                } else {
                    parentCol.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>