<?php

namespace App\Http\Controllers;

use App\Models\CoutLivraison;
use Illuminate\Http\Request;

class CoutLivraisonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coutLivraisons = CoutLivraison::all();
        return view("cout_livraisons.index", compact("coutLivraisons"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $coutLivraison = new CoutLivraison();
        $coutLivraison->cout_livraison = $request->cout_livraison;
        $coutLivraison->save();
        return redirect()->route("cout_livraisons.index")->with("popup", true);
    }

    /**
     * Display the specified resource.
     */
    public function show(CoutLivraison $coutLivraison)
    {
        return response()->json($coutLivraison);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CoutLivraison $coutLivraison)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CoutLivraison $coutLivraison)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CoutLivraison $coutLivraison)
    {
        $coutLivraison->delete();
        return redirect()->route("cout_livraisons.index")->with("popup", true);
    }
}
