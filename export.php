<?php
/**
 * MS-Excel stream handler
 * Excel export example
 * @author      Ignatius Teo            <ignatius@act28.com>
 * @copyright   (C)2004 act28.com       <http://act28.com>
 * @date        21 Oct 2004
 */
define('APP_PATH', dirname(__FILE__) );
define( 'DS', '/' );
include ('lib'.DS.'Excel.php');
$filename = $_REQUEST['filename'];
header ("Content-Type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=$filename");
readfile("xlsfile://tmp/$filename");
exit;
