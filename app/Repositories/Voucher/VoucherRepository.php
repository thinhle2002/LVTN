<?php

namespace App\Repositories\Voucher;

use App\Models\Voucher;
use App\Repositories\BaseRepositories;

class VoucherRepository extends BaseRepositories implements VoucherRepositoryInterface
{
    public function getModel(){
        return Voucher::class;
    }
}
