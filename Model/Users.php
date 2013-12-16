<?php
class Model_Users extends Orm_Model {

    public function setUp(Orm_Schema $schema) {
        $schema->setDb('site.sqlite');
        $schema->setTableName('users');

        $schema->addPKField('user_id');
        $schema->addField('first_name');
        $schema->addField('last_name');
        $schema->addField('email');
        $schema->addCreateDateField('create_date');
        $schema->addUpdateDateField('update_date');

        // register finders
        $schema->registerQuery('findByFirstName', ['first_name']);
    }

    public function fullName() {
        return $this->first_name . ' ' . $this->last_name;
    }

    // custom finders
    public function findByLastName($last_name) {
        $sql = 'select * from users where last_name=?';
        $params = [$last_name];
        return $this->query($sql, $params);
    }
}
