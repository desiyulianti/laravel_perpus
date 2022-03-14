<?php

namespace App\Http\Controllers;

use App\Models\DetailBookBorrow ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DetailBookBorrowController extends Controller
{

    
    //read data 
    public function show(){
        return DetailBookBorrow::all();
    }

    public function detail($id){
        if(DB::table('detail_book_borrow')->where('id_detail_book_borrow', $id)->exists()){
            $detail = DB::table('detail_book_borrow')
            ->select('detail_book_borrow.*')
            ->join('book_borrow', 'book_borrow.book_borrow_id', '=', 'detail_book_borrow.book_borrow_id')
            ->join('book', 'book.book_id', '=', 'detail_book_borrow.book_id')
            ->get();
            return Response()->json($detail);
        }else {
            return Response()->json(['message'=>'Couldnt find the data']);
        }
    }
   

    //create data start
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'book_borrow_id' => 'required',
            'book_id' => 'required',
            'qty' => 'required'
        ]);

        if($validator->fails()){
            return Response() -> json($validator->errors());
        }

        $store = DetailBookBorrow::create([
            'book_borrow_id' => $request->book_borrow_id,
            'book_id' => $request->book_id,
            'qty' => $request->qty
        ]);

        $data = DetailBookBorrow::where('book_borrow_id', '=', $request->book_borrow_id)->get();
        if($store){ 
            return Response()->json([
                'status' => 1,
                'message' => 'Succes create new data!',
                'data' => $data
            ]);
        }else {
            return Response() -> json([
                'status' => 0,
                'message' => 'Failed create new data!'
            ]);
        }
    }


    //update data 
    public function update($id, Request $request){
        $validator=Validator::make($request->all(),
        [
            'book_borrow_id' => 'required',
            'book_id' => 'required',
            'qty' => 'required'
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $update=DB::table('detail_book_borrow')
        ->where('id_detail_book_borrow', '=', $id)
        ->update(
            [
                'book_borrow_id' => $request->book_borrow_id,
                'book_id' => $request->book_id,
                'qty' => $request->qty
            ]);

        $data=DetailBookBorrow::where('id_detail_book_borrow', '=', $id)->get();
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
        $delete = DB::table('detail_book_borrow')
        ->where('id_detail_book_borrow', '=', $id)
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