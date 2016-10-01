<?php

namespace Bws\Usecase\SearchArticles;

use Bws\Repository\ArticleRepository;

class SearchArticles
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param SearchArticlesRequest $request
     *
     * @return SearchArticlesResponse
     */
    public function execute(SearchArticlesRequest $request)
    {
        $articles = array();

        foreach ($this->articleRepository->search($request->getBy()) as $article) {
            $articles[] = array(
                'id'          => $article->getId(),
                'ean'         => $article->getEan(),
                'title'       => $article->getTitle(),
                'description' => $article->getDescription(),
                'price'       => $article->getPrice(),
                'imagePath'   => $article->getImagePath(),
            );
        }

        return new SearchArticlesResponse($articles);
    }
}
