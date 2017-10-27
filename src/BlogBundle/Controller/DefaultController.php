<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use BlogBundle\Lib\Parser\PostParser;

class DefaultController extends Controller
{
    /**
     * @Route("/blog", name="ma_blog_index")
     * @Template()
     */
    public function indexAction()
    {
        $finder = new Finder();
        $finder->files()->name('*.md')->depth('== 0')->sortByName()->ignoreDotFiles(true)->ignoreVCS(true);
        $posts = [];
        foreach ($finder->in($this->getParameter('blog.files.path')) as $file) {
            try {
                $postParser = new PostParser($file->getRealPath());
                $posts[] = $postParser->getPost();
            } catch (\Exception $e) {
                // Ignore post
            }
        }

        return ['posts' => array_reverse($posts)];
    }

    /**
     * @Route("/blog/{year}/{month}/{day}/{slug}", name="ma_blog_post")
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
