<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['client', 'admin', 'master_admin'])
                  ->default('client')
                  ->after('email');
        });

        // Migrate existing is_admin data → role
        DB::statement("UPDATE users SET role = 'admin' WHERE is_admin = 1");

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->after('email');
        });

        DB::statement("UPDATE users SET is_admin = 1 WHERE role IN ('admin','master_admin')");

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
