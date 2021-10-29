<?php

namespace App\Http\Controllers;

use App\Models\Payslip;
use Illuminate\Http\Request;

class PayslipController extends Controller
{
    public function store()
    {
        dd('store');
    }

    public function show(Request $request) {
        $payslip = Payslip::findOrFail($request['id']);
        return view('payslips.show', [
            'payslip' => $payslip,
        ]);
    }
}
