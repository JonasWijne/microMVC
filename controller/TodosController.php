<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../dao/TodoDAO.php';
require_once __DIR__ . '/../dao/TodoCommentDAO.php';

class TodosController extends Controller {

  private $todoDAO;
  private $todoCommentDAO;

  function __construct() {
    $this->todoDAO = new TodoDAO();
    $this->todoCommentDAO = new TodoCommentDAO();
  }

  public function index() {
    if (!empty($_POST['action'])) {
      if ($_POST['action'] == 'insertTodo') {
        $this->handleInsertTodo();
      }
    }

    if (!empty($_GET['action'])) {
      if ($_GET['action'] == 'delete' && !empty($_GET['id'])) {
        $this->handleDeleteTodo();
      }
    }

    $todos = $this->todoDAO->selectAll();
    $this->set('todos', $todos);
    $this->set('title', 'Overview');
  }

  public function view() {
    if (isset($_GET['id'])) {
      $todo = $this->todoDAO->selectById($_GET['id']);
      $this->set('todo', $todo);
    }

    if (empty($todo)) {
      $_SESSION['error'] = 'De opgegeven todo bestaat niet!';
      header('Location: index.php');
      exit();
    }

    if (!empty($_POST['action']) && $_POST['action'] == 'insertComment') {
      $this->handleInsertComment($todo);
    }

    if (!empty($_GET['action'])) {
      if ($_GET['action'] == 'delete_comment' && isset($_GET['comment_id'])) {
        $this->handleDeleteComment($todo);
      }
    }

    $comments = $this->todoCommentDAO->selectByTodoId($todo['id']);
    $this->set('comments', $comments);
    $this->set('title', 'Detail');
  }

  private function handleInsertTodo() {
    $todoDAO = new TodoDAO();
    $data = array(
      'created' => date('Y-m-d H:i:s'),
      'modified' => date('Y-m-d H:i:s'),
      'checked' => 0,
      'text' => $_POST['text']
    );
    $insertTodoResult = $todoDAO->insert($data);
    if (!$insertTodoResult) {
      $errors = $todoDAO->validate($data);
      $this->set('errors', $errors);
    } else {
      $_SESSION['info'] = 'De todo werd opgeslaan!';
      header('Location: index.php');
      exit();
    }
  }

  private function handleInsertComment($todo) {
    $data['created'] = date('Y-m-d H:i:s');
    $data['modified'] = date('Y-m-d H:i:s');
    $data['todo_id'] = $todo['id'];
    $data['text'] = $_POST['text'];
    $insertedComment = $this->todoCommentDAO->insert($data);
    if (empty($insertedComment)) {
      $errors = $this->todoCommentDAO->validate($data);
      $this->set('errors', $errors);
    } else {
      $_SESSION['info'] = 'De comment werd toegevoegd!';
      header('Location: index.php?page=todo-detail&id=' . $todo['id']);
      exit();
    }
  }

  private function handleDeleteTodo() {
    $this->todoDAO->delete($_GET['id']);
    $_SESSION['info'] = 'De todo werd verwijderd!';
    header('Location: index.php');
    exit();
  }

  private function handleDeleteComment($todo) {
    $this->todoCommentDAO->delete($_GET['comment_id']);
    $_SESSION['info'] = 'De comment werd verwijderd!';
    header('Location: index.php?page=todo-detail&id=' . $todo['id']);
    exit();
  }

}
