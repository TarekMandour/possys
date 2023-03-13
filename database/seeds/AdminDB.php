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
use App\Models\Language;

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
        $add->type = 0;
        $add->save();

        $add = new Setting;
        $add->id = 1;
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
        $add->tax_num = '311008877400003';
        
        $add->facebook = 'facebook';
        $add->twitter = 'twitter';
        $add->youtube = 'youtube';
        $add->linkedin = 'linkedin';
        $add->instagram = 'instagram';
        $add->snapchat = 'snapchat';
        $add->website_type = 'sell';
        $add->tax = 15;

        $add->save();


        $add = new Language;
        $add->id = '407';
        $add->ar_name = 'عميل';
        $add->en_name = 'client';
        $add->page_name = 'client';
        $add->slug = 'client';
        $add->save();

        $add = new Language;
        $add->id = '408';
        $add->ar_name = 'مورد';
        $add->en_name = 'supplier';
        $add->page_name = 'supplier';
        $add->slug = 'supplier';
        $add->save();

        $add = new Language;
        $add->id = '409';
        $add->ar_name = 'جهه خارجية';
        $add->en_name = 'external';
        $add->page_name = 'external';
        $add->slug = 'external';
        $add->save();

        $add = new Language;
        $add->id = '410';
        $add->ar_name = 'نقدآ';
        $add->en_name = 'cash';
        $add->page_name = 'cash';
        $add->slug = 'cash';
        $add->save();

        $add = new Language;
        $add->id = '411';
        $add->ar_name = 'شبكة';
        $add->en_name = 'network';
        $add->page_name = 'network';
        $add->slug = 'network';
        $add->save();

        $add = new Language;
        $add->id = '412';
        $add->ar_name = 'قبض';
        $add->en_name = 'receipt';
        $add->page_name = 'receipt';
        $add->slug = 'receipt';
        $add->save();

        $add = new Language;
        $add->id = '413';
        $add->ar_name = 'صرف';
        $add->en_name = 'exchange';
        $add->page_name = 'exchange';
        $add->slug = 'exchange';
        $add->save();


        for ($i=1; $i < 2; $i++) { 
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
            $add->title = 'منتج  '. $i;
            $add->cat_id = 1;
            $add->is_show = 1;
            $add->is_tax = 0;
            $add->itm_code  = 100 + $i;
            $add->itm_unit1 = 1;
            $add->itm_unit2 = 1;
            $add->itm_unit3 = 1;
            $add->mid = 1;
            $add->sm = 1;
            $add->status = 1;
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
