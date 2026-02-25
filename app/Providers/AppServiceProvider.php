<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\Brand;
use App\Models\Collection;
use App\Models\CollectionItem;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Models\Contact;
use App\Models\CreatePage;
use App\Models\EcomPixel;
use App\Models\GeneralSetting;
use App\Models\GoogleTagManager;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\PaymentGateway;
use App\Models\SocialMedia;
use Config;
use Illuminate\Support\ServiceProvider;

// app/Providers/AppServiceProvider.php

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {

            // get active collections
            $collections = Collection::where('status',1)->get();

            $collection_items = [];
            foreach($collections as $collection) {
                $items = CollectionItem::where('collection_id',$collection->id)->get();

                foreach($items as $item) {
                    if($item->item_type == 'category') {
                        $item->item_name = Category::where('id', $item->item_id)->value('name');
                        $item->item_slug = Category::where('id', $item->item_id)->value('slug');
                    } elseif($item->item_type == 'subcategory') {
                        $item->item_name = SubCategory::where('id', $item->item_id)->value('subcategoryName');
                        $item->item_slug = SubCategory::where('id', $item->item_id)->value('slug');
                    } elseif($item->item_type == 'childcategory') {
                        $item->item_name = ChildCategory::where('id', $item->item_id)->value('childcategoryName');
                        $item->item_slug = ChildCategory::where('id', $item->item_id)->value('slug');
                    }
                }

                $collection_items[$collection->id] = $items;
            }

            $view->with([
                'collections' => $collections,
                'collection_items' => $collection_items
            ]);
        }); 

        $shurjopay = PaymentGateway::where(['status' => 1, 'type' => 'shurjopay'])->first();
        if ($shurjopay) {

            Config::set(['shurjopay.apiCredentials.username' => $shurjopay->username]);
            Config::set(['shurjopay.apiCredentials.password' => $shurjopay->password]);
            Config::set(['shurjopay.apiCredentials.prefix' => $shurjopay->prefix]);
            Config::set(['shurjopay.apiCredentials.return_url' => $shurjopay->success_url]);
            Config::set(['shurjopay.apiCredentials.cancel_url' => $shurjopay->return_url]);
            Config::set(['shurjopay.apiCredentials.base_url' => $shurjopay->base_url]);
        }
        $generalsetting = GeneralSetting::where('status', 1)->limit(1)->first();
        view()->share('generalsetting', $generalsetting);

        
        $sidecategories = Category::where('parent_id', '=', '0')->where('status', 1)->select('id', 'name', 'slug', 'status', 'image')->get();
        view()->share('sidecategories', $sidecategories);

        $menucategories = Category::where('status', 1)->select('id', 'name', 'slug', 'badge','status', 'image')->get();
        view()->share('menucategories', $menucategories);

        $contact = Contact::where('status', 1)->first();
        view()->share('contact', $contact);

        $socialicons = SocialMedia::where('status', 1)->get();
        view()->share('socialicons', $socialicons);

        $pages = CreatePage::where('status', 1)->limit(3)->get();
        view()->share('pages', $pages);

        $pagesright = CreatePage::where('status', 1)->skip(1)->limit(5)->get();
        view()->share('pagesright', $pagesright);

        $cmnmenu = CreatePage::where('status', 1)->get();
        view()->share('cmnmenu', $cmnmenu);

        $brands = Brand::where('status', 1)->get();
        view()->share('brands', $brands);

        $neworder = Order::where('order_status', '1')->count();
        view()->share('neworder', $neworder);

        $pendingorder = Order::where('order_status', '1')->latest()->limit(9)->get();
        view()->share('pendingorder', $pendingorder);

        $orderstatus = OrderStatus::get();
        view()->share('orderstatus', $orderstatus);

        $pixels = EcomPixel::where('status', 1)->get();
        view()->share('pixels', $pixels);

        $gtm_code = GoogleTagManager::where('status', 1)->get();
        view()->share('gtm_code', $gtm_code);
    }
}
