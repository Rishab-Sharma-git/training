<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->string('field_name');
            $table->string('excel_column_name');
            $table->boolean('include_in_excel')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('configurations');
    }
};
