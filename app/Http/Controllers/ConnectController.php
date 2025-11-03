<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Models\LearningCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ConnectController extends Controller
{
    public function edit(string $id) {
        $LearningCenter = LearningCenter::find($id);
        Gate::authorize('isOun', $LearningCenter);
        $connections = Connection::all();
        return view('connect.edit', compact('LearningCenter', 'connections'));
    }

    public function store(Request $request, string $id) {
        
    }

    public function delete(string $id) {
        
    }
}
