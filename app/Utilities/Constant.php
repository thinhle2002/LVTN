<?php

namespace App\Utilities;

class Constant
{
    // Order Status
    const order_status_ReceivedOrders = 1;
    const order_status_Unconfirmed = 2;
    const order_status_Confirmed = 3;
    const order_status_Paid = 4;
    const order_status_Processing = 5;
    const order_status_Shipping = 6;
    const order_status_Finished = 7;
    const order_status_Canceled = 8;
    
    public static $order_status = [          
            // self::order_status_ReceivedOrders => 'Đơn hàng mới',
            self::order_status_Unconfirmed => 'Chờ xác nhận',
            self::order_status_Confirmed => 'Đã xác nhận',
            self::order_status_Paid => 'Đã thanh toán',
            self::order_status_Processing => 'Đang xử lý',
            self::order_status_Shipping => 'Đang vận chuyển',
            self::order_status_Finished => 'Hoàn thành',
            self::order_status_Canceled => 'Đã hủy',
        ];  

    //Users Level

    const user_level_Admin = 0;
    const user_level_Client = 1;
    public static $user_level = [
        self::user_level_Admin => 'Quản trị viên',
        self::user_level_Client => 'Người dùng',
    ];
}