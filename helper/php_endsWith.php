<?php

function ends_with($str, $end)
{
    return ( substr( $str, strlen( $str ) - strlen( $end ) ) === $end );
}