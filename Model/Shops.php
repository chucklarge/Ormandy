<?php

Orm_Registry::registerModel(
    'Shops',
    'Model_Shops',
    'Model_ShopsFinder'
);

class Model_Shops extends Orm_ModelBase {
    public static function setUp(Orm_Schema $schema) {
        $schema->setDb('site.sqlite');
        $schema->setTableName('shops');

        $schema->addPKField('shop_id');
        $schema->addField('user_id');
        $schema->addField('shop_name');
        $schema->addCreateDateField('create_date');
        $schema->addUpdateDateField('update_date');
    }

    public function User() {
        $uf = new Model_UsersFinder();
        return $uf->find($this->user_id);
    }
}

class Model_ShopsFinder extends Orm_ModelBase {
    public static function setUp(Orm_Schema $schema) {
        $schema->registerQuery('findByUserId', ['user_id']);
    }

    public function findByShopName($shop_name) {
        $sql = 'select * from shops where shop_name=?';
        $params = [$shop_name];
        return $this->query($sql, $params, true);
    }
}
