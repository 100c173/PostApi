<?php

namespace App\Filters;

use Illuminate\Http\Request;

class PostFilter
{
    protected $request ; 
    /**
     * Create a new class instance.
     */
    public function __construct(Request $request)
    {
        $this->request = $request ;
    }

    public function apply($query){

        // Filter only published posts
        if ($this->request->boolean('published_only')) {
            $query->where('is_published', true);
        }

        //Filter by tag
        if ($tag = $this->request->get('tag')) {
            $query->whereJsonContains('tags', $tag);
        }

        //Filter by publication date (from)
        if ($from = $this->request->get('publish_date_from')) {
            $query->whereDate('publish_date', '>=', $from);
        }

        //Filter by publication date (to)
        if ($to = $this->request->get('publish_date_to')) {
            $query->whereDate('publish_date', '<=', $to);
        }

        return $query;

    }
}
