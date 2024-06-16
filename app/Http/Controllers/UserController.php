<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Centre_Point;
use App\Models\Spot;
use App\Models\UMKM_Data;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = $row->admin ? 
                        '<button class="btn btn-danger btn-sm toggle-admin" data-id="'.$row->id.'">Cabut Admin</button> Admin' :
                        '<button class="btn btn-primary btn-sm toggle-admin" data-id="'.$row->id.'">Jadi Admin</button> User';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return view('users.index');
    }

    public function toggleAdmin(User $user)
    {
        $user->admin = !$user->admin;
        $user->save();

        return response()->json(['success' => 'Status admin berhasil diubah']);
    }
}
