<?php

namespace App\Enums;

enum CardType: string {
    case Debit = "DEBIT";
    case Credit = "CREDIT";
    case Prepaid = "PREPAID";
    case Unknown = "";
}
