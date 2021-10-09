<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Facade\FlareClient\Http\Response;
use GrahamCampbell\ResultType\Result;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $product = DB::table('products')
            ->join('categories', 'products.id_kategori', '=', 'categories.id')
            ->select('products.*', 'categories.kategori')
            ->get();
        return response()->json([
            'message' => 'Success!',
            'data_product' => $product
        ], 200);
    }

    // product by seller
    public function getProductBySeller($seller)
    {
        $product = DB::table('products')
            ->join('categories', 'products.id_kategori', '=', 'categories.id')
            ->select('products.*', 'categories.kategori')
            ->where('products.seller','=',$seller)
            ->get();
        return response()->json([
            'message' => 'Success!',
            'data_product' => $product
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'nama'=>'required',
            'seller'=>'required',
            'id_kategori'=>'required',
            'deskripsi'=>'required',
            'harga'=>'required',
            'stok'=>'required',
            'gambar'=>'required|mimes:png,jpg,jpeg',
        ]);

        try{
            $fileName = time().$request->nama.'.'.$request->file('gambar')->getClientOriginalExtension();
            $path = $request->file('gambar')->storeAs('product',$fileName);
            $validasi['gambar']=$path;
            $response =Product::create($validasi);
            return response()->json([
                'success' => true,
                'message' => 'Product Created',
            ], 200);
        }catch(\Throwable $e){
            return response()->json([
                'message' => 'Err',
                'errors' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return response()->json([
            'success' => true,
            'message' => 'Success',
            'product' => $product,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $product = Product::find($id);

        $request->validate([
            'nama'=>'required',
            'seller'=>'required',
            'id_kategori'=>'required',
            'deskripsi'=>'required',
            'harga'=>'required',
            'stok'=>'required',
            'gambar'=>'mimes:png,jpg,jpeg',
        ]);

        $product->nama = $request->nama;
        $product->seller = $request->seller;
        $product->id_kategori = $request->id_kategori;
        $product->deskripsi = $request->deskripsi;
        $product->harga = $request->harga;
        $product->stok = $request->stok;

        try{
            if($request->hasFile('gambar')){
                unlink(storage_path("app/".$product->gambar));
                $fileName = time().$request->nama.'.'.$request->file('gambar')->getClientOriginalExtension();
                $path = $request->file('gambar')->storeAs('product',$fileName);
                $product->gambar = $path;
            }
            $product->update();
            return response()->json([
                'success' => true,
                'message' => 'Product Updated',
            ], 200);
        }catch(\Throwable $e){
            return response()->json([
                'message' => 'Err',
                'errors' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $product = Product::find($id);
            unlink(storage_path("app/".$product->gambar));
            $delete = Product::find($id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Product deleted',
            ], 200);
    }

    // upload image
    public function upload(Request $img){

        $image=$img->file('gambar')->store('product');
        return[
            "result"=>$image,
        ];
    }
}
