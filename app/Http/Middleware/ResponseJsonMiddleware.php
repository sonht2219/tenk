<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class ResponseJsonMiddleware
{
    public function handle($req, Closure $next)
    {
        /** @var Response $controllerResponse */
        $controllerResponse = $next($req);
        $data = $controllerResponse->original;
        if (!in_array($controllerResponse->status(), [200, 201]))
            return $controllerResponse;
        if ($controllerResponse instanceof JsonResponse) {
            if (is_array($data) || $data instanceof Collection || $data instanceof Model) {
                $is_multi = false;
                $meta = null;
                if (is_sequential_array($data) || $data instanceof Collection) {
                    $is_multi = true;
                } elseif (is_array($data)) {
                    $has_data = array_key_exists('data', $data);
                    $has_datas = array_key_exists('datas', $data);

                    if (array_key_exists('message', $data) && array_key_exists('status', $data))
                        return response()->json($data);

                    if (array_key_exists('meta', $data))
                        $meta = $data['meta'];

                    $data = $has_datas
                        ? $data['datas']
                        : ($has_data
                            ? $data['data']
                            : $data);
                    $is_multi = $has_datas;
                }
                return restful_success($data, $is_multi, $meta);
            }
        }

        return $controllerResponse;
    }
}
