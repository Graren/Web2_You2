<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 4/13/2017
 * Time: 10:54 PM
 */
    session_start();
    session_destroy();
    header("Content-Type: application/json");
    echo json_encode([
        "status" => 200,
        "response" => "logged out",
    ]);

