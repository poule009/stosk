<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Telephone; // Assuming the Telephone model is used for products

class DashboardController extends Controller
{
    public function index()
    {
        // Calculate total products (assuming each record in 'telephones' table is a product)
        $totalProducts = Telephone::count();

        // Calculate total stock remaining
        $totalStockRemaining = Telephone::sum('stock');

        // Calculate total sales
        // IMPORTANT ASSUMPTION:
        // Since there is no explicit 'sales' table or 'Vente' model identified,
        // and based on the available 'telephones' table with a 'price' column,
        // this calculation assumes 'total sales' refers to the sum of all product prices.
        // This is a placeholder and should be replaced with actual sales logic
        // if a sales tracking system is implemented in the future.
        $totalSales = Telephone::sum('price');


        return view('dashboard', compact('totalProducts', 'totalStockRemaining', 'totalSales'));
    }
}
