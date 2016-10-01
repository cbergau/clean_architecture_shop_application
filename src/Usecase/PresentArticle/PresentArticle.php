<?php

namespace Bws\Usecase\PresentArticle;

use Bws\Repository\ArticleRepositoryInterface;

class PresentArticle
{
    /**
     * @var \Bws\Repository\ArticleRepositoryInterface
     */
    private $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param int $articleId
     *
     * @return PresentArticleResponse
     */
    public function execute($articleId)
    {
        if (!$article = $this->articleRepository->find($articleId)) {
            return new PresentArticleResponse(PresentArticleResponse::ARTICLE_NOT_FOUND);
        }

        return new PresentArticleResponse(PresentArticleResponse::SUCCESS, $article);
    }
}
