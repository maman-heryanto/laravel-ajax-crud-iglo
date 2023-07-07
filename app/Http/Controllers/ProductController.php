<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = 'Product';
        $data['product'] = Product::orderBy('created_by', 'DESC')->get();
        // dd($data['product']);
        return view('product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();

            if ($request->has('imageProduct')) {
                //save file
                $file = $data['imageProduct'];
                $fileName = 'file' . time() . '.' . $file->extension();
                $data['image'] = $fileName;
                $file->move(public_path() . '/assets/uploads/images/product/', $fileName);
            }

            unset($data['imageProduct']);

            $product = Product::create($data);

            $status_code = 200;
            $response = array(
                'status' => 200,
                'message' => "success",
                'data' => $product,
            );
            DB::commit();
            return response()->json($response, $status_code);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => $e->getMessage(),
                'data' => [],
            ], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getData(Request $request)
    {
        // $data = Product::where('id', $request->id())->first();
        $data = Product::find($request->id);
        return response()->json($data);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();

            $product = Product::find($request->productId_edit);
            if (!$product) {
                return response()->json([
                    'status' => 500,
                    'success' => false,
                    'message' => "Data not found",
                    'data' => [],
                ]);
            }

            if ($request->has('imageProductEdit')) {
                //save file
                $file = $data['imageProductEdit'];
                $fileName = 'file' . time() . '.' . $file->extension();
                $data['image'] = $fileName;
                $file->move(public_path() . '/assets/uploads/images/product/', $fileName);
            }
            unset($data['imageProductEdit']);
            unset($data['productId_edit']);

            Product::where('id', $request->productId_edit)->update($data);

            $status_code = 200;
            $response = array(
                'status' => 200,
                'message' => "success edit product",
                'data' => [],
            );
            DB::commit();
            return response()->json($response, $status_code);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => $e->getMessage(),
                'data' => [],
            ], 200);
        }
    }


    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {

            Product::where('id', $request->productId_delete)->update(['deleted_at' => now()]);

            $status_code = 200;
            $response = array(
                'status' => 200,
                'message' => "success edit product",
                'data' => [],
            );
            DB::commit();
            return response()->json($response, $status_code);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => $e->getMessage(),
                'data' => [],
            ], 200);
        }
    }
}