<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\Address\ProvinceResource;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\LocalBodyResource;
use App\Models\Address\District;
use App\Models\Address\LocalBody;
use App\Models\Address\Province;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function provinces()
    {
        return ProvinceResource::collection(Province::all());
    }

    public function province(Province $province)
    {
        return ProvinceResource::make($province->load('districts'));
    }

    public function district(Request $request)
    {
        $request->validate(['province_id' => 'required']);

        $districts = District::where('province_id', $request->input('province_id'))->get();

        return DistrictResource::collection($districts);
    }
    public function localBodies(Request $request)
    {
        $request->validate(['district_id' => 'required']);

        $localBody = LocalBody::where('district_id', $request->input('district_id'))->get();

        return LocalBodyResource::collection($localBody);
    }
    public function wardNo(Request $request)
    {
        $request->validate(['local_body_id' => 'required']);

        return LocalBody::findOrFail($request->input('local_body_id'))->ward_no;
    }
}
