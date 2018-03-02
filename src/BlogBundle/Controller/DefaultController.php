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
use BlogBundle\Lib\PostsTagFilter;

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
        $posts = new Posts($this->getParameter('blog.files.path'));
        $showPosts = new LimitIterator(
            $posts,
            ($page - 1) * self::POSTS_PER_PAGE,
            self::POSTS_PER_PAGE
        );

        // Throw 404 if there is no post
        if (0 == iterator_count($showPosts)) {
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

        return ['posts' => $showPosts, 'paginator' => $paginator];
    }

    /**
     * @Route("/{tag}", defaults={"page" = 1}, requirements={"tag" = "[a-zA-Z0-9 -]+"}, name="ma_blog_tag_index")
     * @Route("/{tag}/{page}", requirements={"page" = "\d+", "tag" = "[a-zA-Z0-9 -]+"}, name="ma_blog_tag_index_page")
     * @Template()
     */
    public function listingByTagAction(Request $request, int $page, $tag)
    {
        $posts = new PostsTagFilter(new Posts($this->getParameter('blog.files.path')), $tag);
        $showPosts = new LimitIterator(
                $posts,
                ($page - 1) * self::POSTS_PER_PAGE,
                self::POSTS_PER_PAGE
            );

        // Throw 404 if there is no post
        if (0 == iterator_count($showPosts)) {
            throw new NotFoundHttpException();
        }

        // Redirect paginated page 1 to index
        if ('ma_blog_tag_index_page' == $request->get('_route') && 1 == $page) {
            return $this->redirectToRoute('ma_blog_tag_index', ['tag' => $tag], 301);
        }

        $paginator = new Paginator(
            iterator_count($posts),
            self::POSTS_PER_PAGE,
            'ma_blog_tag_index_page',
            'ma_blog_tag_index',
            $page
        );
        $paginator->setPageRouteParams(['tag' => $tag]);

        // Get first result to get tag (instead of slug)
        $showPosts->rewind();
        $post = $showPosts->current();

        return ['posts' => $showPosts, 'paginator' => $paginator, 'tag' => $post->getTagBySlug($tag)];
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
