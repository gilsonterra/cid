<?php

namespace App\Repositories;

use App\Models\Local;

use Illuminate\Pagination\AbstractPaginator as Paginator;

abstract class BaseRepository
{
    const ERROR = 'error';
    const WARNING = 'warning';
    const SUCCESS = 'success';
    const INFO = 'primary';
    const ITEMS_PER_PAGE = 10;

    public function paginate($query, $page = 1)
    {
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        return $query->paginate(self::ITEMS_PER_PAGE);
    }

    public function createMessage($text, $title = '', $type = self::INFO, $data = array())
    {
        $return = [
            'text'  => $text,
            'title' => $title,
            'type'  => $type
        ];


        if(!empty($data)){
            $return['data'] = $data;
        }

        return $return;
    }
}
