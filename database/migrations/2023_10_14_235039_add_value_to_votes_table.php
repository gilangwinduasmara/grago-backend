<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            if (!Schema::hasColumn('votes', 'value')){
                $table->integer('value')->default(0);
            }
            if (Schema::hasColumn('votes', 'vote')){
                $table->dropColumn('vote');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            if (Schema::hasColumn('votes', 'value')){
                $table->dropColumn('value');
            }
            if (!Schema::hasColumn('votes', 'vote')){
                $table->integer('vote');
            }
        });
    }
};
