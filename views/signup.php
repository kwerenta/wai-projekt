<?php
app\Helper::showErrors();
?>
<form action="/signup" method="POST">
  <div>
    <label for="email">E-mail</label>
    <input type="email" name="email">
  </div>
  <div>
    <label for="text">Login</label>
    <input type="text" name="login">
  </div>
  <div>
    <label for="password">Password</label>
    <input type="password" name="password">
  </div>
  <div>
    <label for="password">Password confirmation</label>
    <input type="password" name="passwordConfirmation">
  </div>
  <button>Sign up</button>
</form>
<a href="/signin">Sign in</a>
