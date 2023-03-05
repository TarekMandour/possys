<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LandController extends Controller
{
    public function land()
    {
        $branchs = Branch::all();
        return view('front.land', compact('branchs'));
    }

    public function SelectBranch(Request $request)
    {
        $this->validate($request, [
            'branch_id' => 'required|exists:branches,id',
        ]);

        Session::put('branch_id', $request->branch_id);
        return redirect(url('home'));
    }
}
