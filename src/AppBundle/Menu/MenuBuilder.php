<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;

class MenuBuilder
{
    private $factory;

    /**
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function createMainMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav main-menu');

        $menu->addChild('menu.mediaarea', array('route' => 'homepage'))
            ->setExtras(array('dropdown' => true));
        $menu['menu.mediaarea']->addChild('menu.mediaarea.about', array('route' => 'homepage'));
        $menu['menu.mediaarea']->addChild('menu.mediaarea.pro', array('route' => 'mi_support'))->setCurrent(false);
        $menu['menu.mediaarea']->addChild('menu.mediaarea.events', array('route' => 'ma_events'));
        $menu['menu.mediaarea']->addChild('menu.mediaarea.legal', array('route' => 'ma_legal'));

        $menu->addChild('menu.mediainfo', array('route' => 'mi_home'))
            ->setExtras(array('dropdown' => true));
        $menu['menu.mediainfo']->addChild('menu.about', array('route' => 'mi_home'));
        $menu['menu.mediainfo']->addChild('menu.download', array('route' => 'mi_download'))
            ->setDisplayChildren(false)
            ->addChild('menu.download.windows', array('route' => 'mi_download_windows'))
            ->addChild('menu.download.mac', array('route' => 'mi_download_mac'))
            ->addChild('menu.download.appimage', array('route' => 'mi_download_appimage'))
            ->addChild('menu.download.debian', array('route' => 'mi_download_debian'))
            ->addChild('menu.download.ubuntu', array('route' => 'mi_download_ubuntu'))
            ->addChild('menu.download.rhel', array('route' => 'mi_download_rhel'))
            ->addChild('menu.download.centos', array('route' => 'mi_download_centos'))
            ->addChild('menu.download.fedora', array('route' => 'mi_download_fedora'))
            ->addChild('menu.download.opensuse', array('route' => 'mi_download_opensuse'))
            ->addChild('menu.download.sle', array('route' => 'mi_download_sle'))
            ->addChild('menu.download.mandriva', array('route' => 'mi_download_mandriva'))
            ->addChild('menu.download.solaris', array('route' => 'mi_download_solaris'))
            ->addChild('menu.download.mageia', array('route' => 'mi_download_mageia'))
            ->addChild('menu.download.archlinux', array('route' => 'mi_download_archlinux'))
            ->addChild('menu.download.manjaro', array('route' => 'mi_download_manjaro'))
            ->addChild('menu.download.pclinuxos', array('route' => 'mi_download_pclinuxos'))
            ->addChild('menu.download.slackware', array('route' => 'mi_download_slackware'))
            ->addChild('menu.download.source', array('route' => 'mi_download_source'));
        $menu['menu.mediainfo']->addChild('menu.screenshots', array('route' => 'mi_screenshots'));
        $menu['menu.mediainfo']->addChild('menu.donate', array('route' => 'mi_donate'));
        $menu['menu.mediainfo']->addChild('menu.support', array('route' => 'mi_support'))
            ->setDisplayChildren(false)
            ->addChild('menu.support.faq', array('route' => 'mi_support_faq'))
            ->addChild('menu.support.formats', array('route' => 'mi_support_formats'))
            ->addChild('menu.support.tags', array('route' => 'mi_support_tags'))
            ->addChild('menu.support.build', array('route' => 'mi_support_build'))
            ->addChild('menu.support.build_mil', array('route' => 'mi_support_build_mil'))
            ->addChild('menu.support.sdk', array('route' => 'mi_support_sdk'))
            ->addChild('menu.support.sdk.readfirst', array('route' => 'mi_support_sdk_readfirst'))
            ->addChild('menu.support.sdk.means', array('route' => 'mi_support_sdk_means'))
            ->addChild('menu.support.sdk.more_info', array('route' => 'mi_support_sdk_more_info'))
            ->addChild('menu.support.sdk.buffers', array('route' => 'mi_support_sdk_buffers'))
            ->addChild('menu.support.sdk.duplicate', array('route' => 'mi_support_sdk_duplicate'))
            ->addChild('menu.support.sdk.filtering', array('route' => 'mi_support_sdk_filtering'));
        $menu['menu.mediainfo']->addChild('menu.testimonials', array('route' => 'mi_testimonials'));

        $menu->addChild('menu.projects', array('route' => 'mi_home'))
            ->setExtras(array('dropdown' => true));
        $menu['menu.projects']->addChild('menu.projects.mediainfo', array('route' => 'mi_home'))->setCurrent(false);
        $menu['menu.projects']->addChild('menu.projects.mediaconch', array('uri' => '/MediaConch/'))->setCurrent(false);
        $menu['menu.projects']->addChild('menu.projects.mediatrace', array('uri' => '/MediaTrace/'))->setCurrent(false);
        $menu['menu.projects']->addChild('menu.projects.qctools', array('uri' => '/QCTools'))->setCurrent(false);
        $menu['menu.projects']->addChild('menu.projects.bwfmetaedit', array('uri' => '/BWFMetaEdit'))
            ->setCurrent(false);
        $menu['menu.projects']->addChild('menu.projects.dvanalyzer', array('uri' => '/DVAnalyzer'))->setCurrent(false);

        return $menu;
    }
}
