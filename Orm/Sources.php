<?php
abstract class Orm_Sources {
    protected $config;
    protected $dbh;
    protected $schema;

    public function __construct($schema) {
        $this->config = [];
        $this->schema = $schema;
    }

    public function __destruct() {
        $this->dbh = null;
    }

    abstract public function find($pk);
    abstract public function findAll();
    abstract public function store();
    abstract public function delete();
    abstract public function query($sql, array $params);

    public function __call($method_name, $args) {
        if (isset($this->schema->registered_queries[$method_name])) {
            $cols = is_array($this->schema->registered_queries[$method_name]) ?
                $this->schema->registered_queries[$method_name] : [$this->schema->registered_queries[$method_name]];
            $params = is_array($args) ? $args : [$args];
            return $this->runRegistered($cols, $params);
        }
    }
}
