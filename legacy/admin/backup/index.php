<?php
/**
 * /admin/backup/index.php
 *
 * This file is part of DomainMOD, an open source domain and internet asset manager.
 * Copyright (c) 2010-2020 Greg Chetcuti <greg@chetcuti.com>
 *
 * Project: http://domainmod.org   Author: http://chetcuti.com
 *
 * DomainMOD is free software: you can redistribute it and/or modify it under the terms of the GNU General Public
 * License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later
 * version.
 *
 * DomainMOD is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with DomainMOD. If not, see
 * http://www.gnu.org/licenses/.
 *
 */
?>
<?php
require_once __DIR__ . '/../../_includes/start-session.inc.php';
require_once __DIR__ . '/../../_includes/init.inc.php';
require_once DIR_INC . '/config.inc.php';
require_once DIR_INC . '/software.inc.php';
require_once DIR_ROOT . '/vendor/autoload.php';

$deeb = DomainMOD\Database::getInstance();
$system = new DomainMOD\System();
$log = new DomainMOD\Log('/admin/backup/index.php');
$layout = new DomainMOD\Layout();

require_once DIR_INC . '/head.inc.php';
require_once DIR_INC . '/debug.inc.php';
require_once DIR_INC . '/settings/admin-backup-main.inc.php';

$system->authCheck();
$system->checkAdminUser($_SESSION['s_is_admin']);
$pdo = $deeb->cnxx;

use iamdual\Uploader;
use Thamaraiselvam\MysqlImport\Import;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    try {

        if (isset($_FILES["file"])) {

            if (file_exists(DIR_ROOT . '/temp/domainmod-restore.sql')) {

                unlink(DIR_ROOT . '/temp/domainmod-restore.sql');

            }

            $upload = new Uploader($_FILES["file"]);
            $upload->allowed_extensions(array("sql"));
            $upload->max_size(50); // in MB
            $upload->path(DIR_ROOT . "/temp");
            $upload->name("domainmod-restore.sql");

            if (!$upload->upload()) {

                $_SESSION['s_message_danger'] .= 'Please choose a backup file to restore';

            } else {

                $filename = DIR_ROOT . '/temp/domainmod-restore.sql';
                $username = $dbusername;
                $password = $dbpassword;
                $database = $dbname;
                $host = $dbhostname;
                new Import($filename, $username, $password, $database, $host);

                header("Location: " . WEB_ROOT . "/logout.php");
                exit;

            }

        }

    } catch (Exception $e) {

        $log_message = 'Unable to restore DomainMOD data';
        $log_extra = array('Error' => $e);
        $log->critical($log_message, $log_extra);

        throw $e;

    }

}
?>
<?php require_once DIR_INC . '/doctype.inc.php'; ?>
<html>
<head>
    <title><?php echo $layout->pageTitle($page_title); ?></title>
    <?php require_once DIR_INC . '/layout/head-tags.inc.php'; ?>
</head>
<body class="hold-transition skin-red sidebar-mini">
<?php require_once DIR_INC . '/layout/header.inc.php'; ?>

This page enables you to perform complete backups and restores of your <?php echo SOFTWARE_TITLE; ?> database. This allows you to export your entire system in a single file so that it can easily be backed up and restored. This is helpful if you want to perform regular backups of your data, you need to move <?php echo SOFTWARE_TITLE; ?> to a new server, or if you want to change your installation method.<BR>
<BR>This process backs up the data saved in your database. If you also want to save your database connection information, you should backup your /_includes/config.inc.php file.<BR>
<BR><?php echo $layout->highlightText('red', 'NOTE: '); ?>Before you can use Backup & Restore you must update the permissions on the <strong><?php echo DIR_ROOT . '/temp'; ?></strong> folder ("<em>chmod 777 /var/www/html/domainmod/temp</em>"). If you're unsure how to do this your web hosting provider should be able to assist you.

<h3>Backup</h3>
Database Backup File: domainmod-backup.sql<BR>
<a href="download/"><?php echo $layout->showButton('button', 'Backup Entire Database'); ?></a>

<BR><BR><h3>Restore</h3>
<form enctype="multipart/form-data" action="" method="post">
    Database Restore File: domainmod-backup.sql <input type="file" name="file" style="padding-bottom: 5px;">
    <?php echo $layout->highlightText('red', 'WARNING: '); ?>This will completely delete all of the data in your current <?php echo SOFTWARE_TITLE; ?> database. Your current database will be replaced with the data in the domainmod-backup.sql file that you're restoring.<BR>
    After restoring a database you'll be automatically logged out, at which point you'll be able to login using the accounts in the data you restored.<BR>
    <?php echo $layout->showButton('submit', 'Restore Entire Database'); ?>
</form>
<BR>

<h3>Cleanup</h3>
Click here to delete any and all past backup and restore files that may be saved on your server.<BR>
<a href="cleanup/"><?php echo $layout->showButton('button', 'Perform Cleanup'); ?></a>
<BR><BR>
<?php require_once DIR_INC . '/layout/footer.inc.php'; ?>
</body>
</html>
