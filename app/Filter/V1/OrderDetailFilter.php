<?php
namespace App\Filter\V1;

use App\Filter\ApiFilter;

class OrderDetailFilter extends ApiFilter
{
    protected $safeParms = [
        'orderId' => ['eq'],
        'userId' => ['eq'],
        'addressId' => ['eq'],
        'status' => ['eq'],
        'date' => ['eq', 'lt', 'lte', 'gt', 'gte']
    ];

    protected $columnMap = [
        'userId' => 'user_id',
        'orderId' => 'order_id',
        'addressId' => 'address_id',
    ];
}

?>