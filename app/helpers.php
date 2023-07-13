<?php

function price_format($amount)
{
    return '&#8377;'.number_format($amount, 2, ".", ",");
}
?>