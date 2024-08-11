<?php

namespace lucidtaz\yii2scssphp\storage;

use RuntimeException;

class FsStorage implements Storage
{
    public function exists(string $filename): bool
    {
        return file_exists($filename);
    }

    public function get(string $filename): string
    {
        $contents = file_get_contents($filename);
        if ($contents === false) {
            throw new RuntimeException('Could not read ' . $filename);
        }
        return $contents;
    }

    public function put(string $filename, string $contents): bool
    {
        if (!is_dir(dirname($filename))) {
            mkdir(dirname($filename), 0777, true);
        }
        return file_put_contents($filename, $contents) !== false;
    }

    public function remove(string $filename): bool
    {
        return @unlink($filename);
    }

    public function touch(string $filename, int $mtime): bool
    {
        return touch($filename, $mtime);
    }

    public function getMtime(string $filename): int
    {
        $mtime = @filemtime($filename);
        if ($mtime === false) {
            throw new RuntimeException('Could not determine mtime for ' . $filename);
            // ... or should we adhere to PHP's int|false convention?
        }
        return $mtime;
    }
}
