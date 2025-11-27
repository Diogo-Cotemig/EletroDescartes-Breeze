<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pagamentos', function (Blueprint $table) {
            $table->decimal('points_awarded', 10, 2)->default(0)->after('codigo_pix');
            $table->foreignId('user_id')->nullable()->after('agendamento_id')->constrained('users')->onDelete('set null');
        });

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'descarte_points')) {
                $table->decimal('descarte_points', 10, 2)->default(0)->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pagamentos', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['points_awarded', 'user_id']);
        });

        if (Schema::hasColumn('users', 'descarte_points')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('descarte_points');
            });
        }
    }
};