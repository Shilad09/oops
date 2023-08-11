<?php

spl_autoload_register(function($class){
    include $class . ".php";
});

$obj = new database;

//insert data...
// $obj->insert('test', ['name' => 'ms dhoni', 'city' => 'ranchi']);
// print_r($obj->get_result());

//update data...
// $obj->update('test', ['city' => 'mumbai'], "city = 'kolkata'");
// print_r($obj->get_result());

//delete data....
// $obj->delete('test', 'id = "4"');
// print_r($obj->get_result());

//select data....
// echo "<pre>";
// $obj->select('test', "city", null, null, "city", "3");
// echo "</pre>";
// print_r($obj->get_result());
?>
