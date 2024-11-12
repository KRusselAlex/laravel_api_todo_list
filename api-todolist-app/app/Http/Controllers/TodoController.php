<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $todo = Todo::all();
        $todo =  $todo->reverse()->values();
        return response()->json($todo);
      
    }

    public function store(Request $request)
    {

         $validator = Validator::make($request->all(), [
            'name' => 'required|unique:todos|string',
            'description' => ['string'],
            'user_id' => ['required', 'exists:users,id'],

        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Bad params',
                'error' => $validator->messages(),
            ], 422);
        } else {
            $todo = new Todo();
            $todo->name = $request->name;
            $todo->description = $request->description;
            $todo->user_id = $request->user_id;
            $todo->save();
            return response()->json(["message" => "todo created", "todo" => $todo], 201);
        }
    }


    public function show($id)
    {
        $todo = Todo::find($id);
        if (!empty($todo)) {
            return response()->json($todo);
        } else {
            return response()->json([
                "message" => "todo not found !!"
            ], 404);
        }
    }


    public function update(Request $request, $id)
    {

        if (Todo::where('id', $id)->exists()) {

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:todos|string',
                'description' => ['required', 'string'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Bad params',
                    'error' => $validator->messages(),
                ], 422);
            } else {
                $todo = Todo::find($id);
                $todo->name = $request->name;
                $todo->description = $request->decription;


                $todo->save();
                return response()->json([
                    "message" => "task Updated Succefully !"
                ], 200);
            }
        } else {

            return response()->json([
                "message" => "task Not Found ."
            ], 404);
        }
    }

    public function search(Request $request)
    {
        $search =  strtolower($request->input('search'));
        $todo =  DB::table('todos')->where(
            'name',
            'LIKE',
            "%$search%"
        ) ->get();
            

        return response()->json($todo);
    }


    public function destroy($id)
    {
        if (Todo::where('id', $id)->exists()) {
            $todo = Todo::find($id);
            $todo->delete();

            return response()->json([
                "message" => "Todo deleded Succesfully !"
            ], 200);
        } else {
            return response()->json([
                "message" => "Todo Not Found ."
            ], 404);
        }
    }
}
