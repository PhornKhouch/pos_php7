<?php 
include '../../root/Header.php';
include '../../Config/conect.php';
?>
<div class="container mt-5 mb-2">
    <!-- Add New Telegram Settings Form -->
    <form action="/PHP7/POS/action/settings/actiontelegram.php" method="post">
        <div class="row">
            <div class="col-6">
                <label for="token" class="form-label">Token</label>
                <input type="text" class="form-control" id="token" name="token" required>
            </div>
            <div class="col-6">
                <label for="chatid" class="form-label">Chat ID</label>
                <input type="text" class="form-control" id="chatid" name="chatid" required>
            </div>
            <div class="col-6 mt-3">
                <label for="groupid" class="form-label">Group ID</label>
                <input type="text" class="form-control" id="groupid" name="groupid" required>
            </div>
            <div class="col-6 mt-3">
                <label for="status" class="form-label">Status</label>
                <input type="text" class="form-control" id="status" name="status" required maxlength="6">
            </div>
            <div class="col-6 mt-3">
                <div class="form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="IsAlert" name="IsAlert" style="width: 3em; height: 1.5em; cursor: pointer;">
                    <label class="form-check-label ms-2" for="IsAlert" style="font-size: 1.1em; cursor: pointer;margin-left: 30px;"> Is Alert</label>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-6">
                <input type="submit" name="btnsave" class="btn btn-primary" value="Save Changes">
            </div>
        </div>
    </form>

    <!-- Telegram Settings Table -->
    <table id="example" class="table table-bordered mt-5" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Token</th>
                <th>Chat ID</th>
                <th>Group ID</th>
                <th>Status</th>
                <th>IsAlert</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $select = "SELECT * FROM `telegram`";
            $result = $con->query($select);
            $counter = 1;
            while ($row = $result->fetch_assoc()) {
            ?>
                <tr>
                    <td><?php echo $counter++; ?></td>
                    <td><?php echo htmlspecialchars($row['token']); ?></td>
                    <td><?php echo htmlspecialchars($row['chatid']); ?></td>
                    <td><?php echo htmlspecialchars($row['groupid']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td><?php echo htmlspecialchars($row['IsAlert']); ?></td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm edit-btn" 
                                data-bs-toggle="modal" 
                                data-bs-target="#telegramEditModal"
                                data-id="<?php echo $row['id']; ?>"
                                data-token="<?php echo htmlspecialchars($row['token']); ?>"
                                data-chatid="<?php echo htmlspecialchars($row['chatid']); ?>"
                                data-groupid="<?php echo htmlspecialchars($row['groupid']); ?>"
                                data-status="<?php echo htmlspecialchars($row['status']); ?>"
                                data-isalert="<?php echo htmlspecialchars($row['IsAlert']); ?>">
                            Edit
                        </button>
                        <a href="/PHP7/POS/action/settings/actiontelegram.php?id=<?php echo $row['id']; ?>&action=btndelete" class="btn btn-danger btn-sm">Delete</a>    
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Telegram Edit Modal -->
<div class="modal" id="telegramEditModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Edit Telegram Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/PHP7/POS/action/settings/actiontelegram.php" method="post">
                <div class="modal-body px-4 py-3">
                    <input type="hidden" id="edit_id" name="id">
                    
                    <div class="mb-3">
                        <label for="edit_token" class="form-label">Token</label>
                        <input type="text" class="form-control" id="edit_token" name="token" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_chatid" class="form-label">Chat ID</label>
                        <input type="text" class="form-control" id="edit_chatid" name="chatid" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_groupid" class="form-label">Group ID</label>
                        <input type="text" class="form-control" id="edit_groupid" name="groupid" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Status</label>
                        <input type="text" class="form-control" id="edit_status" name="status" required maxlength="6">
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="edit_IsAlert" name="IsAlert" style="width: 3em; height: 1.5em; cursor: pointer;">
                            <label class="form-check-label ms-2" for="edit_IsAlert" style="font-size: 1.1em; cursor: pointer;margin-left: 30px;"> Is Alert</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="btnsave" class="btn btn-primary px-4">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all elements with class edit-btn
    var editButtons = document.getElementsByClassName('edit-btn');
    
    // Add click event listener to each edit button
    Array.from(editButtons).forEach(function(button) {
        button.addEventListener('click', function() {
            // Get data from button attributes
            var id = this.getAttribute('data-id');
            var token = this.getAttribute('data-token');
            var chatid = this.getAttribute('data-chatid');
            var groupid = this.getAttribute('data-groupid');
            var status = this.getAttribute('data-status');
            var isAlert = this.getAttribute('data-isalert');
            
            // Set values in modal form
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_token').value = token;
            document.getElementById('edit_chatid').value = chatid;
            document.getElementById('edit_groupid').value = groupid;
            document.getElementById('edit_status').value = status;
            document.getElementById('edit_IsAlert').checked = isAlert == '1';
        });
    });
});
</script>

<?php
// Check for success or error messages from the action page
if (isset($_GET['success'])) {
    echo "<script>
        Swal.fire({
            title: 'Success!',
            text: 'Telegram settings updated successfully',
            icon: 'success',
            timer: 2000,
            showConfirmButton: false
        });
    </script>";
}
if (isset($_GET['error'])) {
    echo "<script>
        Swal.fire({
            title: 'Error!',
            text: 'Something went wrong',
            icon: 'error'
        });
    </script>";
}
?>
<?php include '../../root/Footer.php'; ?>
</html>