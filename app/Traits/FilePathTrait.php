<?php

namespace App\Traits;



trait FilePathTrait
{

  //all are sotrage path
  protected function get_file_path($type)
  {
    if ($type === "profile") {
      return "profile";
    }
    if ($type === "task") {
      return "tasks";
    }
  }
}
