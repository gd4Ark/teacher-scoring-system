<?php
function get($url)
{
    $ret = @file_get_contents($url);
    $ret = json_decode($ret, true);
    return $ret['data'];
}

function msg($message)
{
    return "<script>alert('" . $message . "')</script>";
}

function redirect($url)
{
    return "<script>window.location.href = '" . $url . "'</script>";
}
