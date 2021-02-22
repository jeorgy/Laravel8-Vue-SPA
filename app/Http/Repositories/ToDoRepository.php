<?php

namespace App\Http\Repositories;

use App\Models\ToDos\ToDo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ToDoRepository
{
    /**
     * Class constructor.
     */
    public function __construct(ToDo $todos)
    {
        $this->todos = $todos;
    }

    public function getAllToDos()
    {
        $query = $this->todos->with('user')
                    ->orderBy('created_at', 'desc');

        if (!Auth::user()->hasRole('root')) {
            $query->whereUserId(Auth::user()->id);
        }

        return $query->get();
    }

    public function getUserToDos($user_id, $completed)
    {
        $query = $this->todos->with('user')
                    ->whereUserId($user_id)
                    ->orderBy('created_at', 'desc');
        if ($completed !== null) {
            $query->whereCompleted($completed);
        }
        return $query->get();
    }

    public function store(Request $request)
    {
        $toDo = new $this->todos;
        $toDo->to_do = $request->to_do;
        $toDo->completed = $request->completed;
        $toDo->user_id = Auth::user()->id;
        $toDo->save();
        return $toDo;
    }

    public function update(Request $request, ToDo $toDo)
    {
        $toDo->to_do = $request->to_do;
        $toDo->completed = $request->completed;
        $toDo->save();
        return $toDo;
    }

    public function completed(ToDo $toDo)
    {
        $toDo->completed = !$toDo->completed;
        $toDo->save();

        return;
    }
}