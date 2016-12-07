<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 05/12/2016
 * Time: 3:02
 */

namespace Akimah\Model;


class Hardware extends Model
{

    protected function table(Table &$fields)
    {
        $fields->int("id")->autoIncrement()->primaryKey();
        $fields->string("name", "100");
        $fields->decimal("price")->defaultValue("100");
        $fields->string("category")->nullable();
        $fields->date("date_up");
        $fields->int("warranty")->nullable();
        $fields->email("seller_email")->nullable();
        $fields->boolean("confirmed")->defaultValue(false);
    }

    protected function setTableName(&$tableName)
    {
        $tableName = "hardware";
    }

}