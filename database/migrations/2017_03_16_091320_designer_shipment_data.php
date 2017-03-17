<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DesignerShipmentData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('designer', function (Blueprint $table) {
            $table->integer('address_id')->unsigned()->nullable()->after('logo_id'); // Address for return
            $table->decimal('vat_rate', 2, 2)->unsigned()->nullable()->after('city_id');
            $table->decimal('national_shipment', 5, 2)->unsigned()->nullable()->after('vat_rate'); // Finland
            $table->decimal('regional_shipment', 5, 2)->unsigned()->nullable()->after('national_shipment'); // Europe
            $table->decimal('international_shipment', 5, 2)->unsigned()->nullable()->after('regional_shipment');
            $table->decimal('free_shipment_over', 8, 2)->unsigned()->nullable()->after('international_shipment');

            $table->foreign('address_id')->references('id')->on('address')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('designer', function (Blueprint $table) {
            $table->dropColumn(['address_id', 'vat_rate', 'national_shipment', 'regional_shipment', 'international_shipment', 'free_shipment_over']);
        });
    }
}
