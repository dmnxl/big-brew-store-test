<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrderLinesForeignKeyToSetNull extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_lines', function (Blueprint $table) {
            // Drop the foreign key if it exists
            $foreignKeys = Schema::getConnection()
                ->getDoctrineSchemaManager()
                ->listTableForeignKeys('order_lines');

            foreach ($foreignKeys as $foreignKey) {
                if ($foreignKey->getName() === 'order_lines_product_id_foreign') {
                    $table->dropForeign(['product_id']); }
            }

            // Add the new foreign key with ON DELETE SET NULL
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('set null')
                ->onUpdate('cascade'); // Optional: update the product_id on change
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_lines', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('restrict');
        });
    }
}
