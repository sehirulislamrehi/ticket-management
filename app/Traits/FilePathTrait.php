<?php

namespace App\Traits;

trait FilePathTrait
{

  protected function get_file_path($type)
  {
    if ($type === "complaint") {
      return "complaints";
    }
  }
}
