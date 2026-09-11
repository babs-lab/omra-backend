<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->longText('details_formule')->nullable()->after('description');
            $table->json('encadrement')->nullable()->after('details_formule');
            $table->longText('transport')->nullable()->after('encadrement');
            $table->json('inclus')->nullable()->after('transport');
            $table->json('non_inclus')->nullable()->after('inclus');
        });
    }

    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn([
                'details_formule',
                'encadrement',
                'transport',
                'inclus',
                'non_inclus',
            ]);
        });
    }
};
