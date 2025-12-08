<?php

namespace App\Http\Controllers\Admin\GeneralSetting;

use App\Http\Controllers\Controller;
use App\Models\Settings\LetterHead;
use App\Models\User;
use Illuminate\Http\Request;

class LetterHeadController extends Controller
{
    public function index()
    {
        return view('admin.global.letter_head.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'header' => ['required'],
            'header_en' => ['required'],
            'letter_head' => ['required'],
        ]);

        LetterHead::updateOrCreate(
            ['model_type' => User::class,'model_id' => auth()->id()],
            [
                'header' => $request->input('header'),
                'header_en' => $request->input('header_en'),
                'letter_head' => $request->input('letter_head')
            ]
        );

        toast('लेटर हेड सफलतापूर्वक पेश गरियो', 'success');
        return back();
    }

    public function show(LetterHead $letterHead)
    {
        //
    }
}
