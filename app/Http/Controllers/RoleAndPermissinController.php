<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;

class RoleAndPermissinController extends Controller
{
    //
    public function roleSave(Request $request)
    {

        $get_permission=[];

        $get_request = $request->all();

        foreach($get_request as $key =>$value){
            if( $key  != "_token"  && $key  != "roleName"){
                $get_permission[] = $key;

            }

            


        }
        
        $add_role              = new Role();
        $add_role->guard_name  = 'web';
        $add_role->name        = $request->roleName;
        $add_role->save();



        foreach($get_permission as $get_permission){
            $add_permission              = new Permission();
            $add_permission->role_id     = $add_role->_id;
            $add_permission->name        = $get_permission;
            $add_permission->save();

        

        

            
        }
        return redirect()->to('/roles')->with('success', 'Role Added Successfully!');;

        

    }
    public function roles()
    { 
        $get_role=Role::where('name','!=','Institute')->with('RoleUser')->get();

        return view('roles' ,compact('get_role'));


    }
    public function permission(Request $request)
    {   
        
        $permission=$this->getAllPermission();
        return view('permission' ,compact('permission'));

    }

    public function editPermission($id)
    { 
        $get_permission=Permission::where('_id',$id)->get();

        $permission=$this->getAllPermission();
        return view('edit-permission' ,compact('permission','get_permission'));

    }
    public function getAllPermission(){

        $Translations_Author         =['translations-author-view','translations-author-create',
                                       'translations-author-edit'];
        $Surah_Translations          =['surah-translations-view','surah-translations-combination-add',
                                       'surah-translations-combination-action','add-surah-translations'];
        $Surah_Tafseers              =['surah-Tafseer-view','surah-Tafseer-combination-add',
                                       'surah-Tafseer-combination-action','add-surah-Tafseer'];
        $Language                    =['language-view','language-create','language-edit'];

        $AlQuran=[
            "Translations Author"    => $Translations_Author	,
            "Surah Translations"     => $Surah_Translations   ,
            "Surah Tafseers"          => $Surah_Tafseers       ,
            "Language"               => $Language             ,

        ];

        $HadithTafseer               =['add-hadith', 'add-hadith-book','hadith-translations-view',
                                       'hadith-translations-combination-add',
                                       'hadith-translations-combination-action','add-hadith-translations'];
        $HadithTranslations          =['hadith-Tafseer-view','hadith-Tafseer-combination-add',
                                        'hadith-Tafseer-combination-action','add-hadith-Tafseer'];

        


        $Hadith=[
            "Hadith Tafseer"        => $HadithTafseer       ,
            "Hadith Translations"   => $HadithTranslations  ,
            

        ];
        $Category                   =['category-view','category-create','category-edit', 'category-toggle'];
        $eBooks                     =['eBook-view','eBook-create','eBook-edit', 'eBook-toggle'];
        $AudioBooks                 =['audio-book-view','audio-book-create','audio-book-edit', 'audio-book-toggle',
                                      'add-audio-book-chapter','edit-audio-book-chapter','delete-audio-book-chapter',]; 
        $Papers                     =['papers-view','papers-create','papers-edit', 'papers-toggle'];
        $Podcast                    =['podcast-view','podcast-create','podcast-edit', 'podcast-toggle',
                                      'add-podcast-episode','edit-podcast-episode','delete-podcast-episode',];
        $Courses                    =['course-view','course-create','course-edit', 'course-toggle',
                                      'add-course-lesson','edit-course-lesson','delete-course-lesson',
                                      'course-series-view','course-series-create','course-series-edit', 'course-series-toggle'];
        $Publishers                 =['publisher-view','publisher-create','publisher-edit'];
        $Author                     =['author-view','author-create','author-edit']; 
        $AppSections                =['app-section-view','app-section-create','app-section-edit',
                                      'add-content','app-section-toggle'];



        $Content=[
            "Category"             => $Category,
            "eBooks"               => $eBooks ,
            "Audio Books"          => $AudioBooks,
            "Papers"               => $Papers,
            "Podcast"              => $Podcast,
            "Courses"              => $Courses,
            "Publishers"           => $Publishers,
            "Author"               => $Author,
            "AppSections"          => $AppSections,

        ];

        $AdminUsers               =['view-admin-user','create-admin-user','edit-admin-user',
                                    'delete-admin-user','reset-password-admin-user'];
        $AppUsers                 =['app-user-view','app-user-detail','app-user-profile'];
        $Affiliate                =['affiliate-users','affiliate-child-users','affiliate-users-detail'];
        $Family                   =['family','family-members','family-members-detail'];
        $CancelSubscription       =['view-cancel-subscription'];

       
        




        $UserManagement=[
            "Admin Users"          => $AdminUsers,
            "App Users"            => $AppUsers ,
            "Affiliate"            => $Affiliate,
            "Family"               => $Family,
            "Cancel Subscription"  => $CancelSubscription,
           
        ];

        $PendingContent            =['pending-eBook','pending-audio-book','pending-papers','pending-podcast',
                                    'pending-course']; 
        $approvedContent            =['approved-content']; 
        $rejectedContent            =['rejected-content']; 
        $ContentforApproval=[
            "Pending for Approval" =>$PendingContent,
            "Approved Content"     =>$approvedContent,
            "Rejected Content"     =>$rejectedContent,



        ];

        $ReviewBook               =['review-book']; 
        $reflections              =['reflections']; 
        $BookMistakes             =['book-mistakes']; 


        $Review=[
            "Review Book"         =>$ReviewBook,
            "Reflections"         =>$reflections,
            "Book Mistakes"       =>$BookMistakes,

        ];

        $PendingGrant              =['pending-grant']; 
        $ApprovedGrant             =['approved-grant']; 
        $RejectedGrant             =['rejected-grant']; 


        $Grant=[
            "Pending Grant"       =>$PendingGrant,
            "Approved Grant"      =>$ApprovedGrant,
            "Rejected Grant"      =>$RejectedGrant,

        ];



        $Notifications            =['notifications-view','notifications-create'];

        $BooksForSale             =['books-for-sale','books-for-sale-create','books-for-sale-edit'];
        $EmailSubscriptions       =['email-subscriptions' ,'email-subscriptions-export'];
        $Glossory                 =['glossory-view','glossory-create','glossory-edit'];

        $Support                  =['support-view','support-detail','support-approve'];
        $Coupon                   =['coupon-view','coupon-create','coupon-delete'];
        $AppVersions              =['app-versions-view','app-versions-create'];
        $Activities               =['activities_view','activities_undo'];



        $Genral=[
            "Notifications"        => $Notifications,
            "Books For Sale"       => $BooksForSale,
            "Email Subscriptions"  => $EmailSubscriptions,
            "Glossory"             => $Glossory,
            "Support"              => $Support,
            "Coupon"               => $Coupon,
            "App Versions"         => $AppVersions,
            "Activities"           => $Activities,
        ];

        




        $permission=[
            "Al Quran"             => $AlQuran	,
            "Hadith"               => $Hadith   ,
            "Content"              => $Content  ,
            "User Management"      => $UserManagement,
            "Content for Approval" => $ContentforApproval,
            "Review"               => $Review,
            "Grant"                => $Grant,
            "Genral"               => $Genral
           


        ];

        return  $permission;

    }
    

}
