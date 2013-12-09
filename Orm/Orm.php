<?php
abstract class Orm_Orm {
    protected $source = null;
    public $schema = null;


    public function __construct() {
        $this->schema = new Orm_Schema();

        // if a finder instance, run the model setup
        $class = get_called_class();
        if (isset(Orm_Registry::$finder_classes['Model_'.$class])) {
            $m = Orm_Registry::$finder_classes['Model_'.$class]['model_class'];
            $c = new $m();
            $c::setUp($this->schema);
        }
        static::setUp($this->schema);
    }

    public static function setUp() {
        echo "uh oh\n";
    }

    protected function getSource() {
        $source = null;
        if ('sqlite' === 'sqlite') {
            $source = new Orm_Sqlite($this->schema);
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
