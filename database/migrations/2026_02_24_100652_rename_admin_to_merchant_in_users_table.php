<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * SQLite stores "enum" values as plain text, so we only need
     * to UPDATE the data — no ALTER TABLE needed.
     */
    public function up(): void
    {
        DB::table('users')
            ->where('role', 'admin')
            ->update(['role' => 'merchant']);
    }

    public function down(): void
    {
        DB::table('users')
            ->where('role', 'merchant')
            ->update(['role' => 'admin']);
    }
};
