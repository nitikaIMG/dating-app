<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutUs;
use App\Models\PrivacyTerms;
use DB;
use Illuminate\Support\Facades\Validator;
use App\Api\ApiResponse;


class AboutUsPageController extends Controller
{
    public function index(Request $request)
    {
        try {
            DB::beginTransaction();
            $about =  AboutUs::where('status', 1)->first();
            if ($about) {
                return ApiResponse::ok(
                    'About us Page',
                    $about
                );
            } else {
                return ApiResponse::error('No Page Are Mentioned Here !!');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
    }


    public function privacypage(Request $request)
    {
        try {
            DB::beginTransaction();
            $privacy =  PrivacyTerms::where('status', 1)->first();
            if ($privacy) {
                return ApiResponse::ok(
                    'Privacy  Page',
                    $privacy
                );
            } else {
                return ApiResponse::error('No Page Are Mentioned Here !!');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
    }
}
