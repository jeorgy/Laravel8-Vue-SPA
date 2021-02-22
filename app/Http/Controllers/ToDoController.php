<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\ToDoRepository;
use App\Http\Requests\ToDos\CreateToDo;
use App\Http\Requests\ToDos\UpdateToDo;
use Illuminate\Support\Facades\Auth;
use App\Models\ToDos\ToDo;

class ToDoController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct(ToDoRepository $todos)
    {
        $this->middleware('permission:view_to_dos', ['only' => ['index']]);
        $this->middleware('permission:add_to_dos', ['only' => ['store']]);
        $this->middleware('permission:edit_to_dos', ['only' => ['update', 'completed']]);
        $this->middleware('permission:delete_to_dos', ['only' => ['destroy']]);

        $this->todos = $todos;    
    }

    public function index()
    {
        $to_dos = $this->todos->getAllToDos();

        return response()->json([
            'to_dos' => $to_dos
        ],200);
    }

    public function notCompleted()
    {
        $to_dos = $this->todos->getUserToDos(Auth::user()->id, false);

        return response()->json([
            'to_dos' => $to_dos
        ], 200);
    }

    public function store(CreateToDo $request)
    {
        $new_todo = $this->todos->store($request);

        return response()->json([
            'message' => 'Tarefa cadastrada com sucesso!'
        ],200);
    }

    public function update(UpdateToDo $request, ToDo $toDo)
    {
        $update_todo = $this->todos->update($request, $toDo);

        return response()->json([
            'message' => 'Tarefa atualizada com sucesso!'
        ],200);
    }

    public function destroy(ToDo $toDo)
    {
        $toDo->delete();

        return response()->json([
            'message' => 'Tarefa deletada com sucesso!'
        ],200);
    }

    public function completed(ToDo $toDo)
    {
        $this->todos->completed($toDo);

        return response()->json([
            'message' => 'Tarefa conluida!'
        ],200);
    }
}
