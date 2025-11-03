<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Models\LearningCenter;
use App\Models\LearningCentersConnect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ConnectController extends Controller
{
    public function edit(string $id)
    {
        $LearningCenter = LearningCenter::find($id);
        Gate::authorize('isOun', $LearningCenter);
        $connections = Connection::all();
        return view('connect.edit', compact('LearningCenter', 'connections'));
    }

    public function store(Request $request, string $id)
    {
        $request->validate([
            'connection_id' => 'required|exists:connection,id',
            'url' => ['required', 'regex:/^(https?:\/\/[^\s]+|mailto:[^\s]+@[^\s]+|\+?[\d\-\s\(\)]+)$/i']
        ]);


        $request->merge(['learning_centers_id' => $id]);

        LearningCentersConnect::create($request->all());
        return back()->with('success', 'Muoffaqiyatli qo\'shildi');
    }

    public function delete(string $id)
    {
        LearningCentersConnect::find($id)->delete();
        return back()->with('success', 'Muoffaqiyatli o\'chirildi');
    }
}
