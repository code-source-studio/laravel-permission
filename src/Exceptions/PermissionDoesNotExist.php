<?php

namespace CodeSourceStudio\LaravelPermission\Exceptions;

use InvalidArgumentException;

class PermissionDoesNotExist extends InvalidArgumentException
{
    public static function create(string $permissionName): self
    {
        return new self("Permission '{$permissionName}' does not exist.");
    }
}
