<?php

namespace Bws\Usecase\PresentArticles;

class PresentArticlesResponse
{
    /**
     * @var array
     */
    private $articles;

    /**
     * @param array $articles
     */
    public function __construct($articles)
    {
        $this->articles = $articles;
    }

    /**
     * @return array
     */
    public function getArticles()
    {
        return $this->articles;
    }
}
