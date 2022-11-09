<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;


class Post
{
    public $slug;
    public $title;
    public $excerpt;
    public $date;
    public $body;

    /**
     * __construct
     *
     * @param  string $slug
     * @param  string $title
     * @param  string $excerpt
     * @param  string $date
     * @param  string $body
     * @return object
     */
    public function __construct(string $slug, string $title, string $excerpt, string $date, string $body)
    {
        $this->slug = $slug;
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->date = $date;
        $this->body = $body;
    }

    /**
     * find
     *
     * Collect all blog posts.
     * Find the first post slug that matches $slug.
     * Return matching post as an object.
     *
     * @param  string $slug
     * @return object
     */
    public static function find(string $slug)
    {
        return static::all()->firstWhere('slug', $slug);
    }

    /**
     * all
     *
     * Scan /posts/ directory in /resources/ and return data of all
     * files as a Post object.
     * Query is cachecd forever.
     * In order to update query, the cache must be clear programatically,
     * e.g. after a new post is created.
     *
     * @return object
     */
    public static function all()
    {
        return cache()->rememberForever('posts.all', function () {
            // Find all the files in the files collection
            return collect($files = File::files(resource_path('posts')))
            // Loop over and convert each file into a YAML parsed document
            ->map(fn($file) => YamlFrontMatter::parseFile($file))
            // Loop over documents collection and create new Post with document data
            ->map(fn($document) => new Post(
                    $document->slug,
                    $document->title,
                    $document->excerpt,
                    $document->date,
                    $document->body()
                )
            )
            // Sort by date in descending order
            ->sortByDesc('date');
        });
    }
}
