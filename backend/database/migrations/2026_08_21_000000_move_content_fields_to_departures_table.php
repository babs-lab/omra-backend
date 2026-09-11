<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('departures', function (Blueprint $table) {
            $table->longText('details_formule')->nullable()->after('currency_id');
            $table->json('encadrement')->nullable()->after('details_formule');
            $table->longText('transport')->nullable()->after('encadrement');
            $table->json('inclus')->nullable()->after('transport');
            $table->json('non_inclus')->nullable()->after('inclus');
        });

        Schema::create('departure_hotel', function (Blueprint $table) {
            $table->foreignId('departure_id')->constrained()->cascadeOnDelete();
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('nights');
            $table->primary(['departure_id', 'hotel_id']);
        });

        DB::statement('
            UPDATE departures d
            JOIN packages p ON d.package_id = p.id
            SET
                d.details_formule = p.details_formule,
                d.encadrement = p.encadrement,
                d.transport = p.transport,
                d.inclus = p.inclus,
                d.non_inclus = p.non_inclus
        ');

        DB::statement('
            INSERT INTO departure_hotel (departure_id, hotel_id, nights)
            SELECT d.id, ph.hotel_id, ph.nights
            FROM package_hotel ph
            JOIN departures d ON d.package_id = ph.package_id
        ');

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

    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->longText('details_formule')->nullable()->after('description');
            $table->json('encadrement')->nullable()->after('details_formule');
            $table->longText('transport')->nullable()->after('encadrement');
            $table->json('inclus')->nullable()->after('transport');
            $table->json('non_inclus')->nullable()->after('inclus');
        });

        DB::statement('
            UPDATE packages p
            JOIN (
                SELECT package_id, details_formule, encadrement, transport, inclus, non_inclus,
                       ROW_NUMBER() OVER (PARTITION BY package_id ORDER BY id) as rn
                FROM departures
            ) d ON p.id = d.package_id AND d.rn = 1
            SET
                p.details_formule = d.details_formule,
                p.encadrement = d.encadrement,
                p.transport = d.transport,
                p.inclus = d.inclus,
                p.non_inclus = d.non_inclus
        ');

        Schema::dropIfExists('departure_hotel');

        Schema::table('departures', function (Blueprint $table) {
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
