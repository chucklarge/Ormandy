<?php
class Orm_Sources_Mysql extends Orm_Sources {

    public function __construct($schema) {
        parent::__construct($schema);
    }

    public function query($sql, array $params = [], $result_type = 0, $object_type = 0) {
        $results = [];
        return $results;
    }
}
