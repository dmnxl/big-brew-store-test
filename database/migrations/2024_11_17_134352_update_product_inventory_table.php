<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_inventory', function (Blueprint $table) {
            $table->dropColumn('grams');
            $table->integer('quantity');
            $table->string('unit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_inventory', function (Blueprint $table) {
            $table->integer('grams');
            $table->dropColumn('quantity');
            $table->dropColumn('unit');
        });
    }
}
