<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function success()
    {
        return view('Ecommerce.payment.success');
    }

    public function failure()
    {
        return view('Ecommerce.payment.failure');
    }
}