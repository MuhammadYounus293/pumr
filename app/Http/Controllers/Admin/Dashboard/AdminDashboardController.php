<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    //

    public function AdminDashboard()
    {

        
        return view('admin.dashboard');
    }

    public function ReadNotification($id){
        
        if(Auth::user()){
        $isread =auth()->user()->unreadNotifications->where('id',$id)->markAsRead();

        return redirect()->route('admin.dashboard');
        
            
        }else{
            return back();
        }
    
}
}
