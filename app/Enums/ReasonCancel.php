<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ReasonCancel extends Enum
{
    const OptionOne = 'Ordered the wrong service/clinic';// Đặt nhầm dịch vụ/phòng khám
    const OptionTwo = 'The distance is too far';// Khoảng cách quá xa
    const OptionThree = 'Treatment costs are too high';// Chi phí khám chữa quá cao
    const OptionFour = 'Already booking';// Đã đặt lịch rồi
    const OptionFive = 'Distrust';// Không tin tưởng
    const OptionSix = 'Have been examined here before';// Đã từng khám tại đây
    const OptionEight = 'Not enough services provided';// Không đủ dịch vụ cung cấp
    const OptionNine = 'Waited too long';// Chờ quá lâu
    /* Never edit the key or value of OptionSeven below */
    const OptionSeven = 'Other'; // Khác
}
