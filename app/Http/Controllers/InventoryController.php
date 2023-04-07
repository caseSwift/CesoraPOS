<?php

namespace App\Http\Controllers;
use App\Models\Inventory;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\InventoryAudit;
use Illuminate\Support\Facades\Auth;



class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::all();
        $inventoryItems = Inventory::all();

        return view('inventory.index', compact('inventoryItems', 'articles'));
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
        $article_id = $request->input('article_id');
        $quantity = $request->input('quantity');

        // Find the article by ID
        $article = Article::find($article_id);

        // Check if an inventory item with the same name already exists
        $inventory = Inventory::where('name', $article->name)->first();

        if ($inventory) {
            // An item with the same name already exists, update its quantity
            $inventory->quantity += $quantity;
            $inventory->save();
        } else {
            // Create a new inventory item
            $inventory = new Inventory();
            $inventory->name = $article->name;
            $inventory->quantity = $quantity;
            $inventory->save();
        }

        return redirect()->route('inventory.index');
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
        $inventoryItem = Inventory::find($id);
        return view('inventory.edit', compact('inventoryItem'));
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
        $inventoryItem = Inventory::find($id);

        if ($inventoryItem) {
            $oldQuantity = $inventoryItem->quantity;
            $newQuantity = $request->input('quantity');

            $inventoryItem->quantity = $newQuantity;
            $inventoryItem->save();

            $audit = new InventoryAudit();
            $audit->inventory_id = $inventoryItem->id;
            $audit->user_id = Auth::user()->id;
            $audit->action = 'updated';
            $audit->old_quantity = $oldQuantity;
            $audit->new_quantity = $newQuantity;
            $audit->save();

            return redirect()->route('inventory.index');
        } else {
            return back()->withErrors(['message' => 'Item not found.']);
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
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return redirect()->route('inventory.index');
    }
}
