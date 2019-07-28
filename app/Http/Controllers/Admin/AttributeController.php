<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attribute;
use App\Models\AttributeGroup;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Validator;

class AttributeController extends Controller
{
    public function getList(Request $request)
    {
        $title = "属性列表";
        $query = Attribute::orderBy('id', 'asc');

        if ($request->group_id) {
            $query->where('attribute_group_id', $request->group_id);
        }

        $data = $query->paginate(20);

        return view('admin.attribute.list', [
            'pageTitle' => $title,
            'data'      => $data,
            'groups'    => AttributeGroup::get(),
            'gid'       => $request->group_id,
            'params'    => $request->all(),
        ]);
    }

    public function set(Request $request)
    {
        $title = "属性设置";

        if ($request->id) {
            $model = Attribute::find($request->id);
        }
        if (empty($model)) {
            $model = new Attribute;
        }

        if ($request->isMethod('post')) {
            $rules = [
                'name'               => 'required',
                'attribute_group_id' => 'required|integer|min:1',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $model->name               = $request->name;
            $model->attribute_group_id = $request->attribute_group_id;
            $model->save();
            return $this->success('设置成功');
        }

        return view('admin.attribute.set', [
            'pageTitle' => $title,
            'model'     => $model,
            'groups'    => AttributeGroup::get(),
        ]);
    }

    public function delete($id)
    {
        $model = Attribute::find($id);
        if (!$model) {
            return $this->error('该属性不存在');
        }

        try {
            $model->remove();
            return $this->success('删除成功');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function getGroups()
    {
        $title = "属性分组";
        $query = AttributeGroup::orderBy('id', 'asc');
        $data  = $query->paginate(20);

        return view('admin.attribute.groups', [
            'pageTitle' => $title,
            'data'      => $data,
        ]);
    }

    public function setGroup(Request $request)
    {
        $title = "属性分组设置";

        if ($request->id) {
            $model = AttributeGroup::find($request->id);
        }
        if (empty($model)) {
            $model = new AttributeGroup;
        }

        if ($request->isMethod('post')) {
            $rules = [
                'name' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $model->name = $request->name;
            $model->save();
            return $this->success('设置成功');
        }

        return view('admin.attribute.set_group', [
            'pageTitle' => $title,
            'model'     => $model,
        ]);
    }

    public function deleteGroup($id)
    {
        $model = AttributeGroup::find($id);
        if (!$model) {
            return $this->error('该属性分组不存在');
        }

        try {
            $model->remove();
            return $this->success('删除成功');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
