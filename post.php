<?php
    require 'database_class.php';
    $config = [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => '',
        'db' => 'note' 
    ];
    $db = new database($config);
    // set a table's name
    $db->table('note');
    // create
    if(isset($_POST['btn'])){
        unset($_POST['btn']);
        $db->insert($_POST);

        
    }
    //update
    if(!empty($_GET['id'])){
        $getOneNote = $db->get($_GET['id']);
        $db->record = $getOneNote;
    }
    if(isset($_POST['edit-btn'])){
        unset($_POST['edit-btn']);
        $db->update($_POST['id'], $_POST);

    }

    // delete
    if(isset($_POST['delete-btn'])){
        $db->delete($_POST['id']);
    }
    // get all note
    $notes = $db->get();

