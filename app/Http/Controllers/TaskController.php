<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Mail;
use App\Mail\TutorialMail;
use App\Jobs\SendMail;
use App\Jobs\SendMail2;
use Carbon\Carbon;
use PDF;
class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Task::all(); //collection
        Task::where('id','>',10)->get(); //collection
        Task::where('id','=',10)->get(); //collection
        Task::first(); //model
        Task::find(2); //model
        Task::paginate(3); //paginator/collection
        dd(Task::get()->last()); //model
    }

    public function collect()
    {
        $array = ['a','b','c'];
        $array2 = ['d','e','f'];
        $collection = collect(['a','b','c']);
        $collection2 = collect(['d','e','f']);
        // foreach ($array2 as $key => $val) {
        //     array_push($array,$val);
        // }

        // $array = array_merge($array,$array2);
        // $combined = $collection->merge($collection2);


        // $collection->prepend($collection2);

        // check empty array
        // if(sizeof($array)>0){
        //     dd(sizeof($array));
        // }

        // if(!empty($array)){
        //     dd(count($array));
        // }

        // check empty collection
        // dd($collection->isEmpty());
        // dd($collection->isNotEmpty());

        // $tasks = Task::limit(40)->get();
        // $taskGroup = $tasks->splitIn(4);

        // foreach ($taskGroup as $key => $group) {
        //     foreach ($group as $key => $task) {
        //         echo '-'.$task->description.'<br>';
        //     }
        //     echo '---Next Page---<br>';
        // }

        // $collection = collect([1,2,3,4,5,6,7,8]);

        // [$collect1,$collect2] = $collection->partition(function ($i) {
        //     return $i < 4;
        // });

        $collection = collect([
            ['name'=>'Abu', 'age'=>7, 'gender'=>'M'],
            ['name'=>'Siti', 'age'=>12, 'gender'=>'F'],
            ['name'=>'Tom', 'age'=>9, 'gender'=>'M'],
            ['name'=>'Sally', 'age'=>11, 'gender'=>'F']
        ]);

        //  dd($collection->whereBetween('age',[7,9]));
        //  dd($collection->whereIn('age',[7,9]));
        dd($collection->sortByDesc('age'));
    }

    public function ratelimiter()
    {
        echo 'Accessed ratelimiter function';
    }

    public function sendEmail()
    {
        $name='John Doe';
        // Mail::send('mail.test1', compact('name'), function ($message) {
        //     $message->from('kamalnorizan@gmail.com', 'Kamal Norizan');
        //     $message->to('john@johndoe.com', 'John Doe');
        //     $message->subject('Test Send Email');
        // });

        // Mail::to('john@johndoe.com')->send(new TutorialMail('Zainal Abidin'));
        // Mail::to('john@johndoe.com')
        //     ->queue(new TutorialMail('Zainal Abidin'));
        $users = User::limit(20)->get();
        $data = ['name'=>'Kamal','email'=>'testemailgunajob@gmail.com','users'=>$users];
        $mailJob = (new SendMail2($data))->delay(Carbon::now()->addSecond());
        dispatch($mailJob);
        echo 'Mail sent';
    }

    public function userattach()
    {
        $users = User::limit(20)->get();
        $pdf = PDF::loadView('mail.users',compact('users'));
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
     * @param  \App\Http\Requests\StoreTaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTaskRequest  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
