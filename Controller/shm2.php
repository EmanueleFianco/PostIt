<?php
require_once ("../Utility/UShmSmart.php");
$shx= new shmSmart;
echo  $shx->get("key_name_apple"); // get example key value.
print_r ($shx->get("key name alternative array"));
?>