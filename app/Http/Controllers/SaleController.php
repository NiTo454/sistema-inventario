<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::with('user')->latest()->paginate(10);
        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('sales.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            return DB::transaction(function () use ($validated, $request) {
                $total = 0;
                $saleItems = [];

                // Calcular total y preparar items
                foreach ($validated['products'] as $item) {
                    $product = Product::findOrFail($item['id']);
                    
                    if ($product->stock < $item['quantity']) {
                        // Este error será capturado por el catch block
                        throw new \Exception("Stock insuficiente para el producto: {$product->name}. Disponible: {$product->stock}, Solicitado: {$item['quantity']}");
                    }

                    $total += $product->price * $item['quantity'];
                    $saleItems[$product->id] = [
                        'quantity' => $item['quantity'],
                        'price_at_sale' => $product->price
                    ];
                }

                // Crear venta
                $sale = Sale::create([
                    'user_id' => auth()->id(),
                    'subtotal' => $total,
                    'total' => $total,
                    'status' => 'completed',
                    'invoice_number' => 'INV-' . strtoupper(uniqid()),
                ]);

                // Guardar detalles y actualizar stock
                foreach ($saleItems as $productId => $data) {
                    $sale->products()->attach($productId, $data);
                    Product::find($productId)->decrement('stock', $data['quantity']);
                }

                return redirect()->route('sales.index')->with('success', 'Venta registrada correctamente.');
            });
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        return view('sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}