<?php
// force redirect!
if (!isset($_POST['ids'])) {
    header('Location: /');
    exit;
}

use App\Models\User;

require 'bootstrap.php';

checkSessionRedirect(SESSION_UID, PAGE_LOCATION_LOGIN);

/**
 * fetch user details
 */
$user = User::find($_POST['ids']);

if (empty($user)) {
    // Invalid user print error
    echo 'Unknown user id';
    exit;
}
?>

<div class="form-group">
    <label for="fname">Full Name:</label>
    <input type="text" class="form-control" id="fname" name="fname" value="<?= $user->full_name ?>" required placeholder="Enter Full Name">
</div>
<div class="form-group">
    <label for="upass">Password:</label>
    <input type="text" class="form-control" id="upass" name="upass" value="<?= $user->password ?>" required placeholder="Password">
</div>
<div class="form-group">
    <label for="phone">Phone:</label>
    <input type="text" class="form-control" id="phone" name="phone" value="<?= $user->phone ?>" required placeholder="Phone">
</div>
