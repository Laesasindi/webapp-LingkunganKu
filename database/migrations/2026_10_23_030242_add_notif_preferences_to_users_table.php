<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('notif_laporan_baru')->default(true)->after('is_admin');
            $table->boolean('notif_perubahan_status')->default(true)->after('notif_laporan_baru');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['notif_laporan_baru', 'notif_perubahan_status']);
        });
    }
};
