<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TaskController extends Controller
{
    public function index()
    {
        return view('task');
    }

    public function getAllTasks()
    {
        return Task::latest()->orderBy('created_at', 'desc')->get();
    }

    public function getTask($id)
    {
        return Task::findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->input(['body']);
        return Task::create(['body' => $data]);
    }

    public function update(Request $request, $id)
    {
        $data = [];
        if ($request->has('body'))
        {
            $data['body'] = $request->input(['body']);
        }
        if ($request->has('checked'))
        {
            $data['checked'] = $request->input(['checked']);
        }
        Task::findOrFail($id)->update($data);
    }

    public function destroy($id)
    {
        return Task::destroy($id);
    }
}
