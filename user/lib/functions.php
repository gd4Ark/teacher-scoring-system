<?php
function get($url)
{
  $ret = @file_get_contents($url);
  $ret = json_decode($ret, true);
  return isset($ret['data']) ? $ret['data'] : $ret;
}

function getOptions($model, $where = [])
{
  global $base_url;
  $url = $base_url . "options?models[]=$model&" . http_build_query([
    'where' => $where
  ]);
  return get($url)[$model];
}

function msg($message)
{
  return "<script>alert('" . $message . "')</script>";
}

function redirect($url)
{
  return "<script>window.location.href = '" . $url . "'</script>";
}
