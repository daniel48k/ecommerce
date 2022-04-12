<?php

namespace App\Http\Controllers\Admin;

use App\Constants\RoleConstants;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    /** @var UserRepository */
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->allQuery(['role' => RoleConstants::CLIENT])->paginate(10);
        return view('backend.users.index')->with('users', $users);
    }

    public function edit($id)
    {
        $user = $this->userRepository->find($id);
        return view('backend.users.edit')->with('user', $user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->validate($request,
            [
                'name' => 'string|required|max:30',
                'email' => 'string|required',
            ]);
        $data = $request->all();

        $status = $user->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Successfully updated');
        } else {
            request()->session()->flash('error', 'Error occurred while updating');
        }
        return redirect()->route('users.index');

    }

    public function destroy($id)
    {
        $delete = User::findorFail($id);

        $status = $delete->delete();
        if ($status) {
            request()->session()->flash('success', 'User Successfully deleted');
        } else {
            request()->session()->flash('error', 'There is an error while deleting users');
        }
        return redirect()->route('users.index');
    }
}
