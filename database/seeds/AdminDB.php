<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Branch;
use App\Models\Attribute;
use App\Models\Client;
use App\Models\Supplier;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class AdminDB extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        
        // Permissions
        $permissions = [
            'تعديل المنتجات',
            'اضافة المنتجات',
            'حذف المنتجات',
            'رفع مجموعة اصناف منتجات',
            'تعديل المخزون',
            'حذف المخزون',
            'اضافة جرد مخزون',
            'حذف جرد مخزون',
            'اضافة الاصناف التالفة',
            'حذف الاصناف التالفة',
            'اضافة النواقص',
            'حذف النواقص',
            'اضافة السندات',
            'حذف السندات',
            'اضافة الفروع',
            'حذف الفروع',
            'تعديل الفروع',
            'اضافة الاقسام',
            'حذف الاقسام',
            'تعديل الاقسام',
            'اضافة الوحدات',
            'حذف الوحدات',
            'تعديل الوحدات',
            'اضافة الخصائص',
            'حذف الخصائص',
            'تعديل الخصائص',
            'اضافة العملاء',
            'حذف العملاء',
            'تعديل العملاء',
            'اضافة اقسام الطاولات',
            'حذف اقسام الطاولات',
            'تعديل اقسام الطاولات',
            'اضافة الطاولات',
            'حذف الطاولات',
            'تعديل الطاولات',
            'اضافة الطابعات',
            'حذف الطابعات',
            'تعديل الطابعات',
            'اضافة الموردين',
            'حذف الموردين',
            'تعديل الموردين',
            'اضافة السلايدر',
            'حذف السلايدر',
            'تعديل السلايدر',
            'اضافة الخصومات',
            'حذف الخصومات',
            'تعديل الخصومات',
            'تعديل الاعدادات',
            'اضافة الصلاحيات',
            'حذف الصلاحيات',
            'تعديل الصلاحيات',
            'اضافة المديرين',
            'حذف المديرين',
            'تعديل المديرين'
        ];


        $createdPermissions = [];
        foreach ($permissions as $permissionName) {
            $permission = Permission::create(['name' => $permissionName, 'guard_name' => 'admin']);
            $createdPermissions[] = $permission;
        }




        $role = Role::create([
            'name' => 'admin',
            'guard_name' => 'admin',
        ]);
        $role->givePermissionTo($createdPermissions);
        
        $role->save;


        $add = new Admin;
        $add->name = 'Tarek Mandour';
        $add->email = 'tarek.mandourr@gmail.com';
        $add->phone = '01006287379';
        $add->password = Hash::make(123456);
        $add->is_active = 1;
        $add->type = 0;
        $add->assignRole(['admin']);
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
        $add->currency = 'ر.س';
        $add->printing = 'a4';
        $add->opt = 'email';
        
        $add->facebook = 'facebook';
        $add->twitter = 'twitter';
        $add->youtube = 'youtube';
        $add->linkedin = 'linkedin';
        $add->instagram = 'instagram';
        $add->snapchat = 'snapchat';
        $add->website_type = 'sell';
        $add->tax = 15;

        $add->save();


        for ($i=1; $i < 2; $i++) { 
            $add = new Category;
            $add->title = 'القسم '. $i;
            $add->parent = '0';
            $add->meta_keywords = 'meta_keywords';
            $add->meta_description = 'meta_description';
            $add->save();
        }

        $add = new Unit;
        $add->title = 'وحده';
        $add->num = 1;
        $add->save();

        $add = new Branch();
        $add->name = 'الفرع الرئيسي';
        $add->phone = "0511111111";
        $add->save();

        $add = new Attribute;
        $add->title = 'الحجم';
        $add->save();

        $add = new Attribute;
        $add->title = 'اللون';
        $add->save();

        $add = Client::create([
            'name' => 'عميل افتراضي',
            'city' => "المدينه",
            'address' => "العنوان",
            'email' => "info@gmail.com",
            'phone' => "1",
            'password' => Hash::make(123456),
            'is_active' => 1,
        ]);

        $add = new Supplier;
        $add->title = 'مورد افتراضي';
        $add->address = "العنوان";
        $add->phone = "2";
        $add->sales_name = "اسم المسؤول";
        $add->phone2 = "2";
        $add->email = "info@gmail.com";
        $add->num = 321654987;
        $add->tax_number = 123456789123456;
        $add->is_active = 1;
        $add->save();



    }
}
