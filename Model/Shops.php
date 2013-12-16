<?php
class Model_Shops extends Orm_Model {

    public function setUp(Orm_Schema $schema) {
        $schema->setDb('site.sqlite');
        $schema->setTableName('shops');

        $schema->addPKField('shop_id');
        $schema->addField('user_id');
        $schema->addField('shop_name');
        $schema->addCreateDateField('create_date');
        $schema->addUpdateDateField('update_date');

        // register finders
        $schema->registerQuery('findByUserId', ['user_id'], Orm_Sources::SINGLE_RESULT);
    }

    public function User() {
        $uf = new Model_Users();
        return $uf->find($this->user_id);
    }

    // custom finders
    public function findByShopName($shop_name) {
        $sql = 'select * from shops where shop_name=?';
        $params = [$shop_name];
        return $this->query($sql, $params);
    }
}
