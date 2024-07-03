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
            
            // 'translations-author-view','translations-author-create','translations-author-edit',
            // 'author-view','author-create','author-edit',
            // 'surah-translations-view','surah-translations-combination-add',
            // 'surah-translations-combination-action','add-surah-translations',
            // 'surah-Tafseer-view','surah-Tafseer-combination-add',
            // 'surah-Tafseer-combination-action','add-surah-Tafseer',
            // 'add-hadith', 'add-hadith-book',
            // 'hadith-translations-view','hadith-translations-combination-add',
            // 'hadith-translations-combination-action','add-hadith-translations',
            // 'hadith-Tafseer-view','hadith-Tafseer-combination-add',
            // 'hadith-Tafseer-combination-action','add-hadith-Tafseer',
            // 'language-view','language-create','language-edit',
            // 'category-view','category-create','category-edit', 'category-toggle',
            // 'eBook-view','eBook-create','eBook-edit', 'eBook-toggle',
            // 'audio-book-view','audio-book-create','audio-book-edit', 'audio-book-toggle',
            // 'add-audio-book-chapter','edit-audio-book-chapter','delete-audio-book-chapter',
            // 'papers-view','papers-create','papers-edit', 'papers-toggle',
            // 'podcast-view','podcast-create','podcast-edit', 'podcast-toggle',
            // 'add-podcast-episode','edit-podcast-episode','delete-podcast-episode',
            // 'course-view','course-create','course-edit', 'course-toggle',
            // 'add-course-lesson','edit-course-lesson','delete-course-lesson',
            // 'course-series-view','course-series-create','course-series-edit', 'course-series-toggle',
            // 'publisher-view','publisher-create','publisher-edit',
            // 'app-section-view','app-section-create','app-section-edit','add-content','app-section-toggle',

            // 'pending-eBook','pending-audio-book','pending-papers','pending-podcast','pending-course','rejected-content','approved-content'
            //    'app-user-view','app-user-detail','app-user-profile',
            //    'affiliate-users','affiliate-child-users','affiliate-users-detail',
               'family','family-members','family-members-detail'
               

            
         ];
      
         foreach ($permissions as $permission) {
            Permission::create([
                'name'        => $permission,
                'role_id'     => '667d50ca42baf699790dd954',
            ]);
         }
    }
}
