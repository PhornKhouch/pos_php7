<?php
include '../../root/Header.php';
session_start();
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php
    if (isset($_SESSION['msg']) != null) {
    ?>
        <script>
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
                title: "<?php echo $_SESSION['msg']; ?>"
            });
        </script>
    <?php
        unset($_SESSION['msg']);
    }
    ?>

    <div class="container mt-5 mb-2">
        <h1>General Settings</h1>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link <?php echo (!isset($_GET['page']) || $_GET['page'] == 'generalsettings') ? 'active' : ''; ?>" 
                        id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" 
                        type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                    Generate Settings
                </button>
                <button class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'telegram') ? 'active' : ''; ?>" 
                        id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" 
                        type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                    Telegram
                </button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade <?php echo (!isset($_GET['page']) || $_GET['page'] == 'generalsettings') ? 'show active' : ''; ?>" 
                 id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <?php include 'generalsettings.php'; ?>
            </div>
            <div class="tab-pane fade <?php echo (isset($_GET['page']) && $_GET['page'] == 'telegram') ? 'show active' : ''; ?>" 
                 id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <?php include 'telegram.php'; ?>
            </div>
        </div>
    </div>

    <script>
        // Activate tab based on URL parameter
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const page = urlParams.get('page');
            if (page === 'telegram') {
                document.getElementById('nav-profile-tab').click();
            }
        });

     

        $('#updateBtn').click(function() {
            var formData = new FormData($('#editForm')[0]);//get data from Form Edit
            formData.append('action', 'update');

            $.ajax({
                method: "POST",
                url: "/PHP7/POS/action/settings/actionedit.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                            title: response,
                            icon: "success",
                            draggable: false
                     }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                })
                }
            });
        });
    </script>
</body>
<?php include '../../root/Footer.php'; ?>
</html>