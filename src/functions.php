<?php

function parse_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function dd($data)
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";

    die();
}
