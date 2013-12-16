<?php
abstract class Orm_Model {
    protected $source = null;
    protected $schema = null;

    public function __construct() {
        $this->schema = new Orm_Schema();
        $class = get_called_class();
        $this->schema->setModel($class);
        $this->setUp($this->schema);
    }

    abstract public function setUp(Orm_Schema $schema);

    protected function getSource() {
        $source = null;
        if ('sqlite' === 'sqlite') {
            $source = new Orm_Sources_Sqlite($this->schema);
        } else  {
        }
        return $source;
    }

    public function __call($method_name, $args) {
        if (!$this->source) {
            $this->source = $this->getSource();
        }
        return call_user_func_array(array($this->source, $method_name), $args);
    }

    public function __get($name) {
        return $this->schema->$name;
    }

    public function __set($name, $value) {
        return $this->schema->$name = $value;
    }
}
