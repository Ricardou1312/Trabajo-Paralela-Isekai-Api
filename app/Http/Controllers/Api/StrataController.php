<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stratum;
use Illuminate\Http\JsonResponse;

class StrataController extends Controller
{
    /**
 * @OA\Get(
 *     path="/api/v1/info/strata",
 *     summary="Obtener listado de estratos",
 *     tags={"Info"},
 *     @OA\Response(
 *         response=200,
 *         description="Listado de estratos obtenido exitosamente",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="code", type="string", example="001"),
 *                 @OA\Property(property="name", type="string", example="Estrato Alto")
 *             )
 *         )
 *     ),
 *      @OA\Response(
 *    response=404,
 *   description="No hay información de estratos disponible",
 *  @OA\MediaType(
 *       mediaType="application/problem+json",
 *      @OA\Schema(
 *           type="object",
 *           @OA\Property(property="type", type="string", example="https://example.com/"),
 *            @OA\Property(property="title", type="string", example="string"),
 *            @OA\Property(property="status", type="integer", example=404),
 *            @OA\Property(property="detail", type="string", example="string"),
 *            @OA\Property(property="instance", type="string", example="https://example.com/"),
 *            @OA\Property(
 *                property="properties",
 *                type="object",
 *                additionalProperties={"type": "string"},
 *                example={
 *                    "additionalProp1": "string",
 *                    "additionalProp2": "string",
 *                    "additionalProp3": "string"
 *                }
 *            )
 *        )
 *    )
 *),
 *@OA\Response(
 *    response=500,
 *    description="Error interno no manejado",
 *    @OA\MediaType(
 *        mediaType="application/problem+json",
 *        @OA\Schema(
 *            type="object",
 *            @OA\Property(property="type", type="string", example="https://example.com/"),
 *            @OA\Property(property="title", type="string", example="string"),
 *            @OA\Property(property="status", type="integer", example=500),
 *            @OA\Property(property="detail", type="string", example="string"),
 *            @OA\Property(property="instance", type="string", example="https://example.com/"),
 *            @OA\Property(
 *                property="properties",
 *                type="object",
 *                additionalProperties={"type": "string"},
 *                example={
 *                    "additionalProp1": "string",
 *                    "additionalProp2": "string",
 *                    "additionalProp3": "string"
 *                }
 *            )
 *        )
 *    )
 *)
  * )
  */
    public function index(): JsonResponse
    {
        $strata = Stratum::select('code', 'name')->get();

        if ($strata->isEmpty()) {
            return response()->json([
                'type' => 'https://example.com/',
                'title' => 'No Content',
                'status' => 404,
                'detail' => 'No hay información de estratos disponible',
                'instance' => 'https://example.com/',
                'properties' => []
            ], 404);
        }

        return response()->json($strata, 200);
    }
}
