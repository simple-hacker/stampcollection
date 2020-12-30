<?php

namespace App\Http\Controllers;

use App\Jobs\UpdateDenominationValues;
use App\Denomination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DenominationController extends Controller
{
    public function index() {
        $denominations = Denomination::all();
        return view('admin.denominations', compact('denominations'));
    }

    public function store(Request $request) {

        $validator = $this->validateDenominations($request->denominations);

        if ($validator->validate()) {
            foreach ($request->denominations as $attributes) {
                $class = new Denomination($attributes);
                $class->save();
            }

            return Denomination::all();
        }

        return response()->json(['error' => 'error'], 401);
    }

    public function update(Request $request) {

        $validator = $this->validateDenominations($request->denominations);

        if ($validator->validate()) {
            foreach ($request->denominations as $attributes) {
                $denomination = Denomination::find($attributes['id']);
                $denomination->update($attributes);
            }

            UpdateDenominationValues::dispatch();

            return Denomination::all();
        }

        return response()->json(['error' => 'error'], 401);
    }

    protected function validateDenominations($denominations) {

        $messages = [
            '*.denomination.required' => 'Denomination is required.',
            '*.denomination.max' => 'Max denomination length is 256 characters.',
            // '*.denomination.unique' => 'This class name has already been taken.',
            '*.value.required' => 'Value is required.',
            '*.value.min' => 'Min value is 0.',
        ];

        return Validator::make($denominations, [
            '*.denomination' => 'required|string|max:256',
            '*.value' => 'required|numeric|min:0',
        ], $messages);
    }
}
