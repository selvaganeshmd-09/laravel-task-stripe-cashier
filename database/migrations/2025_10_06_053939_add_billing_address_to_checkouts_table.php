<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('checkouts', function (Blueprint $table) {
            $table->string('billing_name', 150)->nullable()->after('stripe_payment_id');
            $table->string('billing_email', 150)->nullable()->after('billing_name');
            $table->string('billing_phone', 20)->nullable()->after('billing_email');
            $table->string('billing_street', 255)->nullable()->after('billing_phone');
            $table->string('billing_city', 100)->nullable()->after('billing_street');
            $table->string('billing_state', 100)->nullable()->after('billing_city');
            $table->string('billing_zip', 20)->nullable()->after('billing_state');
            $table->string('billing_country', 100)->nullable()->after('billing_zip');
        });
    }

    public function down(): void
    {
        Schema::table('checkouts', function (Blueprint $table) {
            $table->dropColumn([
                'billing_name',
                'billing_email',
                'billing_phone',
                'billing_street',
                'billing_city',
                'billing_state',
                'billing_zip',
                'billing_country',
            ]);
        });
    }
};