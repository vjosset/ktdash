<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
	global $dbcon;
  
	$me = Session::CurrentUser();
	if ($me == null || $me->userid != 'vince') {
		// They shouldn't be here
		header('HTTP/1.0 403 Not Authorized');
		header("Location: https://old.ktdash.app/rosters.php");
		die();
	}

  /*
    1. Get input username
    2. Validate/find user record
    3. Generate new temporary password
    4. Update user record
    5. Display temporary password
  */

  $username = getIfSet($_REQUEST['username'], '');

  if ($username != '') {
    $user = User::FromName($username);
    if (!$user) {
      $usererror = "User not found";
    } else {
      $newpassword = CommonUtils\shortId(8);
      $newpasshash = password_hash($newpassword, PASSWORD_DEFAULT);

      $user->passhash = $newpasshash;
      $user->DBSave();
    }
  }
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
			include "header.shtml";
			$pagetitle = "Reset user password";
			$pagedesc  = "Reset user password";
			$pagekeywords = "";
			$pageimg   = "";
			$pageurl   = "https://old.ktdash.app/resetuserpassword.php";
		?>
  </head>
  <body ng-app="kt" ng-controller="ktCtrl">
		<?php include "topnav.shtml"; ?>
		<style><?php include "css/styles.css"; ?></style>
    <div class="container">
      <form action="resetuserpassword.php" method="POST">
        <h4>Username</h4>
        <input type="text" name="username" id="username" value="<?php echo $username ?>" />
        <input type="submit" value="Reset Password"/>
      </form>

      <?php
        if ($username != '') {
          if ($newpassword) {
          ?>
            New password: <code><?php echo $newpassword ?></code>
          <?php
          }
          if ($usererror) {
            ?>
            <strong>Error: </strong> <?php echo $usererror ?>
            <?php
          }
        }
      ?>
    </div>
  </body>
</html>
