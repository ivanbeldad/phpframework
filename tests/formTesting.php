<?php

require_once '../vendor/autoload.php';
require_once 'models/Hardware.php';
require_once 'models/Order.php';

use FrameworkIvan\Form\Form;
use FrameworkIvan\Model\Hardware;

?>

<style>
    * {
        font-family: "Open Sans";
        margin: 0;
        padding: 0;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    main {
        margin-top: 30px
    }
    section {
        max-width: 1000px;
        margin: 30px auto;
        padding: 20px;
    }
    form {
        max-width: 450px;
        margin: auto;
    }
    fieldset {
        padding: 40px 35px;
        border: 1px solid #888;
        border-radius: 2px;
    }
    legend {
        font-size: 1.3rem;
        font-weight: 500;
        padding: 0 10px;
    }
    form div {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
    form div:last-child {
        margin-bottom: 0;
    }
    label {
        flex-shrink: 0;
        flex-grow: 0;
        flex-basis: 30%;
        padding-right: 5px;
    }
    input {
        padding: 8px 12px;
        flex-grow: 1;
        font-size: 1rem;
        outline: 0;
        border: 1px solid #999;
        border-radius: 1px;
    }
    input[type="submit"] {
        background-color: #21d36b;
    }
    input[type="submit"]:hover {
        background-color: #23e473;
        cursor: hand;
    }
    input[type="reset"] {
        background-color: #cd5652;
        cursor: hand;
    }
    input[type="reset"]:hover {
        background-color: #e15e5a;
    }
    input[type="submit"], input[type="reset"] {
        margin: 10px 15px 0;
        padding: 15px;
        border: 0;
        border-radius: 2px;
        transition: 0.2s;
        color: #fff;
        font-size: 1rem;
    }
</style>

<main>
    <section>
        <?= Form::model(new Hardware(), "here") ?>
    </section>
    <section>
        <?= Form::model(new Hardware(), "here") ?>
    </section>
</main>