<?php

Orm_Registry::registerModel(
    'Users',
    'Model_Users',
    'Model_UsersFinder'
);

class Model_Users extends Orm_Model {
    public static function setUp(Orm_Schema $schema) {
        $schema->setDb('site.sqlite');
        $schema->setTableName('users');

        $schema->addPKField('user_id');
        $schema->addField('first_name');
        $schema->addField('last_name');
        $schema->addField('email');
        $schema->addCreateDateField('create_date');
        $schema->addUpdateDateField('update_date');
    }

    public function fullName() {
        return $this->first_name . ' ' . $this->last_name;
    }
}

class Model_UsersFinder extends Orm_Model {
    public static function setUp(Orm_Schema $schema) {
        $schema->registerQuery('findByFirstName', ['first_name']);
    }

    public function findByLastName($last_name) {
        $sql = 'select * from users where last_name=?';
        $params = [$last_name];
        return $this->query($sql, $params, true);
    }
}
