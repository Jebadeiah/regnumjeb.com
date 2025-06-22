<?php
require_once '../src/connection.php';

session_start();

if (isset($_SESSION['user'])) {
    header("location: ../index.php");
}

if (isset($_REQUEST['register_btn'])) {

    $alias = filter_var($_REQUEST['alias'], FILTER_SANITIZE_STRING);
    $email = filter_var(strtolower($_REQUEST['email']), FILTER_SANITIZE_EMAIL);
    $password = strip_tages($_REQUEST['password']);
    $conf_password = strip_tages($_REQUEST['conf_password']);

    if (empty($alias)) {
        $errorMsg[0][] = 'Name required';
    }

    if (empty($email)) {
        $errorMsg[1][] = 'Email address required';
    }

    if (empty($password)) {
        $errorMsg[2][] = 'Password required';
    }

    if (strlen($password) < 12) {
        $errorMsg[3][] = 'Make a decent password, please. Like... at least 12 characters.';
    }

    if (empty($conf_password)) {
        $errorMsg[4][] = 'Password confirmation required';
    }

    if (empty($errorMsg)) {
        try {
            $select_stmt = $db->prepare("SELECT alias,email FROM person WHERE email = :email");
            $select_stmt->execute([':email' => $email]);
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

            if (isset($row['email']) == $email) {
                $errorMsg[1][] = "This Email address has already been used. Please choose another or login.";
            } elseif ($password != $conf_password) {
                $errorMsg[4][] = "The Passwords don't match.";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $created = new DateTime();
                $created = $created->format('Y-m-d H:i:s');

                $insert_stmt = $db->prepare("INSERT INTO person (alias,email,password,created) VALUES (:alias,:email,:password,:created");

                if (
                    $insert_stmt->execute(
                        [
                            ':alias' => $email,
                            ':email' => $email,
                            ':password' => $hashed_password,
                            ':created' => $created,
                        ]
                    )
                ) {
                    header("location: ../index.php?msg=" . urlencode('You should have gotten a verification email from us; click the link in that email, first'));
                }
            }
        } catch (PDOException $e) {
            $pdoError = $e->getMessage();
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Kingdom of Jeb</title>
    <link rel="stylesheet" href="../styles/style.css">
    <script src="../scripts/header.js" type="text/javascript" defer></script>
    <base href="https://www.regnumjeb.com/">
</head>

<body>
    <header-component></header-component>
    <main>
        <form action="/" method="post">
            <div class="signin_form">
                <?php
                if (isset($errorMsg[0])) {
                    foreach ($errorMsg[0] as $aliasErrors) {
                        echo "<p class=;small text-danger'>" . $aliasErrors . "</p>";
                    }
                }
                ?>
                <label for="alias" class="form-label">Alias</label>
                <input type="text" name="alias" class="form-control" placeholder="">
            </div>
            <div class="signin_form_element">
                <?php
                if (isset($errorMsg[1])) {
                    foreach ($errorMsg[1] as $emailErrors) {
                        echo "<p class=;small text-danger'>" . $emailErrors . "</p>";
                    }
                }
                ?>
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" placeholder="">
            </div>
            <div class="signin_form_element">
                <?php
                if (isset($errorMsg[2])) {
                    foreach ($errorMsg[2] as $passwordErrors) {
                        echo "<p class=;small text-danger'>" . $passwordErrors . "</p>";
                    }
                }
                ?>
                <?php
                if (isset($errorMsg[3])) {
                    foreach ($errorMsg[3] as $passwordErrors) {
                        echo "<p class=;small text-danger'>" . $passwordErrors . "</p>";
                    }
                }
                ?>
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="">
            </div>
            <div class="signin_form_element">
                <?php
                if (isset($errorMsg[4])) {
                    foreach ($errorMsg[4] as $$conf_passwordErrors) {
                        echo "<p class=;small text-danger'>" . $conf_passwordErrors . "</p>";
                    }
                }
                ?>
                <label for="conf_password" class="form-label">Confirm Password</label>
                <input type="password" name="conf_password" class="form-control" placeholder="">
            </div>

            <button type="submit" name="register_btn" class="btn btn-primary">Register</button>
        </form>
        Already Have An Account? <a class="login" href="../"> Then Log In, Silly!</a>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </main>
</body>

</html>