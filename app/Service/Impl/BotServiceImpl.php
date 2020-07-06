<?php


namespace App\Service\Impl;


use App\Enum\Status\CommonStatus;
use App\Exceptions\ExecuteException;
use App\Http\Requests\BotRequest;
use App\Models\Bot;
use App\Repositories\Contract\BotRepository;
use App\Repositories\Criteria\Bot\BotSearchCriteria;
use App\Repositories\Criteria\Common\HasStatusCriteria;
use App\Repositories\Criteria\Common\LimitRecordCriteria;
use App\Repositories\Criteria\Common\OrderRandomCriteria;
use App\Repositories\Criteria\Common\WithRelationsCriteria;
use App\Service\Contract\BotService;

class BotServiceImpl implements BotService
{
    private BotRepository $botRepo;

    public function __construct(BotRepository $botRepo)
    {
        $this->botRepo = $botRepo;
    }

    public function create($data)
    {
        if ($this->botRepo->exists(['user_id' => $data->user_id, 'status' => CommonStatus::ACTIVE])) {
            throw new ExecuteException(__('Tài khoản này là bot và đang hoạt động, không thể tiếp tục tạo'));
        }
        if ($data instanceof BotRequest)
            $data = new Bot($data->filteredData());

        return $this->botRepo->save($data);
    }

    public function list($limit, $search)
    {
        if ($search)
            $this->botRepo->pushCriteria(new BotSearchCriteria($search));
        $this->botRepo->pushCriteria([
            new WithRelationsCriteria(['user']),
            HasStatusCriteria::class,
        ]);

        return $this->botRepo->paginate($limit);
    }

    public function single($id): Bot
    {
        $this->botRepo->pushCriteria(new WithRelationsCriteria(['user']));
        return $this->botRepo->find($id);
    }

    public function edit($id, BotRequest $req): Bot
    {
        return $this->botRepo->update($req->filteredData(), $id);
    }

    public function delete($id)
    {
        $bot = $this->single($id);
        $bot->status = CommonStatus::INACTIVE;

        return $this->botRepo->save($bot);
    }

    public function findRandomBots($limit)
    {
        $this->botRepo->pushCriteria([
            new WithRelationsCriteria('user'),
            OrderRandomCriteria::class,
            new LimitRecordCriteria($limit),
        ]);

        return $this->botRepo->all();
    }
}
