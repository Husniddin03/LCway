<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

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
        return view('connect.edit', compact('LearningCenter'));
    }

    public function store(Request $request, string $id)
    {
        $LearningCenter = LearningCenter::find($id);
        Gate::authorize('isOun', $LearningCenter);
        
        $request->validate([
            'connection_name' => 'required|string|max:255',
            'connection_icon' => 'nullable|string|max:255',
            'url' => ['required', 'regex:/^(https?:\/\/[^\s]+|mailto:[^\s]+@[^\s]+|\+?[\d\-\s\(\)]+)$/i']
        ]);


        $request->merge(['learning_centers_id' => $id]);

        LearningCentersConnect::create($request->all());
        return back()->with('success', 'Muoffaqiyatli qo\'shildi');
    }

    public function delete(string $id)
    {
        $connection = LearningCentersConnect::find($id);
        $LearningCenter = LearningCenter::find($connection->learning_centers_id);
        Gate::authorize('isOun', $LearningCenter);
        $connection->delete();
        return back()->with('success', 'Muoffaqiyatli o\'chirildi');
    }
}
