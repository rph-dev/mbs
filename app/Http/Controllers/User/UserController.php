<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\Department;
use App\Models\User\Position;
use App\Models\User\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @param $departmentId
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($departmentId = null)
    {
        $users = (new User)->getUsersDepartment($departmentId)->paginate(50);

        $departments = Department::pluck('name', 'id');

        return view('users.user_index', compact('users', 'departments'));
    }

    public function create(){

        $departments = Department::pluck('name', 'id');

        $positions = Position::pluck('name', 'id');

        return view('users.user_create', compact('departments', 'positions'));
    }

    public function store(Request $request){
        dd($request->post());
    }


    public function edit(){
    }

    public function update(){

    }

    public function destroy(){

    }

}
