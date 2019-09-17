<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Mbs\MbsUserMapping;
use App\Models\User\Department;
use App\Models\User\Position;
use App\Models\User\User;
use Hash;
use Illuminate\Http\Request;

/**
 * Class UserController
 * @package App\Http\Controllers\User
 */
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
        $users = (new User)->getUsersDepartment($departmentId)->latest()->paginate(50);

        $departments = Department::pluck('name', 'id');

        return view('users.user_index', compact('users', 'departments'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function show($id){
        return redirect(route('company.member.edit', ['id' => $id]));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

        $departments = Department::pluck('name', 'id');

        $positions = Position::pluck('name', 'id');

        return view('users.user_create', compact('departments', 'positions'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:150',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'position_id' => 'required',
            'department_id' => 'required',
            'line_code' => 'required|unique:users,line_code',
            'birth_date' => 'required'
        ]);

        $input = $request->all();

        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);

        return redirect(route('company.member.edit', ['id' => $user->id]))->with('success', "Created: user successful!");
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        $departments = Department::pluck('name', 'id');

        $positions = Position::pluck('name', 'id');

        return view('users.user_edit', compact('departments', 'positions', 'user'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:150',
            'email' => 'required|email|unique:users,email,'.$id,
            'position_id' => 'required',
            'department_id' => 'required'
        ]);

        if ($request->has('unlink_line')){
            if(!$request->post('unlink_line')) MbsUserMapping::where('user_id', $id)->update(['user_id' => null]);
        } else {

            $this->validate($request, [
                'birth_date' => 'required',
                'line_code' => 'required|unique:users,line_code,'.$id,
            ]);
        }

        $input = $request->only(['name', 'email', 'password', 'position_id', 'department_id', 'line_code', 'birth_date', 'activated']);

        $user = User::findOrFail($id)->update($input);

        return redirect(route('company.member.edit', ['id' => $id]))->with('success', "Updated: user successful!");
    }

    /**
     *
     */
    public function destroy()
    {

    }

}
