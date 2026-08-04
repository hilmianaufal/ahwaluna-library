<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $duplicateUserIds = DB::table('members')
            ->select('user_id')
            ->whereNotNull('user_id')
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('user_id');

        if ($duplicateUserIds->isNotEmpty()) {
            throw new \RuntimeException(
                'Migrasi dibatalkan. Ada user_id anggota yang terhubung ke lebih dari satu anggota: '
                . $duplicateUserIds->implode(', ')
            );
        }

        Schema::table('members', function (Blueprint $table) {
            $table->unique('user_id', 'members_user_id_unique');
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropUnique('members_user_id_unique');
        });
    }
};
