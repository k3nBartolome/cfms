<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Items;
use App\Models\SiteInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function requestItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required',
            'site_id' => 'required',
            'quantity_approved' => 'required',
            'requested_by' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $inventory = new Inventory();
        $inventory->fill($request->all());
        $inventory->status = 'Pending';
        $inventory->transaction_type = 'Site Request';
        $inventory->save();
        $inventory->transaction_no = $inventory->id;
        $inventory->inventory_id = $inventory->id;
        $inventory->save();

        $requestedItem = Items::find($request->item_id);
        $requestedItem->quantity -= $request->quantity_approved;
        $requestedItem->save();

        return response()->json([
            'Request' => $inventory,
        ]);
    }

    public function approvedItem(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'approved_by' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $inventory = Inventory::find($id);
        $inventory->fill($request->all());
        $inventory->status = 'Approved';
        $inventory->save();

        return response()->json([
            'Request' => $inventory,
        ]);
    }

    public function receivedItem(Request $request, $id)
    {
        $inventory = Inventory::find($id);
    
        $validator = Validator::make($request->all(), [
            'received_by' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $inventory->approved_status = 'Received';
        $inventory->save();
    
        $totalCost = $inventory->item->cost * $inventory->quantity_approved;
    
        $site_inventory = new SiteInventory();
        $site_inventory->item_name = $inventory->item->item_name;
        $site_inventory->quantity = $inventory->quantity_approved;
        $site_inventory->original_quantity = $inventory->quantity_approved;
        $site_inventory->budget_code = $inventory->item->budget_code;
        $site_inventory->type = $inventory->item->type;
        $site_inventory->category = $inventory->item->category;
        $site_inventory->date_expiry = $inventory->item->date_expiry;
        $site_inventory->site_id = $inventory->site_id;
        $site_inventory->is_active = $inventory->item->is_active;
        $site_inventory->cost = $inventory->item->cost;
        $site_inventory->total_cost = $totalCost;

    
        $site_inventory->save();
    
        return response()->json([
            'Request' => $inventory,
        ]);
    }

    

    public function deniedItem(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'denied_by' => 'required',
            'denial_reason' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $inventory = Inventory::find($id);
        $inventory->fill($request->all());
        $inventory->status = 'Denied';
        $inventory->save();

        $requestedItem = Items::find($inventory->item_id);
        $requestedItem->quantity += $inventory->quantity_approved;
        $requestedItem->save();

        return response()->json([
            'Request' => $inventory,
        ]);
    }

    public function index()
    {
        $inventory = Inventory::with([
            'site',
            'item',
            'releasedBy',
            'approvedBy',
            'deniedBy',
            'receivedBy',
            'processedBy',
            'requestedBy',
        ])
        ->where('status', 'Pending')
        ->get();

        return response()->json(['inventory' => $inventory]);
    }

    public function approved()
    {
        $inventory = Inventory::with([
            'site',
            'item',
            'releasedBy',
            'approvedBy',
            'deniedBy',
            'receivedBy',
            'processedBy',
            'requestedBy',
        ])
        ->where('status', 'Approved')
        ->get();

        return response()->json(['inventory' => $inventory]);
    }
    public function approvedReceived()
    {
        $inventory = Inventory::with([
            'site',
            'item',
            'releasedBy',
            'approvedBy',
            'deniedBy',
            'receivedBy',
            'processedBy',
            'requestedBy',
        ])
        ->where('status', 'Approved')
        ->where('approved_status', 'Received')
        ->get();

        return response()->json(['inventory' => $inventory]);
    }
    public function approvedPending()
    {
        $inventory = Inventory::with([
            'site',
            'item',
            'releasedBy',
            'approvedBy',
            'deniedBy',
            'receivedBy',
            'processedBy',
            'requestedBy',
        ])
        ->where('status', 'Approved')
->whereNull('approved_status')
->get();


        return response()->json(['inventory' => $inventory]);
    }

    public function denied()
    {
        $inventory = Inventory::with([
            'site',
            'item',
            'releasedBy',
            'approvedBy',
            'deniedBy',
            'receivedBy',
            'processedBy',
            'requestedBy',
        ])
        ->where('status', 'Denied')
        ->get();

        return response()->json(['inventory' => $inventory]);
    }

    public function allstatus()
    {
        $inventory = Inventory::with([
            'site',
            'item',
            'releasedBy',
            'approvedBy',
            'deniedBy',
            'receivedBy',
            'processedBy',
            'requestedBy',
        ])
        ->get();

        return response()->json(['inventory' => $inventory]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\c $c
     *
     * @return \Illuminate\Http\Response
     */
    public function show(c $c)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\c $c
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(c $c)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Models\c $c
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, c $c)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\c $c
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(c $c)
    {
    }
}