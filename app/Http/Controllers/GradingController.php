<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Grading;
use Validator;

class GradingController extends Controller
{
    public function index() {
        $gradings = Grading::all();
        return view('admin.gradings', compact('gradings'));
    }

    public function store(Request $request) {

        $validator = $this->validateGradings($request->gradings);

        if ($validator->validate()) {
            foreach ($request->gradings as $attributes) {
                $grading = new Grading($attributes);
                $grading->save();
            }

            return Grading::all();
        }

        return response()->json(['error' => 'error'], 401);
    }

    public function update(Request $request) {

        $validator = $this->validateGradings($request->gradings);

        if ($validator->validate()) {
            foreach ($request->gradings as $attributes) {
                $grading = Grading::find($attributes['id']);
                $grading->update($attributes);
            }

            return Grading::all();
        }

        return response()->json(['error' => 'error'], 401);
    }

    public function destroy(Grading $grading) {

        if ($grading->delete()) {
            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'error'], 401);
    }


    protected function validateGradings($gradings) {

        $messages = [
            '*.abbreviation.required' => 'Abbreviation is required.',
            '*.abbreviation.max' => 'Max abbreviation size is 20 characters.',
            '*.grading.required' => 'Grading is required.',
            '*.grading.max' => 'Max grading size is 100 characters.',
            '*.description.required' => 'Description is required.',
        ];

        return Validator::make($gradings, [
            '*.abbreviation' => 'required|max:20',
            '*.grading' => 'required|max:100',
            '*.description' => 'required',
        ], $messages);
    }
}
