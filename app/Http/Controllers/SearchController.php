<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search()
    {
        //return "about to search";
        $query_str = $_GET['query'];
        $search_results = Customer::where('first_name', 'LIKE', '%' . $query_str . '%')->orWhere('surname', 'LIKE', '%' . $query_str . '%')->orWhere('phone_number', 'LIKE', '%' . $query_str . '%')->orWhere('account_number', 'LIKE', '%' . $query_str . '%')->get();
        return $search_results;
    }
}
