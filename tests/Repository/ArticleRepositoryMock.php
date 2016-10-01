<?php

namespace Bws\Repository;

use Bws\Entity\Article;

class ArticleRepositoryMock extends InMemoryRepository implements ArticleRepository
{
    /**
     * @var int
     */
    private $searchCallCount = 0;

    /**
     * @var int
     */
    private $findById;

    /**
     * @param int $id
     *
     * @return Article
     */
    public function find($id)
    {
        return parent::find($id);
    }

    /**
     * @param Article $article
     */
    public function save(Article $article)
    {
        $this->doSave($article);
    }

    /**
     * @return Article
     */
    public function factory()
    {
        return new Article();
    }

    /**
     * @return int
     */
    public function getFindByIdArgument()
    {
        return $this->findById;
    }

    /**
     * @return Article[]
     */
    public function findAll()
    {
        return $this->getEntities();
    }

    /**
     * @param string $by
     *
     * @return Article[]
     */
    public function search($by)
    {
        $this->searchCallCount++;
        $articles = array();

        /** @var Article $article */
        foreach ($this->getEntities() as $article) {
            if (false !== strpos($article->getTitle(), $by)) {
                $articles[] = $article;
            }
        }

        return $articles;
    }

    /**
     * @return int
     */
    public function getSearchCallCount()
    {
        return $this->searchCallCount;
    }
}
