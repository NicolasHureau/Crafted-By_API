<?php

namespace App\Http\Controllers;

use App\Http\Resources\FilterResource;
use App\Models\Category;
use App\Models\Color;
use App\Models\Material;
use App\Models\Size;
use App\Models\Style;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FiltersController extends Controller
{

    public function index(): JsonResponse
    {
        $filters = [];

        $filters['colors']      = Color::all('id', 'name as value');
        $filters['styles']      = Style::all('id', 'name as value');
        $filters['materials']   = Material::all('id', 'name as value');
        $filters['categories']  = Category::all('id', 'name as value');
        $filters['heights']     = Size::all('id', 'height as value');
        $filters['widths']      = Size::all('id', 'width as value');
        $filters['depths']      = Size::all('id', 'depth as value');

        return response()->json($filters);
    }
}
