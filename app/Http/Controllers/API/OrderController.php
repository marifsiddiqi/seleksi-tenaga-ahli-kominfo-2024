<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $orders = Order::with('products')->get();

            // Format ulang data untuk output sesuai kebutuhan
            $formattedOrders = $orders->map(function ($order) {
                $formattedProducts = $order->products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $product->pivot->quantity,
                        'stock' => $product->stock,
                        'sold' => $product->sold,
                        'created_at' => $product->pivot->created_at,
                        'updated_at' => $product->pivot->updated_at
                    ];
                });

                return [
                    'id' => $order->id,
                    'products' => $formattedProducts,
                    'created_at' => $order->created_at,
                    'updated_at' => $order->updated_at
                ];
            });

            return response()->json([
                'message' => 'Order List',
                'data' => $formattedOrders
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
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
        DB::beginTransaction();

        try {
            // Buat order baru
            $order = Order::create();

            // Loop untuk setiap produk dalam input
            foreach ($request->products as $productData) {
                $product = Product::findOrFail($productData['id']);

                // Cek apakah stok mencukupi
                if ($product->stock < $productData['quantity']) {
                    return response()->json([
                        'message' => "Product out of stock"
                    ], 400);
                }

                // Update stok dan jumlah produk terjual
                $product->stock -= $productData['quantity'];
                $product->sold += $productData['quantity'];
                $product->save();

                // Kaitkan produk dengan order melalui tabel pivot
                $order->products()->attach($product->id, [
                    'quantity' => $productData['quantity']
                ]);
            }

            DB::commit();

            // Ambil data lengkap order dengan produk
            $orderWithProducts = Order::with('products')->find($order->id);

            // Format data produk tanpa 'pivot'
            $formattedProducts = $orderWithProducts->products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $product->pivot->quantity,
                    'stock' => $product->stock,
                    'sold' => $product->sold,
                    'created_at' => $product->pivot->created_at,
                    'updated_at' => $product->pivot->updated_at
                ];
            });

            // Response sukses
            return response()->json([
                'message' => 'Order created',
                'data' => [
                    'id' => $order->id,
                    'products' => $formattedProducts,
                    'created_at' => $order->created_at,
                    'updated_at' => $order->updated_at,
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Product not found',
            ], 404);
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
        try {

            $order = Order::findOrFail($id);

            // Ambil data lengkap order dengan produk
            $orderWithProducts = Order::with('products')->find($id);

            // Format data produk tanpa 'pivot'
            $formattedProducts = $orderWithProducts->products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $product->pivot->quantity,
                    'stock' => $product->stock,
                    'sold' => $product->sold,
                    'created_at' => $product->pivot->created_at,
                    'updated_at' => $product->pivot->updated_at
                ];
            });

            // Response sukses
            return response()->json([
                'message' => 'Order Detail',
                'data' => [
                    'id' => $id,
                    'products' => $formattedProducts,
                    'created_at' => $orderWithProducts->created_at,
                    'updated_at' => $orderWithProducts->updated_at,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Order not found',
            ], 404);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            // Temukan order berdasarkan ID
            $order = Order::findOrFail($id);

            // Ambil data lengkap order dengan produk
            $orderWithProducts = Order::with('products')->find($id);

            // Format data produk tanpa 'pivot'
            $formattedProducts = $orderWithProducts->products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $product->pivot->quantity,
                    'stock' => $product->stock,
                    'sold' => $product->sold,
                    'created_at' => $product->pivot->created_at,
                    'updated_at' => $product->pivot->updated_at
                ];
            });

            $formattedData = [
                'id' => $id,
                'products' => $formattedProducts,
                'created_at' => $orderWithProducts->created_at,
                'updated_at' => $orderWithProducts->updated_at,
            ];

            // Loop melalui produk yang terkait dengan order
            foreach ($order->products as $product) {
                // Kembalikan stok produk
                $product->stock += $product->pivot->quantity;

                // Kurangi jumlah produk yang terjual
                $product->sold -= $product->pivot->quantity;

                // Simpan perubahan pada produk
                $product->save();
            }

            // Hapus relasi di tabel pivot
            $order->products()->detach();

            // Hapus order dari database
            $order->delete();

            DB::commit();

            // Response sukses
            return response()->json([
                'message' => 'Order deleted successfully',
                'data' => $formattedData
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            // Response error
            return response()->json([
                'message' => 'Order not found'
            ], 404);
        }
    }
}
