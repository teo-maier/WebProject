<?php

enum ProductStatus
{
    case OUT_OF_STOCK;
    case IN_STOCK;
    case RUNNING_LOW;

    public function getValue(): string
    {
        return match ($this) {
            ProductStatus::OUT_OF_STOCK => 'Out of stock',
            ProductStatus::IN_STOCK => 'In stock',
            ProductStatus::RUNNING_LOW => 'Running low',
        };
    }
}

enum OrderStatus
{
    case DELIVERED;
    case PENDING;
    case CANCELLED;
    case DECLINED;
    case REFUNDED;

    public function getValue(): string
    {
        return match ($this) {
            OrderStatus::DELIVERED => 'Delivered',
            OrderStatus::PENDING => 'Pending',
            OrderStatus::CANCELLED => 'Cancelled',
            OrderStatus::DECLINED => 'Declined',
            OrderStatus::REFUNDED => 'Refunded',
        };
    }

}

?>
