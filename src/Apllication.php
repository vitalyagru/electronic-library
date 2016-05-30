<?php
namespace Binary_studio;
require __DIR__ . '\..\vendor\autoload.php';



class Apllication {
  public $host = "mysql:dbname=db_test_data; host=localhost";
  public $user = "root";
  public $password = "";

  function start() {
  $objUserBook = new UsersBooksDB ($this->host, $this->user, $this->password);
  $usersAgeBooks = $objUserBook->getUserAgeCountBooks(20 , 5);
  ?>

  <h2>Все пользователи  в возрасте от 20 лет с количеством книг более 5</h2>
  <table>
    <tr>
      <th>Имя</th>
      <th>Фамилия</th>
      <th>Возраст</th>
    </tr>

  <?php
  while ($result = $usersAgeBooks->fetch(\PDO::FETCH_OBJ)){
    echo '<tr>';
    echo '<td>' . $result->first_name . '</td>';
    echo '<td>' . $result->last_name . '</td>';
    echo '<td>' . $result->age . '</td>';
    echo '</tr>';
  }
  echo '</table>';

  $usersLike = $objUserBook->getUserLikeName(3);
  ?>
  <hr>
  <h2>Все пользователи в имени которых присутствует число 3:</h2>
  <table>
    <tr>
      <th>Имя</th>
      <th>Фамилия</th>
    </tr>

  <?php
  while ($result = $usersLike->fetch(\PDO::FETCH_OBJ)){
    echo '<tr>';
    echo '<td>' . $result->first_name . '</td>';
    echo '<td>' . $result->last_name . '</td>';
    echo '</tr>';
  }
  echo '</table>';

  $notBook = $objUserBook->getUserNotBook('Book #21');
  ?>
  <hr>
  <h2>Все пользователи которые не брали книгу с именем "Book #21":</h2>
  <table>
    <tr>
      <th>Id</th>
      <th>Имя</th>
      <th>Фамилия</th>
    </tr>

  <?php
  while ($result = $notBook->fetch(\PDO::FETCH_OBJ)){
    echo '<tr>';
    echo '<td>' . $result->id . '</td>';
    echo '<td>' . $result->first_name . '</td>';
    echo '<td>' . $result->last_name . '</td>';
    echo '</tr>';
  }
  echo '</table>';

  echo '<hr><h2> Поле is_active  - ' . $objUserBook->createBoolField('users','is_active');
  echo '<hr><h2>Запрос "Поле is_active = 1 для пользователей, которые взяли как минимум одну книгу" вернул - ' . $objUserBook->addIs_active();
  echo '<hr><h2> Поле is_best_seller  - ' . $objUserBook->createBoolField('books','is_best_seller');
  echo '<hr><h2>Запрос "Поле isbestseller = 1 для книг, которые были взяты пользователями более 10 раз" вернул - ' . $objUserBook->addIs_best_seller();
  }

}




