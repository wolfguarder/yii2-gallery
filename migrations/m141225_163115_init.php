<?php

use yii\db\Schema;
use wolfguard\gallery\migrations\Migration;

class m141225_163115_init extends Migration
{
    public function up()
    {
        $this->createTable('{{%gallery}}', [
                'id' => $this->primaryKey(),
                'code' => $this->string()->notNull(),
                'name' => $this->string()->notNull(),
                'description' => $this->text(),
                'sort' => $this->integer()->defaultValue(500),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
            ]
        );

        $this->createIndex('ix_gallery_name', '{{%gallery}}', 'name');
        $this->createIndex('ix_gallery_code', '{{%gallery}}', 'code', true);
        $this->createIndex('ix_gallery_sort', '{{%gallery}}', 'sort');

        /**
         * image_to_gallery:
         **/
        $this->createTable('{{%gallery_image}}', [
                'id' => $this->primaryKey(),
                'gallery_id' => $this->integer()->notNull(),
                'file' => $this->string(),
                'alt' => $this->string(),
                'sort' => $this->integer()->defaultValue(500),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
            ]
        );

        $this->createIndex("ix_gallery_image_gallery_id", '{{%gallery_image}}', "gallery_id");
        $this->createIndex("ix_gallery_image_sort", '{{%gallery_image}}', "sort");

        $this->addForeignKey("fk_gallery_image_gallery_id",'{{%gallery_image}}', 'gallery_id','{{%gallery}}', 'id', 'CASCADE', 'NO ACTION');
    }

    public function down()
    {
        $this->dropForeignKey("fk_gallery_image_gallery_id",'{{%gallery_image}}');

        $this->dropTable('{{%gallery_image}}');
        $this->dropTable('{{%gallery}}');
    }
}
