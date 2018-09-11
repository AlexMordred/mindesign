<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function index()
    {
        $popular = DB::select('
            SELECT DISTINCT p.*, SUM(o.sales) as popularity
            FROM offers AS o

            LEFT JOIN products p
            ON p.id = o.product_id

            GROUP BY o.product_id

            ORDER BY popularity DESC
            LIMIT 20
        ');

        return request()->wantsJson()
            ? response()->json($popular)
            : view('index', compact('popular'));
    }
}
