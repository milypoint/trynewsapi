<?php
namespace app\newsapi;

class ApiRequestEverything extends ApiRequest
/*
 * https://newsapi.org/docs/endpoints/everything
 */
{
    protected $_endpoint = '/v2/everything';

    protected $_request_parameters = [
        'q',
        'qInTitle',
        'sources',
        'domains',
        'from',
        'to',
        'language',
        'sortBy',
        'pageSize',
        'page'
    ];

    public function rules()
	{
		return [
			'language' => function ($value) {
				return (in_array($value,
					['ar', 'de', 'en', 'es', 'fr', 'he', 'it', 'nl', 'no', 'pt', 'ru', 'se', 'ud', 'zh']
				));
			},
		];
	}

}