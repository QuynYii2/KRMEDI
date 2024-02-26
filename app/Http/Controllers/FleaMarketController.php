<?php

namespace App\Http\Controllers;

use App\Enums\CategoryStatus;
use App\Enums\ReviewStoreStatus;
use App\Models\Category;
use App\Models\ProductInfo;
use App\Models\ReviewStore;
use App\Models\User;
use App\Models\WishList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FleaMarketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Category::where('status', CategoryStatus::ACTIVE)->get();
        $listWishList = WishList::where('isFavorite', 1);

        if (Auth::check()) {
            $listWishList->where('user_id', Auth::user()->id);
        }

        $listWishList = json_encode($listWishList->pluck('product_id')->toArray());

        return view('FleaMarket.flea-market', compact('listWishList', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function productDetail($id)
    {
        $product = ProductInfo::find($id);
        $userId = User::where('id', $product->created_by)->first();
        return view('FleaMarket.product_details', compact('id', 'userId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function wishList()
    {
        $categoryProduct = Category::where('status', CategoryStatus::ACTIVE)->get();
        return view('FleaMarket.wish-list', compact('categoryProduct'));
    }

    /**
     * Display the specified resource.
     */
    public function myStore()
    {
        $id = Auth::user()->id;
        $reviewStore = ReviewStore::where('store_id', $id)->where('status', ReviewStoreStatus::APPROVED)->get();
        $user = User::find($id);
        return view('FleaMarket.my-store', compact('reviewStore', 'id', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function review()
    {
        return view('FleaMarket.review');
    }

    public function ShopInfo($id)
    {
        $user = User::find($id);
        $reviewStore = ReviewStore::where('store_id', $id)->where('status', ReviewStoreStatus::APPROVED)->get();
        return view('FleaMarket.shop-infor', compact('id', 'reviewStore', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function sellProduct()
    {
        $user = Auth::user();
        $province = DB::table('provinces')->get();
        $category = Category::where('status', CategoryStatus::ACTIVE)->get();
        return view('FleaMarket.sell-my-product', compact('user', 'province', 'category'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function editProduct($id)
    {
        $e_product = ProductInfo::find($id);
        $provinces = DB::table('provinces')->get();
        $departments = Category::where('status', CategoryStatus::ACTIVE)->get();
        return view('FleaMarket.edit-product', compact('e_product', 'provinces', 'departments'));
    }
}
