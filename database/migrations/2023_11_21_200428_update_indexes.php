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
        Schema::table('applied_coupons', function(Blueprint $table)
        {
            $table->index(['redeemed_coupon_id','model_id']);
        });
        Schema::table('groups', function(Blueprint $table)
        {
            $table->index('AzureID');
        });
        Schema::table('payments', function(Blueprint $table)
        {
            $table->index(['order_id','mollie_payment_id','mollie_mandate_id','owner_id'],'payments_table_index');
        });
        Schema::table('redeemed_coupons', function(Blueprint $table)
        {
            $table->index(['model_id','owner_id']);
        });
        Schema::table('non_member_activity_signup', function(Blueprint $table)
        {
            $table->index('groupId');
        });
        Schema::table('transaction', function(Blueprint $table)
        {
            $table->index('transactionId');
        });
        Schema::table('order_items', function(Blueprint $table)
        {
            $table->index(['orderable_id','owner_id','order_id']);
        });
        Schema::table('users', function(Blueprint $table)
        {
            $table->index(['AzureID','mollie_customer_id','mollie_mandate_id']);
        });
        Schema::table('orders', function(Blueprint $table)
        {
            $table->index(['owner_id','mollie_payment_id']);
        });
        Schema::table('subscriptions', function(Blueprint $table)
        {
            $table->index(['owner_id','scheduled_order_item_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applied_coupons', function(Blueprint $table)
        {
            $table->dropIndex(['redeemed_coupon_id','model_id']);
        });
        Schema::table('groups', function(Blueprint $table)
        {
            $table->dropIndex('AzureID');
        });
        Schema::table('payments', function(Blueprint $table)
        {
            $table->dropIndex(['order_id','mollie_payment_id','mollie_mandate_id','owner_id']);
        });
        Schema::table('redeemed_coupons', function(Blueprint $table)
        {
            $table->dropIndex(['model_id','owner_id']);
        });
        Schema::table('non_member_activity_signup', function(Blueprint $table)
        {
            $table->dropIndex('group_id');
        });
        Schema::table('transaction', function(Blueprint $table)
        {
            $table->dropIndex('transactionId');
        });
        Schema::table('order_items', function(Blueprint $table)
        {
            $table->dropIndex(['orderable_id','owner_id','order_id']);
        });
        Schema::table('users', function(Blueprint $table)
        {
            $table->dropIndex(['AzureID','mollie_customer_id','mollie_mandate_id']);
        });
        Schema::table('orders', function(Blueprint $table)
        {
            $table->dropIndex(['owner_id','mollie_payment_id']);
        });
        Schema::table('subscriptions', function(Blueprint $table)
        {
            $table->dropIndex(['owner_id','scheduled_order_item_id']);
        });

    }
};
