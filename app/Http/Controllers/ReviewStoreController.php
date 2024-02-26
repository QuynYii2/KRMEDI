<?php

namespace App\Http\Controllers;

use App\Enums\ReviewStoreStatus;
use App\Models\ReviewStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewStoreController extends Controller
{
    public function ReviewStore()
    {
        $reviewStore = ReviewStore::where('status', ReviewStoreStatus::APPROVED)->get();
        return view('component.review-item', compact('reviewStore'));
    }

    public function createReviewStore()
    {
        return view('FleaMarket.tab-create-review-store');
    }
    public function createReview(Request $request, $id)
    {
        $cmt_review = $request->input('cmt_review');

        $translate = new TranslateController();
        $name_en = $translate->translateText($request->input('cmt_review'), 'en');
//        $name_laos = $translate->translateText($request->input('cmt_review'), 'lo');

        $star_number = $request->input('star_number');
        $cmt_store = new ReviewStore();
        $cmt_store->star_number = $star_number;
        $cmt_store->content = $cmt_review;
        $cmt_store->content_en = $name_en;
//        $cmt_store->content_laos = $name_laos;
        $cmt_store->store_id = $id;
        $cmt_store->status = ReviewStoreStatus::APPROVED;
        if (!Auth::user()==null) {
            $cmt_store->user_id = auth()->user()->id;
            $cmt_store->save();
            alert()->success('Đánh giá thành công');
            return redirect()->route('flea.market.product.shop.info', $id);
        }else{
           alert()->error('Bạn cần đăng nhập để đánh giá');
            return redirect()->route('flea.market.product.shop.info', $id);
        }
    }
}
