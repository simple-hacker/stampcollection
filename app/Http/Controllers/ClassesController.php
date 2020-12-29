<?php

namespace App\Http\Controllers;

use App\Jobs\UpdateStampClassValues;
use App\StampClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassesController extends Controller
{
    public function index() {
        $classes = StampClass::all();
        return view('admin.classes', compact('classes'));
    }

    public function store(Request $request) {

        $validator = $this->validateClasses($request->classes);

        if ($validator->validate()) {
            foreach ($request->classes as $attributes) {
                $class = new StampClass($attributes);
                $class->save();
            }

            return StampClass::all();
        }

        return response()->json(['error' => 'error'], 401);
    }

    public function update(Request $request) {

        $validator = $this->validateClasses($request->classes);

        if ($validator->validate()) {
            foreach ($request->classes as $attributes) {
                $grading = StampClass::find($attributes['id']);
                $grading->update($attributes);
            }

            UpdateStampClassValues::dispatch();

            return StampClass::all();
        }

        return response()->json(['error' => 'error'], 401);
    }

    protected function validateClasses($classes) {

        $messages = [
            '*.class.required' => 'Class is required.',
            '*.class.max' => 'Max class length is 256 characters.',
            // '*.class.unique' => 'This class name has already been taken.',
            '*.value.required' => 'Value is required.',
            '*.value.min' => 'Min value is 0.',
        ];

        return Validator::make($classes, [
            '*.class' => 'required|string|max:256',
            '*.value' => 'required|numeric|min:0',
        ], $messages);
    }
}
