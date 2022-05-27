<?php

namespace App\Http\Controllers;

use App\Models\Todolist;
use App\Models\Gambar;
use App\Models\Task;
use App\Models\Scopes\ActiveScope;
use App\Models\Scopes\StatusScope;
use App\Http\Requests\StoreTodolistRequest;
use App\Http\Requests\UpdateTodolistRequest;

class TodolistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todolists = Todolist::with('user')->get();
        foreach ($todolists as $key => $todolist) {
            echo $todolist->user->name.' - '.$todolist->title.'<br>';
            // $todolist->load('tasks');
            foreach ($todolist->tasks as $key => $task) {
               echo '  - '.$task->description.'<br>';
            }
            echo '<br>';
        }
    }

    public function lazyeager()
    {
        $todolists = Todolist::with('user')->get();
        foreach ($todolists as $key => $todolist) {
            echo $todolist->user->name.' - '.$todolist->title.'<br>';
            // $todolist->load('user.todolists');
            foreach ($todolist->user->todolists as $key => $todolistNest) {
               echo '  - '.$todolistNest->title.'<br>';
               if($todolistNest->id < 10){
                    $todolistNest->load('user');
               }
            }
            echo '<br>';
        }
    }

    public function polyrel()
    {
        $todolist = Todolist::find(2);
        $gambar1 = new Gambar;
        $gambar1->path = 'uploads/c.jpg';
        $todolist->images()->save($gambar1);

        $gambar2 = new Gambar;
        $gambar2->path = 'uploads/d.jpg';
        $todolist->images()->save($gambar2);

        dd($todolist->images);
    }

    public function polyreltask()
    {
        $task = Task::find(1);
        $gambar1 = new Gambar;
        $gambar1->path = 'uploads/e.jpg';
        $task->images()->save($gambar1);

        $gambar2 = new Gambar;
        $gambar2->path = 'uploads/f.jpg';
        $task->images()->save($gambar2);

        dd($task->images);
    }

    public function todolistScope()
    {
        // $tasks = Task::all();
        // $tasks = Task::withoutGlobalScope('App\Models\Scopes\ActiveScope')->get();

        $tasks = Task::withoutGlobalScope(StatusScope::class)->get();

        // $tasks = Task::withoutGlobalScopes()->get();

        dd($tasks);
    }

    public function localScope()
    {
        // $images = Gambar::todolist()->get();
        $images = Gambar::image('todolist')->get();
        dd($images);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTodolistRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTodolistRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todolist  $todolist
     * @return \Illuminate\Http\Response
     */
    public function show(Todolist $todolist)
    {
        // $task = new Task;
        // $task->description = 'Task Description Test';
        // $todolist->tasks()->save($task);

        // $todolist->tasks()->saveMany([
        //     new Task(['description'=>'Task save many 1']),
        //     new Task(['description'=>'Task save many 2']),
        //     new Task(['description'=>'Task save many 3']),
        //     new Task(['description'=>'Task save many 4']),
        // ]);

        // $todolist->tasks()->create([
        //     'description'=>'Task create 1'
        // ]);

        $todolist->tasks()->createMany([
            ['description'=>'Task create Many 1'],
            ['description'=>'Task create Many 2'],
            ['description'=>'Task create Many 3'],
            ['description'=>'Task create Many 4']
        ]);

        dd($todolist->tasks);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todolist  $todolist
     * @return \Illuminate\Http\Response
     */
    public function edit(Todolist $todolist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTodolistRequest  $request
     * @param  \App\Models\Todolist  $todolist
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTodolistRequest $request, Todolist $todolist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todolist  $todolist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todolist $todolist)
    {
        //
    }
}
