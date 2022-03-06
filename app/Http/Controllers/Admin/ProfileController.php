<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function add()
    {//課題３
        return view('admin.profile.create');
    }

    public function create()
    {
        return redirect('admin/profile/create');
    }

    public function edit()
    {//課題３
        return view('admin.profile.edit');
    }

    public function update()
    {
        return redirect('admin/profile/edit');
    }
}