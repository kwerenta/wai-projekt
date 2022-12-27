<?php
if (isset($_SESSION['errors'])) {
  foreach ($_SESSION["errors"] as $error) {
    echo "<p>$error</p>";
  }
  unset($_SESSION['errors']);
}
?>
<form action="/signin" method="POST">
  <div>
    <label for="text">Login</label>
    <input type="text" name="login">
  </div>
  <div>
    <label for="password">Password</label>
    <input type="password" name="password">
  </div>
  <button>Sign in</button>
</form>
<a href="/signup">Sign up</a>
