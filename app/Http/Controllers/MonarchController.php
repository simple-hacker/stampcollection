<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Monarch;
use Validator;

class MonarchController extends Controller
{
    public function index() {
        $monarchs = Monarch::all()->keyBy('id');
        return view('admin.monarchs', compact('monarchs'));
    }

    public function store(Request $request) {

        $validator = $this->validateMonarchs($request->monarchs);

        if ($validator->validate()) {
            foreach ($request->monarchs as $attributes) {
                $monarch = new Monarch($attributes);
                $monarch->save();
            }

            return Monarch::all()->keyBy('id');
        }

        return response()->json(['error' => 'error'], 401);
    }

    public function update(Request $request) {

        $validator = $this->validateMonarchs($request->monarchs);

        if ($validator->validate()) {
            foreach ($request->monarchs as $attributes) {
                $monarch = Monarch::find($attributes['id']);
                $monarch->update($attributes);
            }

            return Monarch::all()->keyBy('id');
        }

        return response()->json(['error' => 'error'], 401);
    }

    public function destroy(Monarch $monarch) {

        if ($monarch->delete()) {
            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'error'], 401);
    }


    protected function validateMonarchs($monarchs) {

        $messages = [
            '*.abbreviation.required' => 'Abbreviation is required.',
            '*.abbreviation.max' => 'Max abbreviation size is 20 characters.',
            '*.monarch.required' => 'Monarch is required.',
            '*.monarch.max' => 'Max Monarch size is 100 characters.',
        ];

        return Validator::make($monarchs, [
            '*.abbreviation' => 'required|max:20',
            '*.monarch' => 'required|max:100',
        ], $messages);
    }
}
