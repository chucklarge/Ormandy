<?php
abstract class Orm_Sources {
    protected $model;
    protected $db;
    protected $table;
    protected $fields;

    protected $config;
    protected $dbh;
    protected $registered_queries = [];

    private $pks = null;

    public function __construct($model, $db, $table, $fields = []) {
        $this->config = [];
        $this->model = $model;
        $this->db = $db;
        $this->table = $table;
        $this->fields = $fields;
    }

    public function __destruct() {
        $this->dbh = null;
    }

    abstract public function find($pk);
    abstract public function findAll();
    abstract public function store();
    abstract public function delete();
    abstract public function query($sql, array $params);

    public function registerQuery($name, $params) {
        $this->registered_queries[$name] = $params;
    }

    public function __call($method_name, $args) {
        if (isset($this->registered_queries[$method_name])) {
            $cols = is_array($this->registered_queries[$method_name]) ?
                $this->registered_queries[$method_name] : [$this->registered_queries[$method_name]];
            $params = is_array($args) ? $args : [$args];
            return $this->runRegistered($cols, $params);
        }
    }

    public function getPrimaryKeys() {
        if (!$this->pks) {
            $this->pks = [];
            foreach ($this->fields as $f) {
                if ($f->type === 'primary_key') {
                    $this->pks[] = $f['field'];
                }
            }
        }
        return $this->pks;
    }
}
