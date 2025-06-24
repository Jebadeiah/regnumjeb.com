<?php
session_start();
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';
auto_login_from_cookie();
?>

<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>The Kingdom of Jeb</title>
  <link rel="stylesheet" href="styles/style.css">
  <link rel="stylesheet" href="styles/modal.css">
  <script src="scripts/header.js" type="text/javascript" defer></script>
  <script src="scripts/modal.js" defer></script>
  <base href="https://www.regnumjeb.com/">
</head>

<body>
  <header-component></header-component>

  <main id="pageContent">
    <?php
    $success = $_SESSION['success'] ?? null;
    unset($_SESSION['success']);

    $error = $_GET['error'] ?? ($_SESSION['error'] ?? null);
    unset($_SESSION['error']);
    ?>

    <?php if ($success): ?>
      <div class="success-message"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
      <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php include 'auth/modal.html'; ?>

    <?php if (IS_DEV && isset($_SESSION['user_id'])): ?>
      <div style="margin-top: 20px; padding: 10px; background-color: #eef;">
        <p>WUTANG</p>
        <strong>DEV MODE – Logged in as:</strong><br>
        Username: <?= htmlspecialchars($_SESSION['username']) ?><br>
        Email: <?= htmlspecialchars($_SESSION['user_email']) ?><br>
        <a href="auth/logout.php">Logout</a>
      </div>
    <?php endif; ?>
  </main>
</body>

</html>