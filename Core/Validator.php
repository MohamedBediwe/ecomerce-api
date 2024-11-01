<?php

namespace Core;

class Validator
{
  public static function string($value, $min = 0, $max = INF)
  {
    $value = filter_var(trim($value), FILTER_SANITIZE_SPECIAL_CHARS);
    return (strlen($value) >= $min) && (strlen($value) <= $max);
  }
  public static function email($value)
  {
    return filter_var($value, FILTER_VALIDATE_EMAIL);
  }
}
