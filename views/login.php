<h1>Log in</h1>
<form method="POST" action="?login">
  <div class="row">
    <label for="email">Email:</label>
    <input name="email" id="email" autocomplete="off" />
  </div>
  <div class="row">
    <label for="pass">Password:</label>
    <input type="password" name="pass" id="pass" />
  </div>
  <div class="row">
    <a href="?recovery">Forgot password?</a> |
    <a href="?signup">Registration</a>
  </div>
  <div class="row">
    <input type="submit" />
  </div>  
</form>