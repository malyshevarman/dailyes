<?php

namespace App\Http\Controllers\Backend\Tile;

use App\Http\Controllers\Controller;
use App\Tile;

class TileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.tile.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.tile.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tile  $tile
     * @return \Illuminate\Http\Response
     */
    public function edit(Tile $tile)
    {
        return view('backend.tile.edit');
    }
}
