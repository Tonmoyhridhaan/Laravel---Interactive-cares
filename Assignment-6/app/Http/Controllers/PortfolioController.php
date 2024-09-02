<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function home(){
        $home = Storage::json('profile.json');
        return view('home', compact('home'));
        
    }
    public function projects(){
        $projects = Storage::json('projects.json');
        return view('projects', compact('projects'));
        
    }
    public function experience(){
        $experiences = Storage::json('experience.json');
        return view('experience', compact('experiences'));
        
    }
    public function projectSingle($id){
        
        $projects = Storage::json('projects.json');
        $project = collect($projects)->where('id', $id)->first();
        return view('projectSingle', compact('project'));

        
    }
}
