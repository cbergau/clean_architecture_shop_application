<?php
/**
 * BWS WebShop
 *
 * @author Christian Bergau <cbergau86@gmail.com>
 */

namespace Bws\Repository;

use Bws\Entity\Article;

interface ArticleRepositoryInterface
{
    /**
     * @param integer $id
     *
     * @return Article
     */
    public function find($id);

    /**
     * @return Article[]
     */
    public function findAll();

    /**
     * @param string $by
     *
     * @return Article[]
     */
    public function search($by);
}
