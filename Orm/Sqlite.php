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

    public function query($sql, array $params = [], $result_type = 0, $object_type = 0) {
//echo "******************new query*********************\n";
//var_dump($sql, $params, $result_type, $object_type);
//echo "\n\n";
        $results = [];
        try {
            $sth = $this->dbh->prepare($sql);
            $sth->execute($params);
            if ($result_type === Orm_Sources::SINGLE_RESULT) {
                $r = $sth->fetch(PDO::FETCH_ASSOC);
                $results = $this->setResults($object_type, $r);
            } else if ($result_type === Orm_Sources::MULTIPLE_RESULT) {
                while ($r = $sth->fetch(PDO::FETCH_ASSOC)) {
                    $results[] = $this->setResults($object_type, $r);
                }
            }
        }
        catch(PDOException $e) {
            throw $e->getMessage();
        }
        return $results;
    }


}
