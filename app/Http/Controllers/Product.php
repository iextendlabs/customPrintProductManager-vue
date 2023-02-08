<?php

namespace App\Http\Controllers;

use App\Models\Product as ModelsProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use File;

class Product extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->search)){
            $product = ModelsProduct::where('name','like',$request->search.'%')->get();
            if(count($product) <= 0){
                $product = ModelsProduct::where('sku','like',$request->search.'%')->get();
            }
            return response()->json($product);
        }else{
            $product = ModelsProduct::get();
            return response()->json($product);
        }
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
            'name'=>'required|max:255',
            'driveLink'=>'nullable',
            'sku'=>'required',
            'daraz'=>'required',
            'decorguys'=>'required',
            'carstickers'=>'required',
            'image' => 'required|mimes:jpg,png',
            'artcutFile' => 'required',
            'otherArtcutFile' => 'nullable',
        ]);
        
        $data = new ModelsProduct;
        
        if($request->image){
            $image = $request->image;

            $imageName = Str::random(7).'.'.$image->getClientOriginalExtension();
            
            $request->image->move('productimage',$imageName);
            
            $data->image = $imageName;
        }else{
            $data->image = 'null';
        }
        
        if($request->artcutFile){
            $file = $request->artcutFile;
        
            $artcutFile = Str::random(7).'.'.$file->getClientOriginalExtension();
    
            $request->artcutFile->move('productfile',$artcutFile);

            $data->artcutFile = $artcutFile;
        }else{
            $data->artcutFile = 'null';
        }
        
        if($request->otherArtcutFile){
            $other_file = $request->otherArtcutFile;

            $otherArtcutFile = Str::random(7).'.'.$other_file->getClientOriginalExtension();
    
            $request->otherArtcutFile->move('productfile',$otherArtcutFile);
            
            $data->otherArtcutFile = $otherArtcutFile;
        }else{
            $data->otherArtcutFile = 'null';
        }

        $data->name = $request->name;
        if(isset($request->driveLink)){
            $data->driveLink = $request->driveLink;
        }else{
            $data->driveLink = 'null';
        }
        $data->daraz = $request->daraz;
        $data->decorguys = $request->decorguys;
        $data->carstickers = $request->carstickers;
        $data->sku = $request->sku;

        $save = $data->save();

        if($save == 1){
            return response()->json('New Product has been successfully added. ');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = ModelsProduct::find($id);

        return response()->json($data);
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
        $request->validate([
            'name'=>'required|max:255',
            'driveLink'=>'nullable',
            'sku'=>'required',
            'image' => 'nullable|mimes:jpg,png',
            'artcutFile' => 'nullable',
            'otherArtcutFile' => 'nullable',
        ]);

        $data = ModelsProduct::find($id);
        
            if(!empty($request->image)){
                if(File::exists(public_path('productimage/'.$data->image))){
                    File::delete(public_path('productimage/'.$data->image));
                }
                $image = $request->image;

                $imagename = Str::random(7).'.'.$image->getClientOriginalExtension();

                $request->image->move('productimage',$imagename);

                $data->image = $imagename;
            }
            else{
                $data->image = $data->image;
            }

            if(!empty($request->artcutFile)){
                if(File::exists(public_path('productfile/'.$data->artcutFile))){
                    File::delete(public_path('productfile/'.$data->artcutFile));
                }
                $file = $request->artcutFile;

                $artcutFile = Str::random(7).'.'.$file->getClientOriginalExtension();

                $request->artcutFile->move('productfile',$artcutFile);

                $data->artcutFile = $artcutFile;
            }
            else{
                $data->artcutFile = $data->artcutFile;
            }

            if(!empty($request->otherArtcutFile)){
                if(File::exists(public_path('productfile/'.$data->otherArtcutFile))){
                    File::delete(public_path('productfile/'.$data->otherArtcutFile));
                }
                $other_file = $request->otherArtcutFile;

                $otherArtcutFile = Str::random(7).'.'.$other_file->getClientOriginalExtension();

                $request->otherArtcutFile->move('productfile',$otherArtcutFile);

                $data->otherArtcutFile = $otherArtcutFile;
            }
            else{
                $data->otherArtcutFile = $data->otherArtcutFile;
            }
        
        $data->name = $request->name;
        $data->daraz = $request->daraz;
        $data->decorguys = $request->decorguys;
        $data->carstickers = $request->carstickers;
        $data->driveLink = $request->driveLink;
        $data->sku = $request->sku;
        $save = $data->save();

        if($save == 1){
            return response()->json('Product has been successfully updated. ');
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
        $data = ModelsProduct::find($id);
        
        if(File::exists(public_path('productimage/'.$data->image))){
            File::delete(public_path('productimage/'.$data->image));
        }

        if(File::exists(public_path('productfile/'.$data->artcutFile))){
            File::delete(public_path('productfile/'.$data->artcutFile));
        }

        if(File::exists(public_path('productfile/'.$data->otherArtcutFile))){
            File::delete(public_path('productfile/'.$data->otherArtcutFile));
        }
        $data->delete();
        return response()->json(
            [
                'message'=>'Product Deleted.'
            ]    
        );
    }

    public function download($file){
        return response()->download(public_path('productfile/'.$file));
    }
}
