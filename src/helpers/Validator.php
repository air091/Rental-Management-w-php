<?php

class Validator
{
  public static function required(array $data, array $fields)
  {
    foreach ($fields as $field) {
      if (empty($data[$field])) {
        throw new Exception("$field is required");
      }
    }
  }
}
