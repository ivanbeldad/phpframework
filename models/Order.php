<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 07/12/2016
 * Time: 2:53
 */

namespace Akimah\Model;


class Order extends Model
{

    protected function table(Table &$fields)
    {
        $fields->int("id")->autoIncrement()->primaryKey();
        $fields->int("product_id")->foreignKey("product_id_fk")->references("hardware")->on("id");
        $fields->int("quantity")->defaultValue(1);
        $fields->datetime("datetime_order");
        $fields->string("customer_name");
    }

    protected function setTableName(&$tableName)
    {
        $tableName = "orders";
    }

}