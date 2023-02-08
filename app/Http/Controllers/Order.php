<?php

namespace App\Http\Controllers;

use App\Models\Order as ModelsOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use File;

class Order extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
            $order = ModelsOrder::orderBy('created_at', 'DESC')->get();
            return response()->json($order);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpg,png',
            'invoice' => 'required|mimes:pdf',
        ]);
        $data = new ModelsOrder();
        
        if($request->image){
            $image = $request->image;

            $imageName = Str::random(7).'.'.$image->getClientOriginalExtension();
            
            $request->image->move('orderimage',$imageName);
            
            $data->image = $imageName;
        }else{
            $data->image = 'null';
        }
        
        if($request->invoice){
            $file = $request->invoice;
        
            $invoice = Str::random(7).'.'.$file->getClientOriginalExtension();
    
            $request->invoice->move('orderinvoice',$invoice);

            $data->invoice = $invoice;
        }else{
            $data->invoice = 'null';
        }
        
        $data->note = $request->note;
        $data->checked = '0';
        $data->status = '0';

        $save = $data->save();

        if($save == 1){
            return response()->json('New Order has been successfully added. ');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = ModelsOrder::find($id);
        $data->checked = "1";
        $data->save();
        
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = ModelsOrder::find($id);
        $order->status = $request->status;
        $order = $order->save();

        if($order == 1){
            return response()->json('successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = ModelsOrder::find($id);
        
        if(File::exists(public_path('orderimage/'.$data->image))){
            File::delete(public_path('orderimage/'.$data->image));
        }

        if(File::exists(public_path('orderinvoice/'.$data->invoice))){
            File::delete(public_path('orderinvoice/'.$data->invoice));
        }

        $data->delete();
        return response()->json(
            [
                'message'=>'Product Deleted.'
            ]    
        );
    }

    public function todayOrders(){
        
        $order = ModelsOrder::orderBy('created_at', 'DESC')->where('status','0')->get();
        return response()->json($order);

    }

    public function downloadInvoice($file){
        return response()->download(public_path('orderinvoice/'.$file));
    }
}
