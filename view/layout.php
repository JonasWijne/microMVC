<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Todos - <?php echo $title; ?></title>
  </head>
  <body>
    <main>
      <header><h1>Todos - <?php echo $title; ?></h1></header>
      <?php
      if (!empty($_SESSION['info'])) {
        echo '<div class="info">' . $_SESSION['info'] . '</div>';
      }
      if (!empty($_SESSION['error'])) {
        echo '<div class="error">' . $_SESSION['error'] . '</div>';
      }
      ?>
      <?php echo $content;?>
    </main>
  </body>
</html>
