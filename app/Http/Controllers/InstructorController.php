<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InstructorController extends Controller
{

    protected $user;

    public function __construct(User $user){
        $this->middleware("auth:api");
        $this->user = $this->guard()->user();
    }

    public function index()
    {
        return response()->json($this->user, 200);
    }

    public function create()
    {
        //
    }

    public function store(Request $request, $productId)
    {

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
