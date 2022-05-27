<?php

namespace App\Observers;

use App\Models\Todolist;

class TodolistObserver
{
    // public $afterCommit = true;

    /**
     * Handle the Todolist "created" event.
     *
     * @param  \App\Models\Todolist  $todolist
     * @return void
     */
    public function creating(Todolist $todolist)
    {
        $todolist->title = strtoupper($todolist->title);
    }

    /**
     * Handle the Todolist "created" event.
     *
     * @param  \App\Models\Todolist  $todolist
     * @return void
     */
    public function created(Todolist $todolist)
    {
        // $todolist->title = strtoupper($todolist->title);
        // $todolist->save();
    }

    /**
     * Handle the Todolist "updated" event.
     *
     * @param  \App\Models\Todolist  $todolist
     * @return void
     */
    public function updated(Todolist $todolist)
    {
        //
    }

    /**
     * Handle the Todolist "deleted" event.
     *
     * @param  \App\Models\Todolist  $todolist
     * @return void
     */
    public function deleted(Todolist $todolist)
    {
        //
    }

    /**
     * Handle the Todolist "restored" event.
     *
     * @param  \App\Models\Todolist  $todolist
     * @return void
     */
    public function restored(Todolist $todolist)
    {
        //
    }

    /**
     * Handle the Todolist "force deleted" event.
     *
     * @param  \App\Models\Todolist  $todolist
     * @return void
     */
    public function forceDeleted(Todolist $todolist)
    {
        //
    }
}
