<?php

function getTimeZone(): string
{
    date_default_timezone_set('Europe/Bucharest');
    return date('Y/m/d h:i:s', time());
}

function getId($location): mixed
{
    $id = $_GET['id'];
    if (!$id) {
        header("location:$location"); // redirects to all records page
    }
    return $id;
}

function getStatusValue($status, $array): string
{
    foreach ($array as &$value) {
        if ($status === $value) {
            return $status;
        }
    }
    return '';
}

function deleteCurrentStatus($status, $array): array
{
    return array_diff($array, array($status));
}
?>
