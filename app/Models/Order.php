<?php

namespace App\Models;

use App\Utilities\Constant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucher_id', 'id');
    }
    // public function getTotalAttribute()
    // {
    //     // Kiểm tra xem orderDetails đã được tải chưa. Nếu chưa, tải nó.
    //     if (!$this->relationLoaded('orderDetails')) {
    //          $this->load('orderDetails');
    //     }
        
    //     // Trả về tổng cột 'total' từ các chi tiết đơn hàng
    //     return $this->orderDetails->sum('total');
    // }
    public function getStatusTextAttribute()
    {
        return Constant::$order_status[$this->status] ?? 'Không xác định';
    }

    public function getStatusBadgeClassAttribute()
    {
        switch ($this->status) {
            case Constant::order_status_Unconfirmed:
                return 'bg-warning';

            case Constant::order_status_Confirmed:
                return 'bg-info';

            case Constant::order_status_Paid:
                return 'bg-primary';

            case Constant::order_status_Processing:
                return 'bg-secondary';

            case Constant::order_status_Shipping:
                return 'bg-dark';

            case Constant::order_status_Finished:
                return 'bg-success';

            case Constant::order_status_Canceled:
                return 'bg-danger';

            default:
                return 'bg-light text-dark';
        }
    }

}
