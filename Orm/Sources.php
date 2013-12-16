<?php
abstract class Orm_Sources {
    const NO_RESULT       = 0;
    const SINGLE_RESULT   = 1;
    const MULTIPLE_RESULT = 2;

    const NO_OBJECT   = 0;
    const THIS_OBJECT = 1;
    const NEW_OBJECT  = 2;

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

    public function find($value) {
        return $this->f($value, self::NEW_OBJECT);
    }

    protected function f($value, $object_type) {
        $pks = $this->schema->primary_keys;
        $sql = 'select * from ' . $this->schema->table . ' where ' . $this->formatPreparedWhere($pks);
        $params = is_array($value) ? $value : [$value];
        $r = $this->query($sql, $params, self::SINGLE_RESULT, $object_type);
        if (count($r)) {
            return $r;
        } else {
            throw new Exception("not found - fix me");
        }
    }

    public function findAll($limit = null, $offset = null, $sort = null, $dir = null) {
        $sql = 'select * from ' . $this->schema->table;
        $params = [];
        if ($limit) {
            $sql .= ' limit = ?';
            $params[] = $limit;
        }
        if ($offset) {
            $sql .= ' offset = ?';
            $params[] = $offset;
        }
        if ($sort) {
            $sql .= ' sort by ?';
            $params[] = $sort;
        }
        return $this->query($sql, $params, self::MULTIPLE_RESULT, self::NEW_OBJECT);
    }

    public function store() {
        if ($this->schema->loaded_from_db) {
            $pkfv = $this->schema->getPKFieldsAndValues();
            $dfv  = $this->schema->getDirtyFieldsAndValues();
            $sql = 'update ' . $this->schema->table .' set ' . $this->formatPreparedSet($dfv['fields']) .
                   ' where ' . $this->formatPreparedWhere($pkfv['fields']);
            $params = array_merge($dfv['values'], $pkfv['values']);
        } else {
            $fv = $this->schema->getFieldsAndValues();
            $f = implode(', ', $fv['fields']);
            $sql = 'insert into ' . $this->schema->table . '(' . $f . ')
                    values('. $this->generatePlaceholders(count($fv['values'])) . ')';
            $params = $fv['values'];
            $pkfv = $this->schema->getPKFieldsAndValues();
        }
        $this->query($sql, $params, self::NO_RESULT);
        return $this->f($pkfv['values'], self::THIS_OBJECT);
    }

    public function delete() {
        $pkfv = $this->schema->getPKFieldsAndValues();
        $sql = 'delete from ' . $this->schema->table . ' where ' . $this->formatPreparedWhere($pkfv['fields']);
        $params = $pkfv['values'];
        $this->query($sql, $params, self::NO_RESULT);
        $this->schema = null;
    }

    public function getData() {
        return $this->schema->getData();
    }

    abstract public function query($sql, array $params);

    public function __call($method_name, $args) {
        if (isset($this->schema->registered_queries[$method_name])) {
            $rq = $this->schema->registered_queries[$method_name];
            $params = is_array($args) ? $args : [$args];
            return $this->runRegistered($rq, $params);
        }
    }

    // ---
    protected function runRegistered(array $registered_query, array $params) {
        $cols = $registered_query['params'];
        $where = $this->format($cols);
        $sql = 'select * from ' . $this->schema->table . ' where ' . implode(' and ', $where);
        return $this->query($sql, $params, $registered_query['result_type'], $registered_query['object_type']);
    }

    protected function createObject($result) {
        $o = new $this->schema->model();
        foreach ($result as $k => $v) {
            $o->$k = $v;
        }
        $o->loaded_from_db = true;
        return $o;
    }

    protected function setThisObject($result) {
        foreach ($result as $k => $v) {
            $this->schema->$k = $v;
        }
        $this->schema->loaded_from_db = true;
        return $this;
    }

    protected function setResults($object_type, $results) {
        $r = null;
        if ($object_type === self::NO_OBJECT) {
            $r = $results;
        } else if ($object_type === self::THIS_OBJECT) {
            $r = $this->setThisObject($results);
        } else if ($object_type === self::NEW_OBJECT) {
            $r = $this->createObject($results);
        }
        return $r;
    }

    protected function format($keys) {
        $w = [];
        foreach ($keys as $key) {
            $w[] = $key .' = ?';
        }
        return $w;
    }

    protected function formatPreparedSet($keys) {
        return implode(', ', $this->format($keys));
    }

    protected function formatPreparedWhere($keys) {
        return implode(' and ', $this->format($keys));
    }

    protected function generatePlaceholders($size, $ph = '?') {
        $a = array_fill(0, $size, $ph);
        return implode(', ', $a);
    }
}
