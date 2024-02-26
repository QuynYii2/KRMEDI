<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderMethod extends Enum
{
    const IMMEDIATE = "Cash on Delivery";
    const ELECTRONIC_WALLET = "E-wallet";
    const CARD_CREDIT = "Debit or Credit Card";
}
