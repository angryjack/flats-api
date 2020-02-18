<?php

namespace App\Dto;

use Illuminate\Support\Facades\Log;

/**
 * Фильтр умеющий логировать запросы.
 * @package App\Dto
 */
class LoggerFilter extends Filter
{
    public function __construct(array $data)
    {
        parent::__construct($data);

        //логируем в файл
        //todo также можно логировать куда угодно.
        Log::info(json_encode($data));
    }
}
