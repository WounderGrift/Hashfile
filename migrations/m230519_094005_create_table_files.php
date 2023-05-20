<?php

use yii\db\Migration;

class m230519_094005_create_table_files extends Migration
{
    public function safeUp()
    {
        $this->execute("CREATE TABLE `files` (
            `id`          INT          UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `name`        VARCHAR(255) NOT NULL,
            `description` VARCHAR(255) NOT NULL,
            `type`        VARCHAR(255) NOT NULL,
            `size`        INT UNSIGNED NOT NULL,
            `content`     LONGBLOB     NOT NULL,
            `hash`        VARCHAR(255) NOT NULL,
            `date_create` DATE         NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

        $this->execute("CREATE INDEX idx_hash ON files (hash);");
    }

    public function safeDown()
    {
        $this->execute("DROP TABLE `files`;");
    }
}
