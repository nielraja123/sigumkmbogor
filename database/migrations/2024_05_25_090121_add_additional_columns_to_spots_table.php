<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalColumnsToSpotsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('spots', function (Blueprint $table) {
            $table->string('nama_pemilik')->nullable()->after('category');
            $table->string('alamat')->nullable()->after('nama_pemilik');
            $table->unsignedBigInteger('id_kategori')->nullable()->after('alamat');
            $table->string('kecamatan')->nullable()->after('id_kategori');
            $table->string('nomor_telepon')->nullable()->after('kecamatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spots', function (Blueprint $table) {
            $table->dropColumn('nama_pemilik');
            $table->dropColumn('alamat');
            $table->dropColumn('id_kategori');
            $table->dropColumn('kecamatan');
            $table->dropColumn('nomor_telepon');
        });
    }
}
