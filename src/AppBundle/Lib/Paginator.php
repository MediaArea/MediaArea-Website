<?php

namespace AppBundle\Lib;

class Paginator
{
    protected $items;
    protected $itemsPerPage;
    protected $itemRoute;
    protected $itemRoutePageOne;
    protected $currentPage;
    protected $pagesToShow;
    protected $totalPages;
    protected $pageRouteParams = [];

    /**
     * @param int    $items            Total number of items
     * @param int    $itemsPerPage     Number of items per page
     * @param string $itemRoute        Route for a page with pagination
     * @param string $itemRoutePageOne Route for page one
     * @param int    $currentPage      Current page
     * @param int    $pagesToShow      Number of pages to show
     */
    public function __construct($items, $itemsPerPage, $itemRoute, $itemRoutePageOne, $currentPage, $pagesToShow = 10)
    {
        $this->items = $items;
        $this->itemsPerPage = $itemsPerPage;
        $this->itemRoute = $itemRoute;
        $this->itemRoutePageOne = $itemRoutePageOne;
        $this->currentPage = $currentPage;
        $this->pagesToShow = $pagesToShow;

        $this->setTotalPages();
    }

    /**
     * Set the total number of pages.
     */
    protected function setTotalPages()
    {
        $this->totalPages = (int) ceil($this->items / $this->itemsPerPage);
    }

    /**
     * Get the total number of pages.
     *
     * @return int
     */
    public function getTotalPages()
    {
        return $this->totalPages;
    }

    /**
     * Get the previous page.
     *
     * @return int|null
     */
    public function getPreviousPage()
    {
        if (1 < $this->currentPage) {
            return $this->currentPage - 1;
        }

        return null;
    }

    /**
     * Get the next page.
     *
     * @return int|null
     */
    public function getNextPage()
    {
        if ($this->currentPage < $this->totalPages) {
            return $this->currentPage + 1;
        }

        return null;
    }

    /**
     * Get the list of pages
     * Inspired by https://github.com/jasongrimes/php-paginator.
     *
     * @return array
     */
    public function getPages()
    {
        if (1 >= $this->totalPages) {
            return [];
        }

        if ($this->totalPages <= $this->pagesToShow) {
            return $this->getPagesSimple();
        } else {
            return $this->getPagesWithSlide();
        }
    }

    /**
     * Get the list of the pages (without slide).
     *
     * @return array
     */
    protected function getPagesSimple()
    {
        $pages = [];

        for ($i = 1; $i <= $this->totalPages; ++$i) {
            $pages[] = $i;
        }

        return $pages;
    }

    /**
     * Get the list of the pages (with slide).
     *
     * @return array
     */
    protected function getPagesWithSlide()
    {
        $pages = [];

        // Determine the sliding range, centered around the current page.
        $numAdjacents = (int) floor(($this->pagesToShow - 3) / 2);
        if ($this->currentPage + $numAdjacents > $this->totalPages) {
            $slidingStart = $this->totalPages - $this->pagesToShow + 2;
        } else {
            $slidingStart = $this->currentPage - $numAdjacents;
        }

        if (2 > $slidingStart) {
            $slidingStart = 2;
        }

        $slidingEnd = $slidingStart + $this->pagesToShow - 3;
        if ($slidingEnd >= $this->totalPages) {
            $slidingEnd = $this->totalPages - 1;
        }

        // Build the list of pages.
        $pages[] = 1;
        if (2 < $slidingStart) {
            $pages[] = 'slide';
        }

        for ($i = $slidingStart; $i <= $slidingEnd; ++$i) {
            $pages[] = $i;
        }

        if ($slidingEnd < $this->totalPages - 1) {
            $pages[] = 'slide';
        }

        $pages[] = $this->totalPages;

        return $pages;
    }

    /**
     * Check if page is the current one.
     *
     * @param int $page Page to check
     *
     * @return bool
     */
    public function isCurrent($page)
    {
        return $page == $this->currentPage;
    }

    /**
     * Get the route of the page.
     *
     * @param int $page The page
     *
     * @return string
     */
    public function getPageRoute($page)
    {
        if (1 == $page) {
            return $this->itemRoutePageOne;
        }

        return $this->itemRoute;
    }

    /**
     * Set the route params of the page.
     *
     * @param array $params
     */
    public function setPageRouteParams(array $params)
    {
        $this->pageRouteParams = $params;

        return $this;
    }

    /**
     * Get the route params of the page.
     *
     * @param int $page The page
     *
     * @return array
     */
    public function getPageRouteParams($page)
    {
        if (1 == $page) {
            return $this->pageRouteParams;
        }

        return array_merge($this->pageRouteParams, ['page' => $page]);
    }
}
