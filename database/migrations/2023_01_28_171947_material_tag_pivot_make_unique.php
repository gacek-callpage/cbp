<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('material_tag', function (Blueprint $table) {
            $table->unique(['material_id', 'tag_id']);
        });
    }

    public function down()
    {
        Schema::table('material_tag', function (Blueprint $table) {
            $table->dropUnique(['material_id', 'tag_id']);
        });
    }
};
