<?php
class Orm_Sqlite extends Orm_Sources {
    public function __construct($schema) {
        parent::__construct($schema);
        try {
            $path = '/Users/cclark/Dropbox/github/orm/dbs/';
            $this->dbh = new PDO('sqlite:'.$path.$this->schema->db);
        }
        catch(PDOException $e) {
            Logger::error($e->getMessage());
            throw $e;
        }
    }

    public function __destruct() {
        parent::__destruct();
    }

    public function formatPrepared($keys) {
        $w = [];
        foreach ($keys as $key) {
            $w[] = $key .'=?';
        }
        return implode(' and ', $w);
    }


    public function find($value) {
        $pks = $this->schema->primary_keys;
        $sql = 'select * from ' . $this->schema->table . ' where ' . $this->formatPrepared($pks);
        $params = is_array($value) ? $value : [$value];
        return $this->query($sql, $params, true);
    }

    public function findAll() {
        $sql = 'select * from ' . $this->schema->table;
        return $this->query($sql, [], true);
    }

    public function store() {
    }

    public function delete() {
    }

    public function runRegistered(array $cols, array $params) {
        $where = [];
        foreach($cols as $col) {
            $where[] = $col . '=? ';
        }
        $sql = 'select * from ' . $this->schema->table . ' where ' . implode(' and ', $where);
        return $this->query($sql, $params, true);
    }

    public function query($sql, array $params = [], $create_object = false) {
        $results = [];
        try {
            $sth = $this->dbh->prepare($sql);
            $sth->execute($params);
            while ($r = $sth->fetch(PDO::FETCH_ASSOC)) {
                $results[] = $create_object ? $this->createObject($r) : $r;
            }
        }
        catch(PDOException $e) {
            throw $e->getMessage();
        }
        return $results;
    }

    protected function createObject($result) {
        $m = Orm_Registry::$models[$this->schema->model]['model_class'];
        $o = new $m;
        foreach ($result as $k => $v) {
            $o->$k = $v;
        }
        return $o;
    }
}
