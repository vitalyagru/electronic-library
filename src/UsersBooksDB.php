<?php
namespace Binary_studio;

class UsersBooksDB {
  private $_db;

  function __construct ($host, $user, $pass) {

    $this->_db = new \PDO ($host, $user, $pass);
  }

  function getUserAgeCountBooks($age, $countBook) {
    $sql = 'SELECT u.first_name, u.last_name, u.age, count(ub.user_id) as count_books FROM users  AS u
    JOIN users_books AS ub ON u.id = ub.user_id
    JOIN books AS b ON b.id = ub.book_id
    WHERE u.age >= ' . $age . '   GROUP BY u.id HAVING COUNT(ub.user_id) > ' . $countBook;
    return  $this->_db->query($sql);
  }

  function getUserLikeName($like) {
    $sql = 'SELECT first_name, last_name FROM users WHERE first_name like "%' . $like . '%"';
    return  $this->_db->query($sql);
  }

  function getUserNotBook($book) {
    $sql = 'SELECT id, first_name, last_name FROM users WHERE id not in (
            SELECT u.id FROM users  AS u
            JOIN users_books AS ub ON u.id = ub.user_id
            JOIN books AS b ON b.id = ub.book_id
            WHERE b.title = "' . $book . '" group by u.id)';
    return $this->_db->query($sql);
  }

  function createBoolField ($table, $field){
    $sql = 'ALTER TABLE `' . $table . '` ADD `' . $field . '` BOOLEAN NOT NULL DEFAULT 0';
    $count = $this->_db->exec($sql);
    if(!$count) {
      return $this->_db->errorInfo()[2];
    }
    return $count;
  }
  function addIs_active() {
    $sql = 'Update users as u1 set u1.is_active = 1 where u1.id IN (
            SELECT id FROM (SELECT u2.id FROM  users as u2
            JOIN users_books AS ub ON u2.id = ub.user_id
            GROUP BY u2.id HAVING count(ub.user_id) > 0) as tmp)';
    $count = $this->_db->exec($sql);
    if(!$count) {
      return $this->_db->errorInfo()[2];
    }
    return $count;
  }
  function addIs_best_seller() {
    $sql = 'Update books as b1 set b1.is_best_seller = 1 where b1.id IN (
            SELECT id FROM (SELECT b2.id,count(ub.book_id)   FROM  books as b2
            JOIN users_books AS ub ON b2.id = ub.book_id
            GROUP BY b2.id HAVING count(ub.book_id) > 10) as tmp);';
    $count = $this->_db->exec($sql);
    if(!$count) {
      return $this->_db->errorInfo()[2];
    }
    return $count;
  }
}


