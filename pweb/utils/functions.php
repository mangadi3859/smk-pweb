<?php

function generateToken(int $userid, int $length): string
{
    $bytes = random_bytes($length);
    $user = str_replace("=", "", base64_encode(dechex($userid)));

    return $user . "." . base64_encode($bytes);
}


function generateBreadcrumb(string $path)
{
    $routes = array_slice(explode("/", $path), 2);
    $res = "<link rel='stylesheet' href='/smk/pweb/css/breadcrumb.css' /><div class='breadcrumb'>";

    foreach ($routes as $i => $route) {
        if ($i == sizeof($routes) - 1) {
            $res .= "<span class='breadcrumb-item'>$route</span>";
            continue;
        }

        $link = str_repeat("../", sizeof($routes) - 1 - $i) . $route;
        $res .= "<a href='$link' class='breadcrumb-item'>$route</a>";
        $res .= "<span class='breadcrumb-item breadcrumb-slash'>/</span>";
    }

    $res .= "</div>";

    return $res;
}


