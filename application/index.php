<?php
error_reporting(-1);
ini_set('display_errors', 'On');

require_once "lib/Smarty.class.php";
require_once "database.php";

//connect to our db
$db = new Db();

if(isset($_COOKIE['ACTIVE_NOTE_ID'])) {
    if(!$db->isValid($_COOKIE['ACTIVE_NOTE_ID'])) {
        setcookie("ACTIVE_NOTE_ID", $db->getMaxId());
        $activeNoteId = $db->getMaxId();
    } else {
        $activeNoteId = $_COOKIE['ACTIVE_NOTE_ID'];
    }
}

if(isset($_REQUEST['action'])) {
    switch($_REQUEST['action']) {
        case 'delete':
            $db->deleteNote($activeNoteId);
            $newId = $db->getMaxId();
            setcookie("ACTIVE_NOTE_ID", $newId);
            $activeNoteId = $newId;
            break;
        case 'update':
            $db->updateNote($_COOKIE['ACTIVE_NOTE_ID'], $_REQUEST['content']);
            break;
        case 'new':
            $db->createNote("New note.");
            $newId = $db->getMaxId();
            setcookie("ACTIVE_NOTE_ID", $newId);
            $activeNoteId = $newId;
            break;
        case 'navigate':
            setcookie("ACTIVE_NOTE_ID", $_REQUEST['id']);
            $activeNoteId = $_REQUEST['id'];
            break;
    }
}

$template = new Smarty();

if(isset($activeNoteId))
    $template->assign("ACTIVE_NOTE_ID", $activeNoteId);
$template->assign("notes", $db->getNotes());
$template->display('index.tpl');

//disconnect
$db->disconnect();
?>