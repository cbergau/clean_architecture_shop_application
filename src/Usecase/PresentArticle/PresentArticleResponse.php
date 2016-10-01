<?php

namespace Bws\Usecase\PresentArticle;

use Bws\Entity\Article;

class PresentArticleResponse
{
    const SUCCESS           = 1;
    const ARTICLE_NOT_FOUND = -1;

    /**
     * @var integer
     */
    private $code;

    /**
     * @var Article
     */
    private $article;

    /**
     * @param integer $code
     * @param Article $article
     */
    public function __construct($code, Article $article = null)
    {
        $this->code    = $code;
        $this->article = $article;
    }

    /**
     * @return integer
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return \Bws\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }
}
