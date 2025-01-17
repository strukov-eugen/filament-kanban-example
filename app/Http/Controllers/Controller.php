<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Kanban API",
 *     description="API documentation for the Kanban application",
 *     @OA\Contact(
 *         email="support@kanbanapp.com"
 *     )
 * )
 * 
 * @OA\Server(
 *     url="http://localhost/api",
 *     description="Local development server"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
