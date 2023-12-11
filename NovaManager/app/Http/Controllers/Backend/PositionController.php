<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function getPosition($id = null){
        if(empty($id)){
            $positions = Position::all();
        } else {
            $positions = Position::where('pos_id', $id)->first();
        }
        return $positions;
    }
}
