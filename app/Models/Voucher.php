<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'vouchers';
    protected $primaryKey = 'id';

    // Cho phép mass assignment tất cả các cột
    protected $guarded = [];

    // Nếu bạn muốn khai báo rõ các cột (tùy chọn)
    // protected $fillable = [
    //     'title',
    //     'code',
    //     'type',
    //     'reduce',
    //     'max_discount',
    //     'qty',
    //     'min_total_value',
    //     'start_date',
    //     'end_date',
    // ];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
    ];
    public function getStartDateFormattedAttribute()
    {
        return $this->start_date
            ? $this->start_date->format('d/m/Y')
            : '';
    }

    public function getEndDateFormattedAttribute()
    {
        return $this->end_date
            ? $this->end_date->format('d/m/Y')
            : '';
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'voucher_id', 'id');
    }
}
