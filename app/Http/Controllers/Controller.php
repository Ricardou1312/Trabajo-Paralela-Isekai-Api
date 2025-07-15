<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="API Isekai",
 *     version="1.0.0",
 *     description="Servicio REST que expone información de un mundo isekai ficticio."
 * )
 * 
 * @OA\Tag(
 *     name="Info",
 *     description="Información base. Proporciona listas de especies, estratos sociales y géneros."
 * )
 *
 * @OA\Tag(
 *     name="Stats",
 *     description="Proporciona estadísticas calculadas sobre las personas, como distribución de edades y conteo por filtros."
 * )
 */

abstract class Controller
{
    //
}
