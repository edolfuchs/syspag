<?php

namespace App\Traits;

trait FilterTrait
{
    public function getRequest()
    {
        return request();
    }

    public function getBusca()
    {
        $busca = request()->input('busca');

        return [
            'page' => (isset($busca['page']) ? $busca['page'] : 1),
            'search' => (isset($busca['search']) ? $busca['search'] : null),
            'pagination' => (isset($busca['pagination']) ? intval($busca['pagination']) : 50),
            'orderBy' => (isset($busca['orderBy']) ? $busca['orderBy'] : 'intId'),
            'orderType' => (isset($busca['orderDesc']) ? 'DESC' : 'DESC')
        ];
    }

    public function getTotalPage()
    {
        return $this->getBusca()['pagination'];
    }

    public function getCurrentPage()
    {
        return $this->getBusca()['page'];
    }

    public function getOrderBy()
    {
        return $this->getBusca()['orderBy'];
    }

    public function getOrderType()
    {
        return $this->getBusca()['orderType'];
    }

    public function getSearch($mask = 'null')
    {
        return $this->getBusca()['search'];
    }
}
