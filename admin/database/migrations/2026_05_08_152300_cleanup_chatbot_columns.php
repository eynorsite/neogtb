<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cleanup migration for chatbot tables.
     *
     * Goals:
     *  - Rename `chatbot_faqs.order` -> `chatbot_faqs.sort_order`
     *    (`order` is a reserved SQL keyword in MySQL/Postgres).
     *
     * Note on float -> decimal for cost columns
     *  (`chatbot_conversations.total_cost_eur`, `chatbot_messages.cost_eur`,
     *  `chatbot_messages.latency_ms`):
     *  Changing column types via Schema::table()->...->change() requires
     *  doctrine/dbal and is risky on SQLite (where decimal and float are both
     *  stored as REAL anyway). On SQLite the change would be cosmetic and
     *  bring no runtime difference. We intentionally skip it here. Newer
     *  migrations / fresh databases on MySQL/Postgres should use decimal()
     *  for those columns. See README of chatbot module if needed.
     */
    public function up(): void
    {
        if (Schema::hasColumn('chatbot_faqs', 'order') && ! Schema::hasColumn('chatbot_faqs', 'sort_order')) {
            // Drop the index that references `order` first (created in 152245
            // migration as ['is_active', 'order']) so SQLite does not complain.
            Schema::table('chatbot_faqs', function (Blueprint $table) {
                try {
                    $table->dropIndex(['is_active', 'order']);
                } catch (Throwable $e) {
                    // Index may not exist on older databases — ignore.
                }
            });

            Schema::table('chatbot_faqs', function (Blueprint $table) {
                $table->renameColumn('order', 'sort_order');
            });

            Schema::table('chatbot_faqs', function (Blueprint $table) {
                $table->index(['is_active', 'sort_order']);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('chatbot_faqs', 'sort_order') && ! Schema::hasColumn('chatbot_faqs', 'order')) {
            Schema::table('chatbot_faqs', function (Blueprint $table) {
                try {
                    $table->dropIndex(['is_active', 'sort_order']);
                } catch (Throwable $e) {
                    // ignore
                }
            });

            Schema::table('chatbot_faqs', function (Blueprint $table) {
                $table->renameColumn('sort_order', 'order');
            });

            Schema::table('chatbot_faqs', function (Blueprint $table) {
                $table->index(['is_active', 'order']);
            });
        }
    }
};
