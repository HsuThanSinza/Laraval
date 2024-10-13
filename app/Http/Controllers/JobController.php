<?php

namespace App\Http\Controllers;

use \App\Mail\JobPosted;
use \Illuminate\Support\Facades\Mail;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class JobController extends Controller
{
    public function index(){
        $jobs=Job::with('employer')->latest()->paginate(3);
        //$jobs=Job::all();
        return view('jobs.index', [
            'jobs' => $jobs
        ]);
    }


    public function create(){
    return view('jobs.create');
    }



    public function show(Job $job){
        //$job=Job::find($id);
        // dd($job);
         return view('jobs.show', ['job' => $job]);
    }


    public function store(){
        request()->validate([
            'title'=>['required','min:3'],
            'salary'=>['required']
        ]);
        $job=Job::create([
            'title'=>request('title'),
            'salary'=>request('salary'),
            'employer_id'=>1
        ]);
        Mail::to($job->employer->user)->send(new JobPosted($job));  

        return redirect('/job');
    }


    public function edit(Job $job){
        //$job=Job::find($id);
        //if(Auth::user()->cannot('edit-job', $job)){
        //dd('failure');
        //}


    return view('jobs.edit', ['job' => $job]);
    }


    public function update(){
        Gate::authorize('edit-job',$job);

         //dd($id);
    request()->validate([
        'title'=>['required','min:3'],
        'salary'=>['required']
    ]);
    $job=Job::findOrFail($id);
    $job->update([
        'title'=>request('title'),
        'salary'=>request('salary')
    ]);
    return redirect('/jobs/' . $job->id );
    }


    public function destroy(Job $job){
        Gate::authorize('edit-job',$job);

        $job->delete();
        return redirect('/job');
    }
}
