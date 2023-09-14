<?php

$env = "prod";


/*$prodArray =  [
    'db_host' => 'localhost',
    'db_name' => 'id21251148_crudapp',
    'db_user' => 'id21251148_root',  
    'db_password' => 'adminRoot#50',
];*/

$prodArray =  [
    'db_host' => 'localhost',
    'db_name' => 'crud_App',
    'db_user' => 'root',  
    'db_password' => 'Pa*#?02569',
];

$devArray =  [
    'db_host' => '127.0.0.1',
    'db_name' => 'crudApp',
    'db_user' => 'root', 
    'db_password' => 'adminroot',
];

$config = $env === "dev" ? $devArray : $prodArray;


?>
