<?php

function create_tables(PDO $db): void
{
    $command = 'CREATE TABLE notifications
                (
                    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                    timestamp INTEGER NOT NULL,
                    name TEXT NOT NULL,
                    status INTEGER NOT NULL
                );
                CREATE UNIQUE INDEX notifications_id_uindex ON notifications (id);';
    $db->exec($command);
}

/**
 * @param string $db_file
 * @return PDO
 */
function establish_connection(string $db_file): PDO
{
    try {
        $db = new PDO('sqlite:'.$db_file);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(Exception $e) {
        die('connection failed: ' . $e->getMessage());
    }

    return $db;
}