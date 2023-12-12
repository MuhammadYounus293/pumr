<?php

namespace App\Http\Controllers\Customer\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerDashboardController extends Controller
{

    public function CustomerDashboard()
    {

        return view('customer.dashboard');
    }
}
