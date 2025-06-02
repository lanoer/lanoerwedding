<?php

use App\Models\Post;

return [
    'feeds' => [
        'main' => [
            'items' => [Post::class, 'getFeedItems'],
            'url' => '/feed/blog',
            'title' => 'All posts',
            'description' => 'All blog posts',
            'language' => 'id-ID',
            'image' => '',
            'format' => 'rss',
            'view' => 'feed::rss',
            'type' => 'application/rss+xml',
            'contentType' => 'application/rss+xml',
        ]
    ],
];
