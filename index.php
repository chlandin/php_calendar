<?php

include_once 'inc/db.inc.php';
include_once 'inc/FormatDateOutput.php';
include_once 'inc/htmlout.inc.php';

if (isset($_POST['action']) && $_POST['action'] == 'Save') {

    try {
        if (!empty($_POST['id'])) {
            $sql = 'UPDATE calendar SET
                      title = :title,
                description = :description,
                  date_from = :date_from,
                    date_to = :date_to 
                   WHERE id = :id';
        } else {
            $sql = 'INSERT INTO calendar SET
                      title = :title,
                description = :description,
                  date_from = :date_from,
                    date_to = :date_to';
        }

        $s = $pdo->prepare($sql);
        $s->bindValue(':title', $_POST['title']);
        $s->bindValue(':description', $_POST['description']);
        $s->bindValue(':date_from', $_POST['date_from'] . ' ' . $_POST['time_from'] . ':00');
        $s->bindValue(':date_to', $_POST['date_to'] . ' ' . $_POST['time_to'] . ':00');

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
    $event_from = new DateTime($row['date_from']);
    $event_to = new DateTime($row['date_to']);
    $date_from = $event_from->format('Y-m-d');
    $date_to = $event_to->format('Y-m-d');
    $time_from = $event_from->format('H:i');
    $time_to = $event_to->format('H:i');

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
        'date_to' => $row['date_to']);
}

include 'page.php';

