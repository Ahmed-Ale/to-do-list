<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;

class ToDosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()) {
            return ApiResponse::response(401, 'Unauthorized', []);
        }
        $to_dos = auth()->user()->todos()->latest()->paginate(10);

        return ApiResponse::response(200, 'To-Dos Retrived Succesfully', $to_dos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string']
        ]);

        $todo = auth()->user()->todos()->create($validatedData);

        return ApiResponse::response(201, 'Todo Created Successfully', $todo);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
