<?php
abstract class Orm_Orm {
    protected $source = null;
    public $schema = null;


    public function __construct() {
        $this->schema = new Orm_Schema();
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
        $class = get_called_class();
        if (!$this->source) {
            if (isset(Orm_Registry::$finder_classes['Model_'.$class])) {
                $m = Orm_Registry::$finder_classes['Model_'.$class]['model_class'];
                $c = new $m();
                $c::setUp($this->schema);
            }
            $this->source = $this->getSource();
        }
        return call_user_func_array(array($this->source, $method_name), $args);
    }
}
