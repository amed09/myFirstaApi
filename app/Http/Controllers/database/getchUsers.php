<?php

namespace App\Http\Controllers\database;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as myDataBase;
 
class getchUsers extends Controller
{
   public  function  fetchUserFromDataBase(){

      return myDataBase::table('users')->select('id','name','email')->get();
   }
}
