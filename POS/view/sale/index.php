<?php
    include ('../../Config/conect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point of Sale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Left Panel - Sale Information -->
            <div class="col-md-4 left-panel">
                <div class="card">
                    <div class="card-header">
                        <h4>Sale Information</h4>
                    </div>
                    <div class="card-body">
                        <!-- Sale Details Form -->
                        <form id="saleForm">
                            <div class="mb-3">
                                <label for="invoice" class="form-label">Invoice No</label>
                                <input type="text" class="form-control" id="invoice" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Payment Method</label>
                                <select class="form-control" id="paymentMethod">
                                    <?php
                                        $select = "SELECT * FROM setting Where status = 'A'";
                                        $result = $con->query($select);
                                        while($row = $result->fetch_assoc()) {
                                            ?>
                                            <option value="<?php echo $row['payment_method']; ?>"><?php echo $row['payment_method']; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <!-- Cart Items will be displayed here -->
                            <div id="cartItems" class="cart-items">
                            
                            </div>
                            <!-- Total Section -->
                            <div class="total-section">
                                <div class="d-flex justify-content-between mb-2">
                                    <h5>Subtotal:</h5>
                                    <span id="subtotal">0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <h5>Tax:</h5>
                                    <span id="tax">0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <h4>Total:</h4>
                                    <span id="total">0.00</span>
                                </div>
                                <button type="button" class="btn btn-primary w-100" id="checkoutBtn">Process Payment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Panel - Product Listing -->
            <div class="col-md-8 right-panel">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Products</h4>
                            <input type="text" class="form-control w-50" id="searchProduct" placeholder="Search products...">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row" id="productList">
                            <?php

                            // Get all products
                            $sql = "SELECT id, prdname, prdcategroy, prdbrand, stockqty, unitcose, photo FROM prdmaster WHERE isactive = 'A'";
                            $result = $con->query($sql);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    ?>
                                    <div class="col-md-4 product-card" data-id="<?php echo $row['id']; ?>" data-price="<?php echo $row['unitcose']; ?>">
                                        <div class="card">
                                            <img src="../../Upload/brand/<?php echo $row['photo']; ?>" class="card-img-top" alt="Product Image">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo $row['prdname']; ?></h5>
                                                <p class="card-text">Quantity: <?php echo $row['stockqty']; ?></p>
                                                <p class="card-text">Price: $<?php echo $row['unitcose']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            $con->close();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            let cart = [];

            // Generate invoice number
            $('#invoice').val('INV-' + Date.now());

            // Add product to cart
            $(document).on('click', '.product-card', function() {
                const productId = $(this).data('id');
                const price = $(this).data('price');
                const name = $(this).find('h5').text();

                const existingItem = cart.find(item => item.id === productId);
                if (existingItem) {
                    existingItem.quantity++;
                } else {
                    cart.push({
                        id: productId,
                        name: name,
                        price: price,
                        quantity: 1
                    });
                }
                updateCart();
            });

            // Update cart display
            function updateCart() {
                let subtotal = 0;
                $('#cartItems').empty();

                cart.forEach(item => {
                    const itemTotal = item.price * item.quantity;
                    subtotal += itemTotal;
                    var productInfo = `
                        <div class="cart-item">
                            <div class="d-flex justify-content-between">
                                <span>${item.name}</span>
                                <span>$${itemTotal.toFixed(2)}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="quantity-controls">
                                    <button class="btn btn-sm btn-secondary decrease-qty" data-id="${item.id}">-</button>
                                    <span class="mx-2">${item.quantity}</span>
                                    <button class="btn btn-sm btn-secondary increase-qty" data-id="${item.id}">+</button>
                                </div>
                                <button class="btn btn-sm btn-danger remove-item" data-id="${item.id}">Remove</button>
                            </div>
                        </div>
                    `;
                    $('#cartItems').append(productInfo);
                });

                const tax = subtotal * 0.1; // 10% tax
                const total = subtotal + tax;

                $('#subtotal').text('$' + subtotal.toFixed(2));
                $('#tax').text('$' + tax.toFixed(2));
                $('#total').text('$' + total.toFixed(2));
            }

            // Quantity controls
            $(document).on('click', '.increase-qty', function(e) {
                e.stopPropagation();
                const id = $(this).data('id');
                const item = cart.find(item => item.id === id);
                if (item) {
                    item.quantity++;
                    updateCart();
                }
            });

            $(document).on('click', '.decrease-qty', function(e) {
                e.stopPropagation();
                const id = $(this).data('id');
                const item = cart.find(item => item.id === id);
                if (item && item.quantity > 1) {
                    item.quantity--;
                    updateCart();
                }
            });

            // Remove item
            $(document).on('click', '.remove-item', function(e) {
                e.stopPropagation();
                const id = $(this).data('id');
                cart = cart.filter(item => item.id !== id);
                updateCart();
            });

            // Search products
            $('#searchProduct').on('input', function() {
                const searchTerm = $(this).val().toLowerCase();
                $('.product-card').each(function() {
                    const productName = $(this).find('h5').text().toLowerCase();
                    $(this).closest('.col-md-4').toggle(productName.includes(searchTerm));
                });
            });

            // Process Payment
            $(document).ready(function() {
                console.log('Document ready');
                
                $('#checkoutBtn').on('click', function(e) {
                    e.preventDefault();
                    console.log('Checkout button clicked');
                    console.log('Cart contents:', cart);
                    
                    if (cart.length === 0) {
                        alert('Please add items to cart before proceeding with payment');
                        return;
                    }

                    try {
                        const paymentData = {
                            invoice: $('#invoice').val(),
                            saleDate: $('#date').val(),
                            items: cart,
                            subtotal: parseFloat($('#subtotal').text().replace('$', '')),
                            tax: parseFloat($('#tax').text().replace('$', '')),
                            total: parseFloat($('#total').text().replace('$', '')),
                            paymentMethod: $('#paymentMethod').val()
                        };
                        
                        console.log('Payment data:', paymentData);

                        // Disable checkout button and show loading state
                        const $btn = $(this);
                        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...');

                        // Send payment data to server using jQuery AJAX instead of fetch
                        $.ajax({
                            url: 'process_payment.php',
                            method: 'POST',
                            data: JSON.stringify(paymentData),
                            contentType: 'application/json',
                            dataType: 'json',
                            success: function(data) {
                                console.log('Server response:', data);
                                if (data.success) {
                                    const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    }
                                });
                                Toast.fire({
                                    icon: "success",
                                    title: "Payment processed successfully!"
                                });
                                    // Reset cart and form
                                    cart = [];
                                    updateCart();
                                    $('#invoice').val('INV-' + Date.now());
                                    $('#date').val(new Date().toISOString().split('T')[0]);
                                } else {
                                    throw new Error(data.message || 'Unknown error occurred');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX Error:', {xhr: xhr, status: status, error: error});
                                alert('Error processing payment: ' + (xhr.responseJSON?.message || error || 'Unknown error'));
                            },
                            complete: function() {
                                $btn.prop('disabled', false).text('Process Payment');
                            }
                        });
                    } catch (error) {
                        console.error('Error preparing payment:', error);
                        alert('Error preparing payment: ' + error.message);
                        $btn.prop('disabled', false).text('Process Payment');
                    }
                });
            });
        });
    </script>
</body>
</html>