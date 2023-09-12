<?php

function generateToken(int $userid, int $length)
{
    $bytes = random_bytes($length);
    $user = str_replace("=", "", base64_encode(dechex($userid)));

    return $user . "." . base64_encode($bytes);
}