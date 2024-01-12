<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use App\Http\Requests\StoreProblemRequest;
use App\Http\Requests\UpdateProblemRequest;
use App\Models\ProblemUser;
use App\Models\TestCase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProblemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $problems = Problem::all();
        return view('app.exam')->with([
            'problems' => $problems
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the request
        // $request->validate([
        //     'code_id' => 'required|string',
        //     'title' => 'required|string',
        //     'decription' => 'required|string',
        //     'level' => 'required|in:easy,medium,hard',
        //     'tags' => 'nullable|string',
        //     'input.*' => 'file|max:2048', // Assuming TXT files for input
        //     'output.*' => 'filemax:2048', // Assuming TXT files for output
        // ]);

        // Create a new problem
        $problem = new Problem;
        $problem->code = $request->get('code_id');
        $problem->title = $request->get('title');
        $problem->level = $request->get('level');
        $problem->decription = $request->get('description');
        $problem->tag = $request->get('tags');
        $problem->creater_id = Auth::user()->id;
        // Add other fields as needed
        $problem->save();

        // Save test cases
        for ($i = 1; $i <= 5; $i++) {
            $inputFile = $request->file("input$i");
            $outputFile = $request->file("output$i");

            // Store input file
            $inputPath = $inputFile->store('files_input');

            // Store output file
            $outputPath = $outputFile->store('files_output');

            // Create a new test case
            $testCase = new TestCase;
            $testCase->problem_id = $problem->id;
            $testCase->input_file = $inputPath;
            $testCase->output_file = $outputPath;
            $testCase->save();
        }

        return redirect('/app/exam');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $problem = Problem::find($id);
        //$comments = Comment::where('post_id',$post->id)->get();
        $title = $problem->title;
        $description = $problem->decription;
        return view('app.show')->with([
            'problem' => $problem,
            'title' => $title,
            'description' => $description
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $problem = Problem::find($id);
        $users = User::all();
        return view('app.edit')->with([
            'problem' => $problem,
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $problem = Problem::find($id);
        $problem->code = $request->get('code_id');
        $problem->title = $request->get('title');
        $problem->level = $request->get('level');
        $problem->decription = $request->get('description');
        $problem->tag = $request->get('tags');
        $problem->creater_id = Auth::user()->id;
        $problem->save();

        // Lấy danh sách người dùng được chọn
        $assignedUsers = $request->input('assigned_users', []);

        // Thêm vào bảng problem_user
        foreach ($assignedUsers as $userId) {
            ProblemUser::create([
                'user_id' => $userId,
                'problem_id' => $id,
                'assigner_id' => $request->input('assigner_id'),
                'assigned_at' => now(),
            ]);
        }
        return redirect('app/show/' . $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $problem = Problem::find($id);
        if ($problem->creater_id == Auth::user()->id) {
            $problem->delete();
            return redirect('/app/exam');
        } else
            return back();
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Thực hiện tìm kiếm các bài post theo $query và trả về kết quả
        $problems = Problem::where('code', 'like', '%' . $query . '%')
            ->orWhere('title', 'like', '%' . $query . '%')
            ->orWhere('level', 'like', '%' . $query . '%')
            ->orWhere('tag', 'like', '%' . $query . '%')
            ->get();

        return view('app.exam', ['problems' => $problems]);
    }

    public function assignedProblems()
    {
        // Lấy thông tin người dùng từ user_id
        $user = Auth::user();

        // Lấy danh sách các problems được giao cho người dùng
        $assignedProblems = $user->solvedProblems;

        // Trả về view với danh sách các problems
        return view('app.assigned_problems', compact('assignedProblems'),['user'=>$user,'problems' => $assignedProblems]);
    }
}
