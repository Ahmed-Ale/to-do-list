<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\ToDo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToDosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $to_dos = ToDo::where('user_id', auth()->user()->id)
            ->latest()
            ->paginate(10);
        return ApiResponse::response(200, 'To-Dos Retrived Succesfully', $to_dos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string']
        ]);
        $todo = auth()->user()->todos()->create($data);
        return ApiResponse::response(201, 'Todo Created Successfully', $todo);
    }

    /**
     * Display the specified resource.
     */
    public function single($id)
    {
        $todo = ToDo::findOrFail($id);
        if ($todo->user_id != Auth::user()->id) {
            return response()->json(['error' => "You don't have access to this todo."], 403);
        }
        return ApiResponse::response(200, 'Single Todo Retrieved Successfully', $todo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $todo = ToDo::findOrFail($id);
        if ($todo->user_id != Auth::user()->id) {
            return response()->json(['error' => "You don't have access to this todo."], 403);
        }
        $data = $request->validate([
            'title' => ['string'],
            'description' => ['string'],
        ]);
        $todo->update($data);
        return ApiResponse::response(200, 'Todo Updated Successfully', $todo);
    }

    public function completed(Request $request, $id)
    {
        $todo = ToDo::findOrFail($id);
        if (!$request->has('completed')) {
            return ApiResponse::response(400, 'Missing parameter: completed');
        }
        if ($request->completed == true || $request->completed === 'true') {
            $todo->completed = 1;
        } elseif ($request->completed == false || $request->completed === 'false') {
            $todo->completed = 0;
        } else {
            return ApiResponse::response(400, 'Invalid value for parameter: completed');
        }
        return ApiResponse::response(200, 'Marked Todo as Completed/Incomplete Successfully', [
            'todo' => $todo,
            'message' => $todo->completed ? 'Marked as Complete' : 'Marked as Incomplete'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $todo = ToDo::findOrFail($id);
        if ($todo->user_id !== Auth::user()->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $todo->delete();
        return ApiResponse::response(200, 'Todo Deleted Successfully', []);
    }
}
