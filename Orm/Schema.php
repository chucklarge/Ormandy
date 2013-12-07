<?php

class Orm_Schema {
    public $model;
    public $db;
    public $table;
    public $primary_keys = [];
    public $fields = [];

    public $registered_queries = [];

    public function setModel($model) {
        $this->model = $model;
    }

    public function setDb($db) {
        $this->db = $db;
    }

    public function setTable($table) {
        $this->table = $table;
    }

    public function addPKField($field, $column_type = '', $column_size = []) {
/*
        $this->primary_keys[] = [
            'field' => $field,
            'column_type' => $column_type,
            'column_size' => $column_size,
        ];
*/
        $this->primary_keys[] = $field;
    }

    public function addCreateDateField($field, $column_type = '', $column_size = []) {
        $this->addField($field, '', [], 'create_date');
    }

    public function addUpdateDateField($field, $column_type = '', $column_size = []) {
        $this->addField($field, '', [], 'update_date');
    }

    public function addField($field, $column_type = '', $column_size = [], $type = 'field') {
        $this->fields[] = [
            'field' => $field,
            'column_type' => $column_type,
            'column_size' => $column_size,
        ];
        $this->$field = null;
    }

    public function registerQuery($name, $params) {
        $this->registered_queries[$name] = $params;
    }



}
