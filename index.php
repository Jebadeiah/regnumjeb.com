<?php
session_start();
require_once __DIR__ . '/includes/config.php';
?>

<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>The Kingdom of Jeb</title>
  <link rel="stylesheet" href="styles/style.css">
  <link rel="stylesheet" href="css/modal.css">
  <script src="scripts/header.js" type="text/javascript" defer></script>
  <script src="js/modal.js" defer></script>
  <base href="https://www.regnumjeb.com/">
</head>

<body>
  <header-component></header-component>

  <main>

    <?php if (isset($_GET['error'])): ?>
      <div class="warning"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
      <div class="success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>

    <?php include 'auth/modal.html'; ?>

    <?php if (IS_DEV && isset($_SESSION['user_id'])): ?>
      <div style="margin-top: 20px; padding: 10px; background-color: #eef;">
        <strong>DEV MODE – Logged in as:</strong><br>
        Username: <?= htmlspecialchars($_SESSION['username']) ?><br>
        Email: <?= htmlspecialchars($_SESSION['user_email']) ?><br>
        <a href="auth/logout.php">Logout</a>
      </div>
    <?php endif; ?>
  </main>
</body>

</html>