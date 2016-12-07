<?php

require_once 'vendor/autoload.php';
use \Akimah\Database;
use \Akimah\Model;
use \Akimah\Model\Hardware;
use \Akimah\Model\ResultSet;

function createHardware()
{
    Hardware::dropTable();
    Hardware::createTable();
    Hardware::create()->setProperties([
        "name" => "Cooler Master MasterCase Pro 5",
        "category" => "Tower",
        "price" => 140.00,
        "warranty" => 3,
        "date_up" => "2012-09-07",
        "confirmed" => 1
    ])->insert();
    Hardware::create()->setProperties([
        "name" => "Intel i5 6600k",
        "category" => "Processors",
        "price" => 249.50,
        "warranty" => 2,
        "date_up" => "2014-02-10",
        "confirmed" => 1
    ])->insert();
    Hardware::create()->setProperties([
        "name" => "Intel i7 6700k",
        "category" => "Processors",
        "price" => 340.90,
        "warranty" => 2,
        "date_up" => "2011-04-17"
    ])->insert();
    Hardware::create()->setProperties([
        "name" => "Cooler Master MasterCase Maker 5",
        "category" => "Tower",
        "price" => 188.70,
        "warranty" => 5,
        "date_up" => "2015-11-26",
        "confirmed" => 0
    ])->insert();
    Hardware::create()->setProperties([
        "name" => "Intel Celeron",
        "category" => "Processors",
        "price" => 79.95,
        "warranty" => 1,
        "date_up" => "2009-09-02",
        "confirmed" => 1
    ])->insert();
}

echo "<h3>ORIGINAL</h3>";
createHardware();
ResultSet::showTable(Hardware::all());

echo "<h3>UPDATE MORE EXPENSIVE TO 100</h3>";
Hardware::all()->sortBy("price")->last()->setProperty("price", 100)->update();
ResultSet::showTable(Hardware::all());

echo "<h3>DELETE OLDER</h3>";
Hardware::all()->sortBy("date_up")->first()->delete();
ResultSet::showTable(Hardware::all());

echo "<h3>NAME CONTAINS '5'</h3>";
ResultSet::showTable(Hardware::all()->contains("name", "5"));

echo "<h3>WARRANTY = 3</h3>";
ResultSet::showTable(Hardware::all()->equals("warranty", "3"));

echo "<h3>PRICE > 150</h3>";
ResultSet::showTable(Hardware::all()->bigger("price", 150));

echo "<h3>SORT BY DATE (NEWER FIRST)</h3>";
ResultSet::showTable(Hardware::all()->sortBy("date_up")->reverse());

echo "<h3>CONFIRMED</h3>";
ResultSet::showTable(Hardware::all()->equals("confirmed", true));

echo "<h3>PRICE < 200 ORDER BY PRICE</h3>";
ResultSet::showTable(Hardware::all()->sortBy("price")->smaller("price", 200));

?>

<style>
    * {
        font-family: "Open Sans";
    }
    table {
        border-collapse: collapse;
        margin-bottom: 50px;
    }
    td {
        border: 1px solid #444;
        padding: 10px 15px;
    }
    th {
        padding: 15px;
        background-color: #fbffce;
        text-transform: uppercase;
    }
</style>