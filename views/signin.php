<h1>Sign in to your account</h1>
<?php app\Helper::showErrors(); ?>
<form action="/signin" method="POST">
  <div class="form-container">
    <div class="input-group">
      <label for="login">Login</label>
      <input type="text" name="login" id="login" required>
    </div>
    <div class="input-group">
      <label for="password">Password</label>
      <input type="password" name="password" id="password" required>
    </div>
    <button>Sign in</button>
  </div>
</form>
<a href="/signup" class="form-link">Sign up</a>
