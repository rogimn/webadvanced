<?php

    // call required and included files

    require_once 'config/app.php';
    require_once 'config/database.php';

    // user control

    if (empty($_SESSION['key'])) {
        header('location:./');
    }

    // get database connection

    $database = new Database();
    $db = $database->getConnection();

    if (!exec("export PGPASSWORD='' && export PGUSER=roger && pg_dump -h localhost tenutti -CdiOv > db/db_name_backup.sql && unset PGPASSWORD && unset PGUSER")) {
        echo 'falha';
    }

    unset($cfg,$database,$db);
