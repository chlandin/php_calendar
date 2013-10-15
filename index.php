<?php

include_once 'inc/db.inc.php';
include_once 'inc/FormatDateOutput.php';

if (isset($_POST['action']) && $_POST['action'] == 'Save') {

    try {
        if (!empty($_POST['id'])) {
            $sql = 'UPDATE calendar SET
                      title = :title,
                description = :description,
                  date_from = :date_from,
                    date_to = :date_to,
                  time_from = :time_from,
                    time_to = :time_to 
                   WHERE id = :id';
        } else {
            $sql = 'INSERT INTO calendar SET
                      title = :title,
                description = :description,
                  date_from = :date_from,
                    date_to = :date_to,
                  time_from = :time_from,
                    time_to = :time_to';
        }

        $s = $pdo->prepare($sql);
        $s->bindValue(':title', $_POST['title']);
        $s->bindValue(':description', $_POST['description']);
        $s->bindValue(':date_from', $_POST['date_from']);
        $s->bindValue(':date_to', $_POST['date_to']);
        $s->bindValue(':time_from', $_POST['time_from']);
        $s->bindValue(':time_to', $_POST['time_to']);

        if (!empty($_POST['id'])) {
            $s->bindValue(':id', $_POST['id']);
        }

        $s->execute();
    } catch (PDOExeption $e) {
        $error = 'Error: ' . $e->getMessage();
        include 'error.php';
        exit();
    }

    header('Location: .');
    exit();
}

if (isset($_POST['action']) && $_POST['action'] == 'Delete') {

    try {
        $sql = 'DELETE FROM calendar WHERE id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    } catch (PDOException $e){
        $error = 'Error: ' . $e->getMessage();
        include 'error.php';
        exit();
    }

    header('Location: .');
    exit();
}

if (isset($_POST['action']) && $_POST['action'] == 'Edit') {

    try {
        $sql = 'SELECT * FROM calendar WHERE id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    } catch (PDOException $e){
        $error = 'Error: ' . $e->getMessage();
        include 'error.php';
        exit();
    }

    $row = $s->fetch();

    $id = $row['id']; 
    $title = $row['title'];
    $description = $row['description'];
    $date_from = $row['date_from'];
    $date_to = $row['date_to'];
    $time_from = $row['time_from'];
    $time_to = $row['time_to'];

} else {

    $id = ""; 
    $title = "";
    $description = "";
    $date_from = "";
    $date_to = "";
    $time_from = "";
    $time_to = "";

}

try {
    $sql = 'SELECT * FROM calendar WHERE date_from >= CURDATE() ORDER BY date_from ASC';
    $result = $pdo->query($sql);
} catch (PDOException $e){
    $error = 'Error: ' . $e->getMessage();
    include 'error.php';
    exit();
}

foreach ($result as $row) {
    $events[] = array(
        'id' => $row['id'], 
        'title' => $row['title'],
        'description' => $row['description'],
        'date_from' => $row['date_from'],
        'date_to' => $row['date_to'],
        'time_from' => $row['time_from'],
        'time_to' => $row['time_to']);
}

include 'page.php';
