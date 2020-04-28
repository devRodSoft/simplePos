<?php

use yii\db\Migration;

/**
 * Class m200424_063547_addUserSucursal
 */
class m200424_063547_addUserSucursal extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'sucursalId', $this->integer()->notNull()->after('username'));

        $this->addForeignKey(
            'fk-user-sucursal-id-caja',
            'user',
            'sucursalId',
            'sucursales',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200424_063547_addUserSucursal cannot be reverted.\n";

        return false;
    }
}
