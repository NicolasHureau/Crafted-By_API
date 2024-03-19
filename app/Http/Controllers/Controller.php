<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(title="Crafted By API", version="0.1")
 * @OA\SecurityScheme(
 *       securityScheme="sanctum",
 *       type="http",
 *       scheme="sanctum"
 *  )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
