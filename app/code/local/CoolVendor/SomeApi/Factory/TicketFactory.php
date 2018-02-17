<?php

namespace CoolVendor\SomeApi\Factory;

use CoolVendor\SomeApi\Classes\Ticket;

class TicketFactory
{
    public function create()
    {
        return new Ticket();
    }
}