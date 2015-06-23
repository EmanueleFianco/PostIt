<?php
require_once ("../Utility/UShmSmart.php");
$shx= new shmSmart;
$shx->put("key_name_apple","key_val_peach"); //set example..
$shx->put("key name alternative array",array(1=>"banana","apricot","blablabla"=>array("new-blaala"))); //set array example..
echo  $shx->get("key_name_apple"); // get example key value.
print_r ($shx->get("key name alternative array")); // free memory in php..
?>