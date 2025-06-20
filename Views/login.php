<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Connexion</title>
  <style>
    body {
      background-color: #fff8e1;
      font-family: Arial, sans-serif;
      color: #ff9800;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .login-container {
      background-color: #ffb300;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 0 10px #ff9800cc;
      width: 320px;
      box-sizing: border-box;
      color: white;
      text-align: center;
    }

    input[type="email"],
    .password-wrapper input {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 6px;
      font-size: 1rem;
      margin-bottom: 15px;
      box-sizing: border-box;
    }

    .password-wrapper {
      position: relative;
      width: 100%;
    }

    .password-wrapper .toggle-password {
      position: absolute;
      top: 35%;
      right: 0.8rem;
      transform: translateY(-50%);
      cursor: pointer;
      font-size: 1.2rem;
      color: #e67e22;
      user-select: none;
    }

    button {
      background-color: #ffa000;
      border: none;
      padding: 12px;
      width: 100%;
      font-size: 1rem;
      color: white;
      font-weight: bold;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #ff6f00;
    }

    .alert {
      background-color: #f44336;
      padding: 10px;
      border-radius: 6px;
      margin-bottom: 15px;
      color: white;
      font-weight: bold;
    }

    ::placeholder {
      color: #ffe082;
    }

    
  </style>
</head>
<body>

<div class="login-container">
  <h2>Connexion</h2>

  <?php if (!empty($error)) : ?>
    <div class="alert"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <input type="email" name="email" placeholder="Email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
    
    <div class="password-wrapper">
      <input type="password" id="password" name="password" required placeholder="Mot de passe">
      <span class="toggle-password" onclick="togglePasswordVisibility()">👁️</span>
    </div>

    <button type="submit">Se connecter</button>
  </form>
</div>

<script>
  function togglePasswordVisibility() {
    const passwordInput = document.getElementById("password");
    const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
    passwordInput.setAttribute("type", type);
  }
</script>

</body>
</html>
