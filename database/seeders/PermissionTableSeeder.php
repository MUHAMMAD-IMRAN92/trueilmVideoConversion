<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


use App\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $permissions = [
            
            'translations-author-view','translations-author-create','translations-author-edit',
            'author-view','author-create','author-edit',
            'surah-translations-view','surah-translations-combination-add',
            'surah-translations-combination-action','add-surah-translations',
            'surah-Tafseer-view','surah-Tafseer-combination-add',
            'surah-Tafseer-combination-action','add-surah-Tafseer',
            'add-hadith', 'add-hadith-book',
            'hadith-translations-view','hadith-translations-combination-add',
            'hadith-translations-combination-action','add-hadith-translations',
            'hadith-Tafseer-view','hadith-Tafseer-combination-add',
            'hadith-Tafseer-combination-action','add-hadith-Tafseer',
            'language-view','language-create','language-edit',
            'category-view','category-create','category-edit', 'category-toggle',
            'eBook-view','eBook-create','eBook-edit', 'eBook-toggle',
            'audio-book-view','audio-book-create','audio-book-edit', 'audio-book-toggle',
            
            
         ];
      
         foreach ($permissions as $permission) {
            Permission::create([
                'name'        => $permission,
                'role_id'     => '667d50ca42baf699790dd954',
            ]);
         }
    }
}
