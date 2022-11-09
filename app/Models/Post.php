<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;

class Post
{
    /**
     * find
     *
     * Cache post for specified time.
     * Arrow callback functions automatically allow for variables outside of
     * closure to be used
     * @param  string $slug
     * @return void
     */
    public static function find(string $slug)
    {
        // Uses resource_path() helper function to get path to /resources/
        $path = resource_path("posts/{$slug}.html");

        if (!file_exists($path)) {
            throw new ModelNotFoundException();
        }

        return cache()->remember("posts.{$slug}", 600, fn() => file_get_contents($path));
    }

    /**
     * all
     *
     * Scan /posts/ directory in /resources/ and return files
     *
     * @return void
     */
    public static function all()
    {
        $files = File::files(resource_path("posts/"));

        return array_map(fn($file) => $file->getContents(), $files);
    }
}
