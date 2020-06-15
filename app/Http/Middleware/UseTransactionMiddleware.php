<?php


namespace App\Http\Middleware;


use Closure;
use DB;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class UseTransactionMiddleware
{
    /**
     * @param Request $req
     * @param Closure $next
     * @throws Throwable
     * @return mixed
     */
    public function handle($req, Closure $next)
    {
        DB::beginTransaction();
        try {
            $result = $next($req);
            DB::commit();
            return $result;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
