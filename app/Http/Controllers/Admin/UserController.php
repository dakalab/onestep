<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Validator;

class UserController extends Controller
{
    public function getList(Request $request)
    {
        $title = "用户列表";
        $query = User::orderBy('id', 'desc');

        $keyword = $request->keyword;
        if (!empty($keyword)) {
            $query->where('id', '=', $keyword)
                ->orWhere('name', 'like', '%' . $keyword . '%')
                ->orWhere('email', 'like', '%' . $keyword . '%');
        }

        $data = $query->paginate(20);

        return view('admin.user.list', [
            'pageTitle' => $title,
            'data'      => $data,
            'keyword'   => $keyword,
        ]);
    }

    public function profile(Request $request)
    {
        $title = "用户资料";

        if ($request->uid) {
            $user = User::find($request->uid);
        }
        if (empty($user)) {
            $user = Auth::user();
        }

        if ($request->isMethod('post')) {
            $data['name']  = $request->input('name');
            $rules['name'] = 'required|max:255|min:2';
            $user->name    = $data['name'];

            if (!empty($request->input('password'))) {
                $data['password']              = $request->input('password');
                $data['password_confirmation'] = $request->input('password_confirmation');
                $rules['password']             = 'required|confirmed|min:6';
                $user->password                = bcrypt($data['password']);
            }

            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                if ($request->expectsJson()) {
                    throw new ValidationException($validator);
                }
                return redirect('/admin/fail')->withErrors($validator);
            }

            $user->is_admin = (int) $request->input('is_admin');

            $user->save();

            if ($request->expectsJson()) {
                return $this->success('设置成功');
            }

            return redirect('/admin/ok');
        }

        return view('admin.user.profile', [
            'pageTitle' => $title,
            'user'      => $user,
        ]);
    }

    public function delete($id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->error('该用户不存在');
        }

        if ($user->isAdmin()) {
            return $this->error('不能删除管理员，请先去掉管理员身份');
        }

        try {
            $user->delete();
            return $this->success('删除成功');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
