<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Application;

class ApplicationController extends Controller
{
    //
     public function application(Request $request)
     {
    
        try{
            $validated = $request->validate([
                'name'    => 'required|string|max:255',
                'email'   => 'required|email|unique:applications,email',
                'phone'   => 'required|string',
                'college' => 'nullable|string',
                'degree'  => 'required|string',
                'domain'  => 'required|string',
                'skills'  => 'required|string',
                'resume_path'  => 'nullable|file|mimes:pdf|max:10240',
            ]);
        } catch(ValidationException $e){
            return response()->json([
               'success' => false,
                'errors'  => $e->errors(),
            ], 422);
        }

        $resumePath = null;
        if ($request->hasFile('resume')) {
            $file = $request->file('resume');
            $extension = $file->getClientOriginalExtension();
            $cleanName = Str::slug($request->name);
            $fileName = $cleanName . '.' . $extension;

            $resumePath = $file->storeAs('resumes', $fileName, 'public');
        }

        $application = Application::create([
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'phone'       => $validated['phone'],
            'college'     => $validated['college'] ?? null,
            'degree'      => $validated['degree'],
            'domain'      => $validated['domain'],
            'skills'      => $validated['skills'],
            'resume_path' => $resumePath,
        ]);

        return response()->json([
            'success' => true,
            'id' => $application->id,
            'message' => 'Registration successful'
        ], 201);
    }
}