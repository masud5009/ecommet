<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Helpers\UserPermissionHelper;
use App\Models\User\Language;
use App\Models\User\UserCurrency;
use App\Models\User\UserItemContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->where('user_id', Auth::guard('web')->user()->id)->first();
        $lang_id = $lang->id;
        $current_package = UserPermissionHelper::currentPackagePermission(Auth::guard('web')->user()->id);
        $data['item_limit'] = $current_package->product_limit;
        $data['total_item'] = UserItemContent::where('language_id', $lang->id)->where('user_id', Auth::guard('web')->user()->id)->count();
        $title = null;
        if ($request->filled('title')) {
            $title = $request->title;
        }

        $data['products'] = DB::table('user_items')->where('user_items.user_id', Auth::guard('web')->user()->id)
            ->Join('user_item_contents', 'user_items.id', '=', 'user_item_contents.item_id')
            ->join('user_item_categories', 'user_item_contents.category_id', '=', 'user_item_categories.id')
            ->select('user_items.*', 'user_items.id AS item_id', 'user_item_contents.*', 'user_item_categories.name AS category')
            ->orderBy('user_items.id', 'DESC')
            ->where('user_item_contents.language_id', '=', $lang_id)
            ->where('user_item_categories.language_id', '=', $lang_id)
            ->when($title, function ($query) use ($title) {
                return $query->where('user_item_contents.title', 'LIKE', '%' . $title . '%');
            })
            ->paginate(10);
        $data['lang_id'] = $lang_id;
        $data['currency'] = UserCurrency::where('user_id', Auth::guard('web')->user()->id)->where('is_default', 1)->first();

        return view('user.pos.index', $data);
    }
}
