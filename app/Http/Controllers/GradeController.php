<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class GradeController extends Controller
{
    //create data 
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_name' => 'required',
            'group' => 'required'
        ]);

        if($validator -> fails()){
            return Response() -> json($validator -> errors());
        }

        $store = Grade::create([
            'class_name' =>$request->class_name,
            'group' => $request->group
        ]);

        $data = Grade::where('class_name', '=', $request->class_name)->get();
        if($store){
            return Response() -> json([
                'status' => 1,
                'message' => 'Succes create new data!',
                'data' => $data
            ]);
        } else 
        {   
            return Response()->json([
                'status' => 0,
                'message' => 'Failed create new data!'
            ]);
        }
    }
    

    // show data 
    public function show(){
        return Grade::all();
    }

    public function detail($id){
        if(DB::table('class')->where('class_id', $id)->exists()){
            $detail_grade = DB::table('class')
            ->select('class.*')
            ->where('class_id', $id)
            ->get();
            return Response()->json($detail_grade);
        }else {
            return Response()-> json(['message' => 'Couldnt find the data']);
        }
    }
    

    //update data 
    public function update($id, Request $request){
        $validator = Validator::make($request->all(),
        [
            'class_name' => 'required',
            'group' => 'required'
        ]);

        if($validator -> fails()){
            return Response() -> json($validator -> errors());
        }

        $update = DB::table('class')
        ->where('class_id', '=', $id)
        ->update([
            'class_name' => $request->class_name,
            'group' => $request->group
        ]);

        $data=Grade::where('class_id', '=', $id)->get();
        if($update){
            return Response() -> json([
                'status' => 1,
                'message' => 'Success updating data!',
                'data' => $data  
            ]);
        } else {
            return Response() -> json([
                'status' => 0,
                'message' => 'Failed updating data!'
            ]);
        }
    }
    

    //delete data 
    public function delete($id){
        $delete = DB::table('class')
        ->where('class_id', '=', $id)
        ->delete();

        if($delete){
            return Response() -> json([
                'status' => 1,
                'message' => 'Succes delete data!'
        ]);
        } else {
            return Response() -> json([
                'status' => 0,
                'message' => 'Failed delete data!'
        ]);
        }

    }
   
}