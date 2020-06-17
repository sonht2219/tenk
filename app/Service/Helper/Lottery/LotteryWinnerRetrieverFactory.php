<?php


namespace App\Service\Helper\Lottery;


class LotteryWinnerRetrieverFactory
{
    private static array $_mapper = [
        LotteryWinnerRetrieverType::PROD => LotteryWinnerByTimesRetriever::class,
        LotteryWinnerRetrieverType::MOCK => LotteryWinnerMockRetriever::class
    ];

    public static function getRetriever(int $type): ?LotteryWinnerRetriever {
        if (array_key_exists($type, self::$_mapper)) {
            return (app()->make(self::$_mapper[$type]));
        }
        return null;
    }
}
