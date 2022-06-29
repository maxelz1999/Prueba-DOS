
<?php
  session_start();
  if (isset($_SESSION['user_id'])) {
    header('Location: /php-login');
  }
  require '../db/conexion.php';

  if (!empty($_POST['correo']) && !empty($_POST['contrasena'])) {
    $records = $conn->prepare('SELECT id, correo, contrasena FROM disenadores WHERE correo = :correo')
    || die( sprintf("Error!: %s", $conn->error) );
    $records->bindParam(':correo', $_POST['correo']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $message = '';

    if (count($results) > 0 && password_verify($_POST['contrasena'], $results['contrasena'])) {
      $_SESSION['user_id'] = $results['id'];
      header("Location: /php-login");
    } else {
      $message = 'Sorry, those credentials do not match';
    }
  }

?>
<?php require '../template/header.php' ?>
    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>
    <main class="contenedor sombra">

    <h1>Login</h1>
    <span>or <a href="signup.php">SignUp</a></span>

    <form action="login.php" method="POST">
      <input name="correo" type="text" placeholder="Enter your correo">
      <input name="contrasena" type="password" placeholder="Enter your Password">
      <input type="submit" value="Submit">
    </form>
    </main>

<?php require '../template/footer.php' ?>