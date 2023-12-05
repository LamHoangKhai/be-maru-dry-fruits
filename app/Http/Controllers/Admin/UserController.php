<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // render view user table

        return view("admin.modules.user.index");
    }

    /**
     * Get , search , filter form Ajax
     */
    public function getUsers(Request $request)
    {
        // query filter, search 

        $query = User::where("status", "!=", 3); // just get user when status 1,2
        $search = $request->search ? $request->search : "";
        $take = (int) $request->take;

        // search email, phone ,name 
        $query = $query->where(function ($query) use ($search) {
            $query->where("full_name", "like", "%" . $search . "%")
                ->orWhere("email", "like", "%" . $search . "%")
                ->orWhere("phone", "like", "%" . $search . "%");
        });

        //return data
        $result = $query->orderBy("created_at", "desc")->paginate($take);
        return response()->json(['status_code' => 200, 'msg' => "Kết nối thành công nha bạn.", "data" => $result]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        //create user
        $data = new User();
        $data->full_name = $request->full_name;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->level = $request->level;
        $data->status = $request->status;
        $data->address = $request->address;
        $data->phone = $request->phone;
        $data->save();
        return redirect()->route("admin.user.index")->with("success", "Create user successful");

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // find user
        $user = User::findOrfail($id);

        // check user has edit itself
        // $mySelf = false;
        // if (Auth::user()->id == $user->id) {
        //     $mySelf = true;
        // }

        // // check permission
        // $permission = false;

        // // if user is Superadmin allows delete all level
        // if (Auth::user()->id == "maruDr-yfRui-tspRo-jectfORFOU-Rmembe") {
        //     $permission = true;
        // }

        // if admin edit itself allows editing
        // if ($mySelf) {
        //     $permission = true;
        // }

        // // return if permission = true
        // if ($permission) {
            // }
                return view("admin.modules.user.edit", ["data" => $user, 'id' => $id]);

        // return if permission =  false
        return redirect()->route("admin.user.index")->with("error", "Not allow edit!");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        // find user
        $user = User::findOrfail($id);

        // update password if has password
        if (!empty($request->password)) {
            $request->validate([
                "password" => "min:8",
                "confirm_password" => "required|same:password",
            ]);
            $user->password = bcrypt($request->password);
        }

        // update data
        $user->full_name = $request->full_name;
        $user->phone = $request->phone;
        $user->status = $request->status;
        $user->level = $request->level ? $request->level : 1; // if level null default 1
        $user->address = $request->address;
        $user->phone = $request->phone;

        $user->save();
        return redirect()->route('admin.user.index')->with('success', 'Edit success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //find user
        $user = User::findOrfail($id);

        // check permission
        $permission = false;

        // if user is Superadmin allows delete all level
        if (Auth::user()->id == "maruDr-yfRui-tspRo-jectfORFOU-Rmembe" && $user->id != "maruDr-yfRui-tspRo-jectfORFOU-Rmembe") {
            $permission = true;
        }

        // if admin just permission delete  member
        if ($user->level != 1) {
            $permission = true;
        }

        // return if permission = true
        if ($permission) {
            $user->status = 3; // change status to 3
            $user->save();
            return redirect()->route('admin.user.index')->with('success', 'Delete success');
        }

        // return if permission = false
        return redirect()->route("admin.user.index")->with("error", "Not allow delete!");
    }
}