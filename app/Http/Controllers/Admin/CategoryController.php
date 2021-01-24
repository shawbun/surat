<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', '=', 'DESC')->get();

        return view('admin.category', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string','unique:categories'],
        ]);
        $attributes = ([
            'name' => $request->name,
        ]);

        Category::create($attributes);

        return redirect()->back()->with('success', 'Delete data successfully !');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.categoryedit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name' => ['required', 'string','unique:categories'],
        ]);

        $attributes = ([
            'name' => $request->name,
        ]);

        if ($request->password) {
            $attributes = array_add($attributes, 'password', Hash::make($request->password));
        }

        $category->update($attributes);

        return redirect()->back()->with('success', 'Data Update Successfully');

    }

    public function destroy(Request $request, Category $category)
    {
        $user->delete();

        return redirect()->back()->with('success', 'Delete data successfully !');
    }
}
