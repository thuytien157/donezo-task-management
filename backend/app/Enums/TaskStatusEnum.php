<?php
namespace App\Enums;
enum TaskStatusEnum : string{
    case VIEC_CAN_LAM = 'Việc cần làm';
    case PHAN_TICH = 'Phân tích';
    case THUC_HIEN = 'Thực hiện';
    case KIEM_THU = 'Kiểm thử';
    case HOAN_TAT = 'Hoàn tất';
    case HUY_BO = 'Hủy bỏ';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
