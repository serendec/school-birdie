<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->string('tokushoho_company_name')->nullable()->comment('販売事業所名');
            $table->text('tokushoho_address')->nullable()->comment('所在地');
            $table->string('tokushoho_tel')->nullable()->comment('電話番号');
            $table->string('tokushoho_email')->nullable()->comment('メールアドレス');
            $table->string('tokushoho_representative')->nullable()->comment('運営統括責任者');
            $table->text('tokushoho_additional_fees')->nullable()->comment('追加手数料等の追加料金');
            $table->text('tokushoho_refund_policy')->nullable()->comment('返金ポリシー');
            $table->text('tokushoho_delivery_time')->nullable()->comment('引渡時期');
            $table->text('tokushoho_payment_method')->nullable()->comment('お支払い方法');
            $table->text('tokushoho_payment_period')->nullable()->comment('決済期間');
            $table->text('tokushoho_price')->nullable()->comment('販売価格');
            $table->text('tokushoho_validity_period')->nullable()->comment('お申込み有効期限');
            $table->text('tokushoho_sales_quantity')->nullable()->comment('販売数量');
            $table->text('tokushoho_usage_method')->nullable()->comment('ご利用方法');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn([
                'tokushoho_company_name',
                'tokushoho_address',
                'tokushoho_tel',
                'tokushoho_email',
                'tokushoho_representative',
                'tokushoho_additional_fees',
                'tokushoho_refund_policy',
                'tokushoho_delivery_time',
                'tokushoho_payment_method',
                'tokushoho_payment_period',
                'tokushoho_price',
                'tokushoho_validity_period',
                'tokushoho_sales_quantity',
                'tokushoho_usage_method'
            ]);
        });
    }
};
