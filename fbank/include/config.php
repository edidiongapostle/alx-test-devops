<?php

define("WEB_TITLE","Dirtyscripts Developer"); // Change Bank Name
define("WEB_URL","https://demo.dirtyscripts.shop/bankpro"); // Change No "/" Ending splash
define("WEB_EMAIL","ofofonobs@gmail.com"); // Change Your Website Email

$web_url = WEB_URL;

function dbConnect(){
    $servername = "localhost";
    $username = "source";//DATABASE USERNAME
    $password = "Pre241sh.";//DATABASE PASSWORD
    $database = "source";//DATABASE NAME
    $dns = "mysql:host=$servername;dbname=$database";

    try {
        $conn = new PDO($dns, $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
//return dbConnect();

function inputValidation($value): string
{
    return trim(htmlspecialchars(htmlentities($value)));
}