<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TradeDetail;


class TradeController extends Controller
{
    public function index()
    {
        $trades = TradeDetail::all();
        return view('alltrades' ,['trades' => $trades]);
    }
}
