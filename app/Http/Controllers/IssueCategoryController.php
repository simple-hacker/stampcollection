<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IssueCategory;
use Validator;

class IssueCategoryController extends Controller
{
    public function index() {
        $categories = IssueCategory::all()->keyBy('id');
        return view('admin.categories', compact('categories'));
    }

    public function store(Request $request) {

        $validator = $this->validateCategories($request->categories);

        if ($validator->validate()) {
            foreach ($request->categories as $attributes) {
                $category = new IssueCategory($attributes);
                $category->save();
            }

            return IssueCategory::all()->keyBy('id');
        }

        return response()->json(['error' => 'error'], 401);
    }

    public function update(Request $request) {

        $validator = $this->validateCategories($request->categories);

        if ($validator->validate()) {
            foreach ($request->categories as $attributes) {
                $category = IssueCategory::find($attributes['id']);
                $category->update($attributes);
            }

            return IssueCategory::all()->keyBy('id');
        }

        return response()->json(['error' => 'error'], 401);
    }

    public function destroy(IssueCategory $category) {

        if ($category->delete()) {
            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'error'], 401);
    }


    protected function validatecategories($categories) {

        $messages = [
            '*.category.required' => 'Category is required.',
            '*.category.max' => 'Max category size is 100 characters.',
        ];

        return Validator::make($categories, [
            '*.category' => 'required|max:100',
        ], $messages);
    }
}
