<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Cek dulu: Kalau kolom 'gender' BELUM ada, baru buat.
            if (!Schema::hasColumn('products', 'gender')) {
                $table->enum('gender', ['Men', 'Women', 'Unisex'])->default('Unisex')->after('description');
            }

            // Cek dulu: Kalau kolom 'notes' BELUM ada, baru buat.
            if (!Schema::hasColumn('products', 'notes')) {
                $table->string('notes')->nullable()->after('gender');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'gender')) {
                $table->dropColumn('gender');
            }
            if (Schema::hasColumn('products', 'notes')) {
                $table->dropColumn('notes');
            }
        });
    }
};