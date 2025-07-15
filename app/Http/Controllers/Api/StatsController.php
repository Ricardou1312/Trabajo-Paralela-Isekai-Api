<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{

    /**
 * Convierte un código textual (HU, M, etc.) a su ID numérico.
 * Si ya es numérico, lo devuelve tal cual.
 * Si no existe el código, retorna null.
 */
private function resolveCodeToId(string|int|null $value, string $table): ?int
{
    if (is_null($value)) {
        return null;
    }

    // Si es numérico (solo dígitos), úsalo directo
    if (ctype_digit((string) $value)) {
        return (int) $value;
    }

    // Buscar en la tabla de referencia
    $row = \DB::table("isekai.$table")
        ->where('code', $value)
        ->select('pk')          // asumiendo que la PK se llama pk
        ->first();

    return $row?->pk;
}
      /**
 * @OA\Get(
 *     path="/api/v1/stats/count",
 *     summary="Obtener conteo y porcentaje de personas según filtros",
 *     tags={"Stats"},
 *     @OA\Parameter(
 *         name="speciesCode",
 *         in="query",
 *         description="ID de la especie (species_fk)",
 *         required=false,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Parameter(
 *         name="strataCode",
 *         in="query",
 *         description="ID del estrato (strata_fk)",
 *         required=false,
 *         @OA\Schema(type="integer", example=3)
 *     ),
 *     @OA\Parameter(
 *         name="genderCode",
 *         in="query",
 *         description="ID del género (gender_fk)",
 *         required=false,
 *         @OA\Schema(type="integer", example=2)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Estadística de conteo obtenida exitosamente",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="count", type="integer", example=42),
 *             @OA\Property(property="percentage", type="number", format="float", example=12.5)
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No hay datos disponibles para los filtros proporcionados",
 *         @OA\MediaType(
 *             mediaType="application/problem+json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(property="type", type="string", example="https://example.com/"),
 *                 @OA\Property(property="title", type="string", example="string"),
 *                 @OA\Property(property="status", type="integer", example=404),
 *                 @OA\Property(property="detail", type="string", example="string"),
 *                 @OA\Property(property="instance", type="string", example="https://example.com/"),
 *                 @OA\Property(
 *                     property="properties",
 *                     type="object",
 *                     additionalProperties={"type": "string"},
 *                     example={
 *                         "additionalProp1": "string",
 *                         "additionalProp2": "string",
 *                         "additionalProp3": "string"
 *                     }
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error interno no manejado",
 *         @OA\MediaType(
 *             mediaType="application/problem+json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(property="type", type="string", example="https://example.com/"),
 *                 @OA\Property(property="title", type="string", example="string"),
 *                 @OA\Property(property="status", type="integer", example=500),
 *                 @OA\Property(property="detail", type="string", example="string"),
 *                 @OA\Property(property="instance", type="string", example="https://example.com/"),
 *                 @OA\Property(
 *                     property="properties",
 *                     type="object",
 *                     additionalProperties={"type": "string"},
 *                     example={
 *                         "additionalProp1": "string",
 *                         "additionalProp2": "string",
 *                         "additionalProp3": "string"
 *                     }
 *                 )
 *             )
 *         )
 *     )
 * )
 */


    public function count(Request $request): JsonResponse
    {
        $speciesId = $this->resolveCodeToId($request->query('speciesCode'), 'species');
        $strataId  = $this->resolveCodeToId($request->query('strataCode'),  'strata');
        $genderId  = $this->resolveCodeToId($request->query('genderCode'),  'genders');
  
        // Validar que al menos uno esté presente
        if (is_null($speciesId) && is_null($strataId) && is_null($genderId)) {
            return response()->json([
                'type' => 'https://example.com/',
                'title' => 'Parámetros inválidos',
                'status' => 400,
                'detail' => 'Debes especificar al menos un filtro: speciesCode, strataCode o genderCode',
                'instance' => 'https://example.com/',
                'properties' => []
            ], 400);
        }

        // Armar consulta filtrada
        $query = Person::query();

       if ($speciesId) $query->where('species_fk', $speciesId);
       if ($strataId)  $query->where('strata_fk',  $strataId);
       if ($genderId)  $query->where('gender_fk',  $genderId);

        $filteredCount = $query->count();

        if ($filteredCount === 0) {
            return response()->json([
                'type' => 'https://example.com/',
                'title' => 'Sin resultados',
                'status' => 404,
                'detail' => 'No hay datos para los filtros proporcionados',
                'instance' => 'https://example.com/',
                'properties' => []
            ], 404);
        }

        $totalCount = Person::count();
        $percentage = $totalCount > 0
            ? round(($filteredCount / $totalCount) * 100, 2)
            : 0.0;

        return response()->json([
            'count' => $filteredCount,
            'percentage' => $percentage
        ], 200);
    }
    /**
 * @OA\Get(
 *     path="/api/v1/stats/age",
 *     summary="Obtener estadísticas de edad (mínimo, máximo, promedio, desviación estándar)",
 *     tags={"Stats"},
 *     @OA\Parameter(
 *         name="speciesCode",
 *         in="query",
 *         description="ID de la especie (species_fk)",
 *         required=false,
 *         @OA\Schema(type="string", example="HU")
 *     ),
 *     @OA\Parameter(
 *         name="strataCode",
 *         in="query",
 *         description="ID del estrato (strata_fk)",
 *         required=false,
 *         @OA\Schema(type="string", example=5)
 *     ),
 *     @OA\Parameter(
 *         name="genderCode",
 *         in="query",
 *         description="ID del género (gender_fk)",
 *         required=false,
 *         @OA\Schema(type="string", example="M")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Estadística de edad obtenida exitosamente",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="min", type="integer", example=18),
 *             @OA\Property(property="max", type="integer", example=99),
 *             @OA\Property(property="mean", type="number", format="float", example=45.35),
 *             @OA\Property(property="stddev", type="number", format="float", example=12.75)
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No hay datos disponibles para los filtros proporcionados",
 *         @OA\MediaType(
 *             mediaType="application/problem+json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(property="type", type="string", example="https://example.com/"),
 *                 @OA\Property(property="title", type="string", example="string"),
 *                 @OA\Property(property="status", type="integer", example=404),
 *                 @OA\Property(property="detail", type="string", example="string"),
 *                 @OA\Property(property="instance", type="string", example="https://example.com/"),
 *                 @OA\Property(
 *                     property="properties",
 *                     type="object",
 *                     additionalProperties={"type": "string"},
 *                     example={
 *                         "additionalProp1": "string",
 *                         "additionalProp2": "string",
 *                         "additionalProp3": "string"
 *                     }
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error interno no manejado",
 *         @OA\MediaType(
 *             mediaType="application/problem+json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(property="type", type="string", example="https://example.com/"),
 *                 @OA\Property(property="title", type="string", example="string"),
 *                 @OA\Property(property="status", type="integer", example=500),
 *                 @OA\Property(property="detail", type="string", example="string"),
 *                 @OA\Property(property="instance", type="string", example="https://example.com/"),
 *                 @OA\Property(
 *                     property="properties",
 *                     type="object",
 *                     additionalProperties={"type": "string"},
 *                     example={
 *                         "additionalProp1": "string",
 *                         "additionalProp2": "string",
 *                         "additionalProp3": "string"
 *                     }
 *                 )
 *             )
 *         )
 *     )
 * )
 */


    public function age(Request $request): JsonResponse
{
    $speciesId = $this->resolveCodeToId($request->query('speciesCode'), 'species');
    $strataId  = $this->resolveCodeToId($request->query('strataCode'),  'strata');
    $genderId  = $this->resolveCodeToId($request->query('genderCode'),  'genders');

    if (is_null($speciesId) && is_null($strataId) && is_null($genderId)) {
        return response()->json([
            'type' => 'https://example.com/',
            'title' => 'Parámetros inválidos',
            'status' => 400,
            'detail' => 'Debes especificar al menos un filtro: speciesCode, strataCode o genderCode',
            'instance' => 'https://example.com/',
            'properties' => []
        ], 400);
    }

    if ($speciesId) { $where[] = 'species_fk = ?'; $bindings[] = $speciesId; }
    if ($strataId)  { $where[] = 'strata_fk  = ?'; $bindings[] = $strataId; }
    if ($genderId)  { $where[] = 'gender_fk  = ?'; $bindings[] = $genderId; }

    // Armar WHERE dinámico
    $where = [];
    $bindings = [];

    if ($speciesId) { $where[] = 'species_fk = ?'; $bindings[] = $speciesId; }
    if ($strataId)  { $where[] = 'strata_fk  = ?'; $bindings[] = $strataId; }
    if ($genderId)  { $where[] = 'gender_fk  = ?'; $bindings[] = $genderId; }

    $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

    // Ejecutar agregados en PostgreSQL
    $query = <<<SQL
        SELECT 
            MIN(EXTRACT(YEAR FROM AGE(NOW(), birthdate))) AS min,
            MAX(EXTRACT(YEAR FROM AGE(NOW(), birthdate))) AS max,
            ROUND(AVG(EXTRACT(YEAR FROM AGE(NOW(), birthdate)))::numeric, 2) AS mean,
            ROUND(STDDEV(EXTRACT(YEAR FROM AGE(NOW(), birthdate)))::numeric, 2) AS stddev
        FROM isekai.persons
        $whereSql
    SQL;

    $result = DB::selectOne($query, $bindings);

    if (!$result || $result->min === null) {
        return response()->json([
            'type' => 'https://example.com/',
            'title' => 'Sin resultados',
            'status' => 404,
            'detail' => 'No hay datos disponibles para los filtros proporcionados',
            'instance' => 'https://example.com/',
            'properties' => []
        ], 404);
    }

    return response()->json([
        'min'     => (int) $result->min,
        'max'     => (int) $result->max,
        'mean'    => (float) $result->mean,
        'stddev'  => (float) $result->stddev,
    ], 200);
}


}
