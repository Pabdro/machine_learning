<?php

namespace App\Filters;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class BoxFilter extends ApiFilter
{
    protected $safeParams = [
        'name' => ['eq'],
        'description' => ['eq']
    ];
    protected $columnMap = [
        'name' => 'name',
        'description' => 'description'
    ];
    protected $operatorMap = [
        'eq' => '=',
        'neq' => '<>',
        'gt' => '>',
        'gte' => '>=',
        'lt' => '<',
        'lte' => '<='
    ];
}