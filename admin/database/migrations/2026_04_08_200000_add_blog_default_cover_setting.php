<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Insère le setting blog_default_cover s'il n'existe pas
        $exists = DB::table('site_settings')->where('key', 'blog_default_cover')->exists();
        if (! $exists) {
            DB::table('site_settings')->insert([
                'group'       => 'blog',
                'key'         => 'blog_default_cover',
                'value'       => '/images/blog-default-cover.png',
                'type'        => 'image',
                'label'       => 'Image par défaut articles',
                'description' => 'Affichée sur les cards et hero des articles qui n\'ont pas d\'image cover spécifique.',
                'is_public'   => true,
                'order'       => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        // Vide les featured_image des posts existants pour qu'ils tombent tous sur le default
        // (pilotable depuis Filament Posts au cas par cas si on veut une cover spécifique)
        DB::table('posts')->update(['featured_image' => null]);
    }

    public function down(): void
    {
        DB::table('site_settings')->where('key', 'blog_default_cover')->delete();
    }
};
