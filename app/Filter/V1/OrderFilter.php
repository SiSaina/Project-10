<?php
namespace App\Filter\V1;

use App\Filter\ApiFilter;

class OrderFilter extends ApiFilter
{
    protected $safeParms = [
        'productId' => ['eq'],
        'quantity' => ['eq', 'lt', 'lte', 'gt', 'gte']
    ];

    protected $columnMap = [
        'productId' => 'product_id'
    ];
}

?>