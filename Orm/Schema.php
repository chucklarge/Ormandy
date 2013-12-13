<?php

class Orm_Schema {
    public $model;
    public $db;
    public $table;
    public $primary_keys = [];
    public $fields = [];
    public $loaded_from_db = false;
    public $dirty_fields = [];  // fields that have changed after loaded from db

    public $registered_queries = [];

    public function setModel($model) {
        $this->model = $model;
    }

    public function setDb($db) {
        $this->db = $db;
    }

    public function setTableName($table) {
        $this->table = $table;
    }

    public function addPKField($field, $column_type = '', $column_size = []) {
        $this->addField($field, $column_type, $column_size);
        $this->primary_keys[] = $field;
    }

    public function addCreateDateField($field, $column_type = '', $column_size = []) {
        $this->addField($field, '', []);
    }

    public function addUpdateDateField($field, $column_type = '', $column_size = []) {
        $this->addField($field, '', []);
    }

    public function addField($field, $column_type = '', $column_size = []) {
        $this->fields[$field] = [
            'field' => $field,
            'column_type' => $column_type,
            'column_size' => $column_size,
            'value' => null,
        ];
        $this->$field = null;
    }

    public function getPKFieldsAndValues() {
        $f = [];
        $v = [];
        foreach ($this->primary_keys as $pk) {
            $f[] = $pk;
            $v[] = $this->fields[$pk]['value'];
        }
        return ['fields' => $f, 'values' => $v];
    }

    public function getDirtyFieldsAndValues() {
        $f = [];
        $v = [];
        foreach ($this->dirty_fields as $df) {
            $f[] = $df;
            $v[] = $this->fields[$df]['value'];
        }
        return ['fields' => $f, 'values' => $v];
    }

    public function getFieldsAndValues() {
        $f = [];
        $v = [];
        foreach ($this->fields as $field) {
            $f[] = $field['field'];
            $v[] = $field['value'];
        }
        return ['fields' => $f, 'values' => $v];
    }

    public function getData() {
        $d = [];
        foreach ($this->fields as $field) {
            $d[$field['field']] = $field['value'];
        }
        return $d;
    }

    public function __get($name) {
        if (isset($this->fields[$name])) {
            return $this->fields[$name]['value'];
        } else {
            throw new Exception('No field named ' . $name);
        }
    }

    public function __set($name, $value) {
        if (isset($this->fields[$name])) {
            $this->fields[$name]['value'] = $value;
            if ($this->loaded_from_db) {
                $this->dirty_fields[] = $name;
            }
        } else {
            $this->$name = $value;  // allow adhoc member var assignment
        }
    }

    public function registerQuery($name, $params) {
        $this->registered_queries[$name] = $params;
    }
}
