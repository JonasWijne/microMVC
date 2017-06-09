<?php

require_once( __DIR__ . '/DAO.php');

class TodoCommentDAO extends DAO {

  public function selectByTodoId($todoId){
    $sql = "SELECT * FROM `todo_comments` WHERE `todo_id` = :todo_id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':todo_id', $todoId);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function selectById($id){
    $sql = "SELECT * FROM `todo_comments` WHERE `id` = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function delete($id){
    $sql = "DELETE FROM `todo_comments` WHERE `id` = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    return $stmt->execute();
  }

  public function deleteFromTodoId($todoId){
    $sql = "DELETE FROM `todo_comments` WHERE `todo_id` = :todo_id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':todo_id', $todoId);
    return $stmt->execute();
  }

  public function insert($data) {
    $errors = $this->validate( $data );
    if (empty($errors)) {
      $sql = "INSERT INTO `todo_comments` (`created`, `modified`, `todo_id`, `text`) VALUES (:created, :modified, :todo_id, :text)";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':created', $data['created']);
      $stmt->bindValue(':modified', $data['modified']);
      $stmt->bindValue(':todo_id', $data['todo_id']);
      $stmt->bindValue(':text', $data['text']);
      if ($stmt->execute()) {
        return $this->selectById($this->pdo->lastInsertId());
      }
    }
    return false;
  }

  public function validate( $data ){
    $errors = [];
    if (!isset($data['created'])) {
      $errors['created'] = 'Gelieve created in te vullen';
    }
    if (!isset($data['modified'])) {
      $errors['modified'] = 'Gelieve modified in te vullen';
    }
    if (!isset($data['todo_id'])) {
      $errors['todo_id'] = 'Gelieve todo_id in te vullen';
    }
    if (empty($data['text']) ){
      $errors['text'] = 'Gelieve een text in te vullen';
    }
    return $errors;
  }

}
