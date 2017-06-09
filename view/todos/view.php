<p><a href="index.php">Terug naar overzicht</a></p>
<?php
if (empty($todo)) {
  echo '<p>Deze todo kon niet gevonden worden</p>';
} else {
  echo '<p>Todo: ' . $todo['text'] . ' (' . $todo['created'] . ')</p>';
  echo '<section>';
  echo '<header><h2>Comments op deze todo:</h2></header>';

  if (empty($comments)) {
    echo '<p>Er werden nog geen comments geplaatst</p>';
  } else {
    echo '<ol>';
    foreach ($comments as $comment) {
      echo '<li>';
      echo $comment['created'];
      echo ': ';
      echo $comment['text'];
      echo ' <a href="index.php?page=todo-detail&amp;id=' . $todo['id'] . '&amp;action=delete_comment&amp;comment_id=' . $comment['id'] . '" class="confirmation">delete</a>';
      echo '</li>';
    }
    echo '</ol>';
  }
  echo '</section>';

  if (!empty($errors)) {
    echo '<div class="error">Gelieve de verplichte velden in te vullen</div>';
  }
?>
<form method="post" action="index.php?page=todo-detail&amp;id=<?php echo $todo['id'];?>">
  <input type="hidden" name="action" value="insertComment" />
  <div>
    <label for="inputText">comment:</label>
    <textarea id="inputText" name="text"><?php
    if (!empty($_POST['text'])) {
      echo $_POST['text'];
    }
    ?></textarea>
    <?php
    if (!empty($errors['text'])) {
      echo '<span class="error">' . $errors['text'] . '</span>';
    }
    ?>
  </div>
  <div>
    <button type="submit">Add Comment</button>
  </div>
</form>
<?php
}
?>
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
