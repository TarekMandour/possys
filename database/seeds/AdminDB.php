<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Contact;
use App\Models\Page;
use App\Models\Service;
use App\Models\Category;
use App\Models\Post;
use App\Models\Partner;

class AdminDB extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $add = new Admin;
        $add->name = 'Tarek Mandour';
        $add->email = 'tarek.mandourr@gmail.com';
        $add->phone = '01006287379';
        $add->password = Hash::make(123456);
        $add->is_active = 1;
        $add->save();

        $add = new Setting;
        $add->title = 'موقع تجريبي';
        $add->meta_keywords = 'موقع تجريبي 1 , موقع تجريب 2';
        $add->meta_description = 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى';
        $add->logo1 = 'logo1.png';
        $add->logo2 = 'logo2.png';
        $add->fav = 'fav.png';
        $add->breadcrumb = 'breadcrumb.png';
        $add->site_lang = 'ar';
        $add->phone1 = '01006287379';
        $add->phone2 = '01006287379';
        $add->email1 = 'tarek.mandourr@gmail.com';
        $add->email2 = 'tarek.mandourr@gmail.com';
        $add->address = 'العنوان شارع العنوان';
        $add->facebook = 'facebook';
        $add->twitter = 'twitter';
        $add->youtube = 'youtube';
        $add->linkedin = 'linkedin';
        $add->instagram = 'instagram';
        $add->snapchat = 'snapchat';
        $add->save();

        for ($i=1; $i < 16; $i++) { 
            $add = new Category;
            $add->title = 'القسم '. $i;
            $add->parent = '0';
            $add->meta_keywords = 'meta_keywords';
            $add->meta_description = 'meta_description';
            $add->save();
        }

        for ($i=1; $i < 16; $i++) { 
            $add = new Contact;
            $add->name = 'رسالة  '. $i;
            $add->email = 'tarek.mandourr'.$i.'@gmail.com';
            $add->phone = '01006287379';
            $add->msg = 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى';
            $add->save();
        }

        for ($i=1; $i < 3; $i++) { 
            $add = new Page;
            $add->title = 'صفحة  '. $i;
            $add->content = 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى';
            $add->meta_keywords = 'meta_keywords';
            $add->meta_description = 'meta_description';
            $add->save();
        }

        for ($i=1; $i < 16; $i++) { 
            $add = new Service;
            $add->title = 'خدمة  '. $i;
            $add->content = 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى';
            $add->meta_keywords = 'meta_keywords';
            $add->meta_description = 'meta_description';
            $add->save();
        }

        for ($i=1; $i < 16; $i++) { 
            $add = new Post;
            $add->title = 'مقالة  '. $i;
            $add->content = 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى';
            $add->cat_id = $i;
            $add->meta_keywords = 'meta_keywords';
            $add->meta_description = 'meta_description';
            $add->save();
        }

        for ($i=1; $i < 16; $i++) { 
            $add = new Partner;
            $add->title = 'شركاؤنا  '. $i;
            $add->link = 'http://google.com';
            $add->save();
        }

    }
}
