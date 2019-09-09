<?php

namespace App\Http\Controllers\Mbs;

use App\Http\Controllers\Controller;
use App\Models\Mbs\MbsGroup;
use App\Models\Mbs\MbsMessageList;
use App\Models\Mbs\MbsUserCustom;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomUserController extends Controller
{
    /**
     * Display a listing of the CustomUserController.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $model = MbsUserCustom::paginate(50);

        return view('mbs.custom_user.index', compact('model'));
    }

    /**
     * Show the form for creating a new Division.
     *
     * @return Response
     */
    public function create()
    {
        $model = new MbsUserCustom();

        return view('mbs.custom_user.create', compact('model'));
    }

    /**
     * Store a newly created Division in storage.
     *
     * @param Request $request
     *
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name'=>'required|max:255',
            'password_rand' => 'required|min:6|max:6|unique:mbs_users_custom'
        ]);

        $input = $request->all();

        $model = MbsUserCustom::create($input);

        return redirect(route('mbs.user-custom.index'))
            ->with('success', 'Created Division: Success!');
    }

    /**
     * Display the specified Division.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        return redirect(route('mbs.user-custom.edit', compact('id')));
    }

    /**
     * Show the form for editing the specified Division.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {

        $model = MbsUserCustom::findOrFail($id);

        return view('mbs.custom_user.edit', compact('model'));
    }

    /**
     * Update the specified Division in storage.
     *
     * @param int $id
     * @param Request $request
     *
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($id, Request $request)
    {

        $this->validate($request, [
            'name'=>'required|max:255'
        ]);

        $model = MbsUserCustom::findOrFail($id);

        $input = $request->only('name');

        $model->fill($input);

        $model->save();

        return redirect(route('mbs.user-custom.edit', compact('id')))
            ->with('success', 'Updated Division: Success!');
    }

    /**
     * Remove the specified Division from storage.
     *
     * @param int $id
     *
     * @return array|Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $model = MbsUserCustom::findOrFail($id);

        $model->delete();

        $contactId = "c{$id}";

        $groupIdList = MbsGroup::where('contact_id', $contactId)->where('total', 1)->pluck('group_id')->toArray();
        if(count($groupIdList)){
            MbsMessageList::whereIn('group_id', $groupIdList)->delete();
        }

        $groupIdList = MbsGroup::where('contact_id', $contactId)->pluck('group_id')->toArray();
        MbsGroup::whereIn('group_id', $groupIdList)->decrement('total', 1);
        MbsGroup::where('contact_id', $contactId)->delete();

        return [
            'success' => true,
            'data'    => $id,
            'message' => 'User Group deleted successfully'
        ];
    }
}
