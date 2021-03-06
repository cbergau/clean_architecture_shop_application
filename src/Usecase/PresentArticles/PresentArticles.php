<?php

namespace Bws\Usecase\PresentArticles;

use Bws\Entity\Article;
use Bws\Repository\ArticleRepositoryInterface;

class PresentArticles
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
     * @return PresentArticlesResponse
     */
    public function execute()
    {
        $articles = array();

        $articlesFromRepository = $this->articleRepository->findAll();

        if (!empty($articlesFromRepository)) {
            $articles = $this->buildDto($articlesFromRepository, $articles);
        }

        return new PresentArticlesResponse($articles);
    }

    /**
     * @param Article[] $articlesFromRepository
     * @param array $articles
     *
     * @return array
     */
    protected function buildDto(array $articlesFromRepository, array $articles)
    {
        /** @var Article $article */
        foreach ($articlesFromRepository as $article) {
            $articles[] = array(
                'id'          => $article->getId(),
                'ean'         => $article->getEan(),
                'title'       => $article->getTitle(),
                'description' => $article->getDescription(),
                'price'       => $article->getPrice(),
                'imagePath'   => $article->getImagePath(),
            );
        }

        return $articles;
    }
}
