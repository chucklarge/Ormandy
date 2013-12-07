<?php

Orm_Registry::registerModel(
    'Users',
    'Model_Users',
    'Model_UsersFinder'
);

class Model_Users extends Orm_Orm {
    public static function setUp(Orm_Schema $schema) {
        $schema->setModel('Users');
        $schema->setDb('users.sqlite');
        $schema->setTable('users');

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

class UsersFinder extends Orm_Orm {
    public static function setUp(Orm_Schema $schema) {
        $schema->registerQuery('findByFirstName', ['first_name']);
    }

/*
    public function find($pk) {
        $sql = 'select * from users where user_id=?';
        $params = [$pk];
        return $this->query($sql, $params, true);
    }
*/
}
