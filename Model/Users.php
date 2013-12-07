<?php

Orm_Registry::registerModel(
    'Users',
    'Model_Users',
    'Model_UsersFinder'
);

class Model_Users extends Orm_Orm {
    public function setUp() {
        $this->setModel('Users');
        $this->setDb('users.sqlite');
        $this->setTable('users');

        $this->addPKField('user_id');
        $this->addField('first_name');
        $this->addField('last_name');
        $this->addField('email');
        $this->addCreateDateField('create_date');
        $this->addUpdateDateField('update_date');
    }

    public function fullName() {
        return $this->first_name . ' ' . $this->last_name;
    }
}

class UsersFinder extends Orm_Orm {
    public function setUp() {
        $this->setModel('Users');
        $this->setDb('users.sqlite');
        $this->setTable('users');

        $this->registerQuery('findByFirstName', ['first_name']);
    }

    /*
    public function find($pk) {
        $sql = 'select * from users where user_id=?';
        $params = [$pk];
        return $this->query($sql, $params, true);
    }
    */
}
