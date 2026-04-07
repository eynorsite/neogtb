<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('posts')) {
            Schema::table('posts', function (Blueprint $table) {
                if (Schema::hasColumn('posts', 'author_id')) $table->index('author_id', 'posts_author_id_idx');
                if (Schema::hasColumn('posts', 'category_id')) $table->index('category_id', 'posts_category_id_idx');
                if (Schema::hasColumn('posts', 'deleted_at')) $table->index('deleted_at', 'posts_deleted_at_idx');
            });
        }

        if (Schema::hasTable('site_pages')) {
            Schema::table('site_pages', function (Blueprint $table) {
                if (Schema::hasColumn('site_pages', 'slug')) $table->index('slug', 'site_pages_slug_idx');
                if (Schema::hasColumn('site_pages', 'deleted_at')) $table->index('deleted_at', 'site_pages_deleted_at_idx');
            });
        }

        if (Schema::hasTable('post_categories')) {
            Schema::table('post_categories', function (Blueprint $table) {
                if (Schema::hasColumn('post_categories', 'is_active')) $table->index('is_active', 'post_categories_is_active_idx');
            });
        }

        if (Schema::hasTable('audit_leads')) {
            Schema::table('audit_leads', function (Blueprint $table) {
                if (Schema::hasColumn('audit_leads', 'email')) $table->index('email', 'audit_leads_email_idx');
            });
        }

        if (Schema::hasTable('cee_leads')) {
            Schema::table('cee_leads', function (Blueprint $table) {
                if (Schema::hasColumn('cee_leads', 'email')) $table->index('email', 'cee_leads_email_idx');
                if (Schema::hasColumn('cee_leads', 'sector')) $table->index('sector', 'cee_leads_sector_idx');
            });
        }

        if (Schema::hasTable('media')) {
            Schema::table('media', function (Blueprint $table) {
                if (Schema::hasColumn('media', 'mime_type')) $table->index('mime_type', 'media_mime_type_idx');
                if (Schema::hasColumn('media', 'uploaded_by')) $table->index('uploaded_by', 'media_uploaded_by_idx');
            });
        }

        if (Schema::hasTable('navigation_items')) {
            Schema::table('navigation_items', function (Blueprint $table) {
                if (Schema::hasColumn('navigation_items', 'menu_id')) $table->index('menu_id', 'nav_items_menu_id_idx');
                if (Schema::hasColumn('navigation_items', 'parent_id')) $table->index('parent_id', 'nav_items_parent_id_idx');
            });
        }

        if (Schema::hasTable('admin_activity_logs')) {
            Schema::table('admin_activity_logs', function (Blueprint $table) {
                if (Schema::hasColumn('admin_activity_logs', 'admin_id')) $table->index('admin_id', 'admin_logs_admin_id_idx');
                if (Schema::hasColumn('admin_activity_logs', 'created_at')) $table->index('created_at', 'admin_logs_created_at_idx');
            });
        }

        if (Schema::hasTable('contact_messages')) {
            Schema::table('contact_messages', function (Blueprint $table) {
                if (Schema::hasColumn('contact_messages', 'deleted_at')) $table->index('deleted_at', 'contact_messages_deleted_at_idx');
            });
        }

        if (Schema::hasTable('admins')) {
            Schema::table('admins', function (Blueprint $table) {
                if (Schema::hasColumn('admins', 'deleted_at')) $table->index('deleted_at', 'admins_deleted_at_idx');
            });
        }

        if (Schema::hasTable('cookie_consents')) {
            Schema::table('cookie_consents', function (Blueprint $table) {
                if (Schema::hasColumn('cookie_consents', 'ip_hash')) $table->index('ip_hash', 'cookie_consents_ip_hash_idx');
            });
        }
    }

    public function down(): void
    {
        $drops = [
            'posts' => ['posts_author_id_idx', 'posts_category_id_idx', 'posts_deleted_at_idx'],
            'site_pages' => ['site_pages_slug_idx', 'site_pages_deleted_at_idx'],
            'post_categories' => ['post_categories_is_active_idx'],
            'audit_leads' => ['audit_leads_email_idx'],
            'cee_leads' => ['cee_leads_email_idx', 'cee_leads_sector_idx'],
            'media' => ['media_mime_type_idx', 'media_uploaded_by_idx'],
            'navigation_items' => ['nav_items_menu_id_idx', 'nav_items_parent_id_idx'],
            'admin_activity_logs' => ['admin_logs_admin_id_idx', 'admin_logs_created_at_idx'],
            'contact_messages' => ['contact_messages_deleted_at_idx'],
            'admins' => ['admins_deleted_at_idx'],
            'cookie_consents' => ['cookie_consents_ip_hash_idx'],
        ];

        foreach ($drops as $table => $indexes) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $t) use ($indexes) {
                    foreach ($indexes as $idx) {
                        try { $t->dropIndex($idx); } catch (\Throwable $e) {}
                    }
                });
            }
        }
    }
};
