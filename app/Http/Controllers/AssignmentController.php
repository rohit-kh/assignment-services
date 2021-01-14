<?php

namespace App\Http\Controllers;

use App\Models\Assignments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AssignmentController extends Controller
{

    protected $user;

    public function __construct(User $user){
        $this->middleware("auth:api");
        $this->user = $this->guard()->user();
    }

    public function index()
    {

        $userData = User::with("assignments.subject.subjectDetail")->find($this->user->id);
        return $userData;
//        with('testHasOneThrough')
//        $userData = Assignments::with("subject")
//            ->where('created_by',$this->user->id)->get();
//        return $userData;
//        $this->user->assignments = $this->user->with("assignments")->get();
//        return response()->json($this->user, 200);
//        return response()->json($this->user->assignments()->subject()->get(), 200);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            "name" => "required|string",
            "instructor_subject_id" => "required|integer",
            'deadline' => 'required|date_format:Y-m-d H:i:s',
            'questions' => 'required|mimes:pdf|max:10240',
        ]);

        $assignment = new Assignments();
        $assignment->name = $request->name;
        $assignment->instructor_subject_id = $request->instructor_subject_id;
        $assignment->deadline = $request->deadline;
        $assignment->questions = $this->uploadImage($request);
        if ($this->user->subjects()->save($assignment)) {
            return response()->json($assignment);
        } else {
            return response()->json([
                "message" => "Oops, assignment cannot be saved"
            ], 400);
        }
    }

    protected function uploadImage(Request $request)
    {
        $image = $request->file("questions");
        $newName = strtotime(Carbon::now()) . rand() . ".". $image->getClientOriginalExtension();
        $image->move(("public/files"), $newName);
        return $newName;
    }


    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        //
    }

    public function update(Request $request, User $user, $productId, $commentId)
    {

    }

    public function destroy(User $user)
    {
        //
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
