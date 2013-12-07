<?php
abstract class Orm_Orm {
    protected $model;
    protected $db;
    protected $table;
    protected $source = null;

    protected $fields = [];

    public function __construct() {
        $this->setUp();
    }

    public function setUp();

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
        $this->addField($field, '', [], 'primary_key');
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
            'type' => $type,
            'column_type' => $column_type,
            'column_size' => $column_size,
        ];
        $this->$field = null;
    }

    protected function getSource() {
        $source = null;
        if ('sqlite' === 'sqlite') {
            $source = new Orm_Sqlite($this->model, $this->db, $this->table, $this->fields);
        } else  {
        }
        return $source;
    }

    public function __call($method_name, $args) {
        $class = get_called_class();
        if (!$this->source) {
            if (isset(Orm_Registry::$finder_classes['Model_'.$class])) {
                $m = Orm_Registry::$finder_classes['Model_'.$class]['model_class'];
                $c = new $m();
                $c->setUp();
            }
            $this->source = $this->getSource();
        }
        return call_user_func_array(array($this->source, $method_name), $args);
    }
}
