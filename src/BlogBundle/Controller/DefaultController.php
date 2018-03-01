<?php

namespace BlogBundle\Controller;

use LimitIterator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Lib\Paginator;
use BlogBundle\Lib\Parser\PostParser;
use BlogBundle\Lib\Posts;

/**
 * @Route("/blog")
 */
class DefaultController extends Controller
{
    const POSTS_PER_PAGE = 10;

    /**
     * @Route("", defaults={"page" = 1}, name="ma_blog_index")
     * @Route("/{page}", requirements={"page" = "\d+"}, name="ma_blog_index_page")
     * @Template()
     */
    public function indexAction(Request $request, int $page)
    {
        $posts = new LimitIterator(
            new Posts($this->getParameter('blog.files.path')),
            ($page - 1) * self::POSTS_PER_PAGE,
            self::POSTS_PER_PAGE
        );

        // Throw 404 if page is out of range
        if ($posts->count() < ($page - 1) * self::POSTS_PER_PAGE) {
            throw new NotFoundHttpException();
        }

        // Redirect paginated page 1 to index
        if ('ma_blog_index_page' == $request->get('_route') && 1 == $page) {
            return $this->redirectToRoute('ma_blog_index', [], 301);
        }

        $paginator = new Paginator(
            $posts->count(),
            self::POSTS_PER_PAGE,
            'ma_blog_index_page',
            'ma_blog_index',
            $page
        );

        return ['posts' => $posts, 'paginator' => $paginator];
    }

    /**
     * @Route("/{year}/{month}/{day}/{slug}", name="ma_blog_post")
     * @Template()
     */
    public function postAction($year, $month, $day, $slug)
    {
        try {
            $postParser = new PostParser(
                $this->getParameter('blog.files.path').$year.'-'.$month.'-'.$day.'-'.$slug.'.md'
            );
        } catch (\Exception $e) {
            throw new NotFoundHttpException($e->getMessage());
        }

        return ['post' => $postParser->getPost()];
    }
}
