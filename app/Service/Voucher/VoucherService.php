<?php

namespace App\Service\Voucher;


use App\Repositories\Voucher\VoucherRepositoryInterface;
use App\Service\BaseService;

class VoucherService extends BaseService implements VoucherServiceInterface
{
    public $repository;

    public function __construct(VoucherRepositoryInterface $VoucherRepository)
    {
        $this->repository = $VoucherRepository;
    }
}
