<?php

use yii\db\Migration;

/**
 * Class m250216_164545_popup
 */
class m250216_164545_popup extends Migration
{

    public function up()
    {
        $this->createTable('popup', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'content' => $this->text()->notNull(),
            'is_active' => $this->boolean()->defaultValue(true),
            'width' => $this->integer()->defaultValue(600),
            'height' => $this->integer()->defaultValue(400),
            'display_count' => $this->integer()->defaultValue(0),
            'show_after' => $this->integer()->defaultValue(10), // время задержки перед всплыитием окна в секундах, по умолчанию 10 секунд
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    public function down()
    {
        $this->dropTable('popup');
    }
}
