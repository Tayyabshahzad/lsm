<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $teachers = User::with('roles')->whereHas('roles', function ($query) {
            $query->where('name', 'teacher');
        })->get();

        return response()->json($teachers);
    }


}
