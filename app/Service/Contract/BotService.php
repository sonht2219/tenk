<?php


namespace App\Service\Contract;


use App\Http\Requests\BotRequest;
use App\Models\Bot;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface BotService
{
    /**
     * @param BotRequest|Bot $data
     * @return Bot
     */
    public function create($data);

    /**
     * @param $limit
     * @param $search
     * @return LengthAwarePaginator
     */
    public function list($limit, $search);

    /**
     * @param $id
     * @return Bot
     * @throws ModelNotFoundException
     */
    public function single($id): Bot;

    /**
     * @param $id
     * @param BotRequest $req
     * @return Bot
     * @throws ModelNotFoundException
     */
    public function edit($id, BotRequest $req): Bot;

    /**
     * @param $id
     * @return Bot
     * @throws ModelNotFoundException
     */
    public function delete($id);
}
