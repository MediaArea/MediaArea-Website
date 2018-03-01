<?php

namespace Tests\AppBundle\Lib;

use PHPUnit\Framework\TestCase;
use AppBundle\Lib\Paginator;

class PaginatorTest extends TestCase
{
    /**
     * @dataProvider totalPagesProvider
     */
    public function testGetTotalPages($items, $itemsPerPage, $expected)
    {
        $paginator = new Paginator($items, $itemsPerPage, 'index_page', 'index', 1);

        $this->assertEquals($expected, $paginator->getTotalPages());
    }

    public function totalPagesProvider()
    {
        return [
                [100, 10, 10],
                [101, 10, 11],
                [109, 10, 11],
                [5, 10, 1],
            ];
    }

    /**
     * @dataProvider pagesProvider
     */
    public function testGetPages($items, $currentPage, $pagesToShow, $expected)
    {
        $paginator = new Paginator($items, 1, 'index_page', 'index', $currentPage, $pagesToShow);

        $this->assertEquals($expected, $paginator->getPages());
    }

    public function pagesProvider()
    {
        return [
            [20, 1, 10, [1, 2, 3, 4, 5, 6, 7, 8, 9, 'slide', 20]],
            [20, 2, 10, [1, 2, 3, 4, 5, 6, 7, 8, 9, 'slide', 20]],
            [20, 20, 10, [1, 'slide', 12, 13, 14, 15, 16, 17, 18, 19, 20]],
            [20, 19, 10, [1, 'slide', 12, 13, 14, 15, 16, 17, 18, 19, 20]],
            [20, 10, 10, [1, 'slide', 7, 8, 9, 10, 11, 12, 13, 14, 'slide', 20]],
            [20, 9, 10, [1, 'slide', 6, 7, 8, 9, 10, 11, 12, 13, 'slide', 20]],
            [5, 3, 10, [1, 2, 3, 4, 5]],
            [1, 1, 10, []], // No pagination if there's only one page.
            [5, 8, 10, [1, 2, 3, 4, 5]], // Current page out of range
            [13, 2, 5, [1, 2, 3, 4, 'slide', 13]],
            [13, 4, 5, [1, 'slide', 3, 4, 5, 'slide', 13]],
            [13, 5, 5, [1, 'slide', 4, 5, 6, 'slide', 13]],
            [13, 11, 5, [1, 'slide', 10, 11, 12, 13]],
            [13, 10, 5, [1, 'slide', 9, 10, 11, 'slide', 13]],
            [20, 5, 3, [1, 'slide', 5, 'slide', 20]],
        ];
    }

    /**
     * @dataProvider previousAndNextProvider
     */
    public function testPreviousAndNextPage($items, $currentPage, $expectedPrevious, $expectedNext)
    {
        $paginator = new Paginator($items, 10, 'index_page', 'index', $currentPage);

        $this->assertEquals($expectedPrevious, $paginator->getPreviousPage());
        $this->assertEquals($expectedNext, $paginator->getNextPage());
    }

    public function previousAndNextProvider()
    {
        return [
            [95, 1, null, 2],
            [95, 2, 1, 3],
            [95, 10, 9, null],
            [95, 11, 10, null],
        ];
    }

    /**
     * @dataProvider routeProvider
     */
    public function testRoute($items, $currentPage, $expectedRoute, $expectedRouteParams)
    {
        $paginator = new Paginator($items, 10, 'index_page', 'index', $currentPage);

        $this->assertEquals($expectedRoute, $paginator->getPageRoute($currentPage));
        $this->assertEquals($expectedRouteParams, $paginator->getPageRouteParams($currentPage));
    }

    public function routeProvider()
    {
        return [
            [95, 1, 'index', []],
            [95, 2, 'index_page', ['page' => 2]],
            [95, 10, 'index_page', ['page' => 10]],
        ];
    }

    /**
     * @dataProvider routeProvider
     */
    public function testRouteWithParams($items, $currentPage, $expectedRoute, $expectedRouteParams)
    {
        $routeParams = ['tag' => 'test'];
        $paginator = new Paginator($items, 10, 'index_page', 'index', $currentPage);
        $paginator->setPageRouteParams($routeParams);

        $this->assertEquals($expectedRoute, $paginator->getPageRoute($currentPage));
        $this->assertEquals(
                array_merge($routeParams, $expectedRouteParams),
                $paginator->getPageRouteParams($currentPage)
            );
    }

    /**
     * @dataProvider isCurrentProvider
     */
    public function testIsCurrent($items, $currentPage, $page, $expectedCurrent)
    {
        $paginator = new Paginator($items, 10, 'index_page', 'index', $currentPage);

        $this->assertEquals($expectedCurrent, $paginator->isCurrent($page));
    }

    public function isCurrentProvider()
    {
        return [
                [95, 1, 1, true],
                [95, 1, 2, false],
                [95, 2, 1, false],
                [95, 2, 2, true],
                [95, 10, 1, false],
                [95, 10, 10, true],
            ];
    }
}
