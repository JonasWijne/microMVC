<ol>
  <?php
  foreach ($todos as $todo) {
   echo '<li>';
   echo $todo['text'];
   echo ' <a href="index.php?page=todo-detail&amp;id=' . $todo['id'] . '">detail</a>';
   echo ' <a href="index.php?id=' . $todo['id'] . '&amp;action=delete" class="confirmation">delete</a>';
   echo '</li>';
  }
  ?>
</ol>
<?php
  if (!empty($errors)) {
    echo '<div class="error">Gelieve de verplichte velden in te vullen</div>';
  }
?>
<form method="post" action="index.php">
  <input type="hidden" name="action" value="insertTodo" />
  <div>
    <label for="inputText">text:</label>
    <input type="text" id="inputText" name="text" value="<?php
    if (!empty($_POST['text'])) {
      echo $_POST['text'];
    }
    ?>" />
    <?php
    if (!empty($errors['text'])) {
      echo '<span class="error">' . $errors['text'] . '</span>';
    }
    ?>
  </div>
  <div>
    <button type="submit">Add Todo</button>
  </div>
</form>
<script type="text/javascript">
{
  const init = () => {
    const confirmationLinks = Array.from(document.getElementsByClassName(`confirmation`));
    confirmationLinks.forEach($confirmationLink => {
      $confirmationLink.addEventListener(`click`, e => {
        if (!confirm('Are you sure?')) e.preventDefault();
      });
    });
  };
  init();

}
</script>
