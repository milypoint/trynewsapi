<?php


namespace app\newsapi;


class ApiRequestTop extends ApiRequest
{
    private const endpoint = '/v2/top-headlines';

    private const parameters = [
        'country',
        ['category', 'sources'], //один из двух
        'q',
        'pageSize',
        'page'
    ];
}