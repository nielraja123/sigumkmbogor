<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class AddConfirmedAndUserIdToSpotsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('spots', function (Blueprint $table) {
            $table->boolean('confirmed')->default(false)->after('nomor_telepon');
            $table->unsignedBigInteger('user_id')->nullable()->after('confirmed');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Set confirmed to true and user_id to 1 for existing records
        DB::table('spots')->update(['confirmed' => true, 'user_id' => 1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spots', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('confirmed');
            $table->dropColumn('user_id');
        });
    }
}
