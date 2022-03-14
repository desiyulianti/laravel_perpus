<?php

namespace App\Http\Controllers;

use App\Models\BookBorrow;
use App\Models\BookReturn ;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BookReturnController extends Controller
{
    //create data 
    public function returningbook(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'book_borrow_id'=>'required'
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $cek_again=BookReturn::where('book_borrow_id',$req->book_borrow_id);
        if($cek_again->count() == 0){
            $dt_returning = BookBorrow::where('book_borrow_id',$req->book_borrow_id)->first();
            $date_now = Carbon::now()->format('Y-m-d');
            $date_of_returning = new Carbon($dt_returning->date_of_returning);
            $dendaperhari = 1500;
            if(strtotime($date_now) > strtotime($date_of_returning)){
                $jumlah_hari = $date_of_returning->diff($date_now)->days;
                $denda = $jumlah_hari*$dendaperhari;
            }else {
                $denda = 0;
            }
            $save = BookReturn::create([
                'book_borrow_id'    => $req->book_borrow_id,
                'date_of_returning'  => $date_of_returning,
                'fine'                 => $denda,
            ]);
            if($save){
                $data['status'] = 1;
                $data['message'] = 'Successfully returned';
            } else {
                $data['status'] = 0;
                $data['message'] = 'Returned failed';
            }
        } else {
            $data = ['status'=>0,'message'=>'It has been returned'];
        }
        return response()->json($data);
    }



    //read data 
    public function show(){
        return BookReturn::all();
    }

    public function detail($id){
        if(DB::table('book_return')->where('book_return_id', $id)->exists()){
            $detail = DB::table('book_return')
            ->select('book_return.*')
            ->join('book_borrow', 'book_borrow.book_borrow_id', '=', 'book_return.book_borrow_id')
            ->where('book_return_id', $id)
            ->get();
            return Response()->json($detail);
        }else{
            return Response()->json(['message' => 'Couldnt find the data']);
        }
    }


    //update data 
    public function update($id, Request $request){
        $validator=Validator::make($request->all(),
        [
            'book_borrow_id' => 'required',
            'date_of_returning' => 'required',
            'fine' => 'required'
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $update=DB::table('book_return')
        ->where('book_return_id', '=', $id)
        ->update([
            'book_borrow_id' => $request->book_borrow_id,
            'date_of_returning' => $request->date_of_returning,
            'fine' => $request->fine
        ]);

        $data=BookReturn::where('book_return_id', '=', $id)->get();
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
        $delete = DB::table('book_return')
        ->where('book_return_id', '=', $id)
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