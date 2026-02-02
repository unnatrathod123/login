<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

use Illuminate\Http\Request;
use App\Models\Application;

class ApplicationController extends Controller
{
    //
     public function application(Request $request)
     {
    // {
    //     $request->validate([
    //         'name'    => 'required|string|max:255',
    //         'email'   => 'required|email|unique:applications',
    //         'phone'   => 'required',
    //         'college' => 'nullable|string',
    //         'degree'=> 'required',
    //     'domain'=> 'required',
    //     'skills'=> 'required',
    //         'resume'  => 'nullable|file|mimes:pdf,doc,docx|max:2048'
    //     ]);

    //     $resumePath = null;

    //     if ($request->hasFile('resume')) {
    //         $resumePath = $request->file('resume')->store('resumes', 'public');
    //     }

    //     $intern = Application::create([
    //         'name'        => $request->name,
    //         'email'       => $request->email,
    //         'phone'       => $request->phone,
    //         'college'     => $request->college,
    //         'degree'     => $request->degree, 
    //         'domain'     => $request->domain,
    //         'skills'  => $request->skills,
    //         'resume_path' => $resumePath
    //     ]);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Registration successful',
    //         'data' => $intern
    //     ], 201);
    // }


//     try {
//     $request->validate([
//         'name'    => 'required|string|max:255',
//         'email'   => 'required|email|unique:applications,email',
//         'phone'   => 'required',
//         'degree'  => 'required',
//         'domain'  => 'required',
//         'skills'  => 'required',
//     ]);
// } catch (ValidationException $e) {
//     return response()->json([
//         'status' => false,
//         'errors' => $e->errors(),
//     ], 422);
// }

// if ($request->hasFile('resume')) {
//             $resumePath = $request->file('resume')->store('resumes', 'public');
//         }

//         $intern = Application::create([
//             'name'        => $request->name,
//             'email'       => $request->email,
//             'phone'       => $request->phone,
//             'college'     => $request->college,
//             'degree'     => $request->degree, 
//             'domain'     => $request->domain,
//             'skills'  => $request->skills,
//             'resume_path' => $resumePath
//         ]);
//      }



    
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:applications,email',
            'phone'   => 'required|string',
            'college' => 'nullable|string',
            'degree'  => 'required|string',
            'domain'  => 'required|string',
            'skills'  => 'required|string',
            'resume_path'  => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $resumePath = null;
        if ($request->hasFile('resume_path')) {
            $resumePath = $request->file('resume_path')->store('resumes', 'public');
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