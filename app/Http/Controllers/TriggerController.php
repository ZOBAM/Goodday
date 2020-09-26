<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TriggerController extends Controller
{
    public function index(){
        return "
        8610384D63CC0D9002DEDC6EDAA59E65

This is ATrigger.com API Verification File.
This file should be placed on the root folder of target url. This file is unique for each account in ATrigger.com
http://example.com/mySite/Task?name=joe        This file should be available at: http://example.com/ATriggerVerify.txt
http://sub.example.com/mySite/Task?name=joe    This file should be available at: http://sub.example.com/ATriggerVerify.txt
";
    }
}
