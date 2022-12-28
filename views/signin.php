<?php
app\Helper::showErrors();
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
