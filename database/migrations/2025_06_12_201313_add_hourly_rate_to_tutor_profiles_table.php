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
        Schema::table('tutor_profiles', function (Blueprint $table) {
            $table->decimal('hourly_rate', 6, 2)->after('bio'); // or place it wherever makes sense
        });
    }

    public function down()
    {
        Schema::table('tutor_profiles', function (Blueprint $table) {
            $table->dropColumn('hourly_rate');
        });
    }

};
