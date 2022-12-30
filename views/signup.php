<h1>Create new account</h1>
<?php app\Helper::showErrors(); ?>
<form action="/signup" method="POST">
  <div class="form-container">
    <div class="input-group">
      <label for="email">E-mail</label>
      <input type="email" name="email" id="email" required>
    </div>
    <div class="input-group">
      <label for="login">Login</label>
      <input type="text" name="login" id="login" required>
    </div>
    <div class="input-group">
      <label for="password">Password</label>
      <input type="password" name="password" id="password" required>
    </div>
    <div class="input-group">
      <label for="password">Password confirmation</label>
      <input type="password" name="passwordConfirmation" id="passwordConfirmation" required>
    </div>
    <button>Sign up</button>
  </div>
</form>
<a href="/signin" class="form-link">Sign in</a>
