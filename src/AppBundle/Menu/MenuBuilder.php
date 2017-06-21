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

        $menu = $this->mediaAreaMenu($menu);

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

        $menu = $this->projectsMenu($menu);

        return $menu;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function createMediaTraceMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav main-menu');

        $menu = $this->mediaAreaMenu($menu);

        $menu->addChild('menu.mediatrace', array('route' => 'mediatrace_home'))
            ->setExtras(array('dropdown' => true))
            ->setCurrent(true);
        $menu['menu.mediatrace']->addChild('menu.mediatrace.about', array('uri' => '#about'));
        $menu['menu.mediatrace']->addChild('menu.mediatrace.files', array('uri' => '#files'));
        $menu['menu.mediatrace']->addChild('menu.mediatrace.use', array('uri' => '#use'));
        $menu['menu.mediatrace']->addChild('menu.mediatrace.contact', array('uri' => '#contact'));
        $menu['menu.mediatrace']->addChild('menu.mediatrace.credit', array('uri' => '#credit'));
        $menu['menu.mediatrace']->addChild('menu.mediatrace.license', array('uri' => '#license'));

        $menu = $this->projectsMenu($menu);

        return $menu;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function createBWFMetaEditMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav main-menu');

        $menu = $this->mediaAreaMenu($menu);

        $menu->addChild('menu.bwfmetaedit', array('route' => 'bwf_home'))
            ->setExtras(array('dropdown' => true))
            ->setCurrent(true);
        $menu['menu.bwfmetaedit']->addChild('menu.bwfmetaedit.about', array('route' => 'bwf_home'));
        $menu['menu.bwfmetaedit']->addChild('menu.bwfmetaedit.download', array('route' => 'bwf_download'));

        $menu = $this->projectsMenu($menu);

        return $menu;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function createQCToolsMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav main-menu');

        $menu = $this->mediaAreaMenu($menu);

        $menu->addChild('menu.qctools', array('route' => 'qc_home'))
            ->setExtras(array('dropdown' => true))
            ->setCurrent(true);
        $menu['menu.qctools']->addChild('menu.qctools.about', array('route' => 'qc_home'));
        $menu['menu.qctools']->addChild('menu.qctools.download', array('route' => 'qc_download'));
        $menu['menu.qctools']->addChild('menu.qctools.gettingStarted', array('route' => 'qc_doc_getting_started'));
        $menu['menu.qctools']->addChild('menu.qctools.howToUse', array('route' => 'qc_doc_how_to_use'));
        $menu['menu.qctools']->addChild(
            'menu.qctools.filterDescriptions',
            array('route' => 'qc_doc_filter_descriptions')
        );
        $menu['menu.qctools']->addChild('menu.qctools.playbackFilters', array('route' => 'qc_doc_playback_filters'));
        $menu['menu.qctools']->addChild('menu.qctools.recording', array('route' => 'qc_doc_recording'));
        $menu['menu.qctools']->addChild('menu.qctools.seattle', array('route' => 'qc_doc_seattle'));

        $menu = $this->projectsMenu($menu);

        return $menu;
    }

    private function mediaAreaMenu($menu)
    {
        $menu->addChild('menu.mediaarea', array('route' => 'homepage'))
            ->setExtras(array('dropdown' => true));
        $menu['menu.mediaarea']->addChild('menu.mediaarea.about', array('route' => 'homepage'));
        $menu['menu.mediaarea']->addChild('menu.mediaarea.pro', array('route' => 'mi_support'))->setCurrent(false);
        $menu['menu.mediaarea']->addChild('menu.mediaarea.events', array('route' => 'ma_events'));
        $menu['menu.mediaarea']->addChild('menu.mediaarea.legal', array('route' => 'ma_legal'));

        return $menu;
    }

    private function projectsMenu($menu)
    {
        $menu->addChild('menu.projects', array('route' => 'mi_home'))
            ->setExtras(array('dropdown' => true));
        $menu['menu.projects']->addChild('menu.projects.mediainfo', array('route' => 'mi_home'))->setCurrent(false);
        $menu['menu.projects']->addChild('menu.projects.mediaconch', array('uri' => '/MediaConch/'))->setCurrent(false);
        $menu['menu.projects']->addChild('menu.projects.mediatrace', array('route' => 'mediatrace_home'))
            ->setCurrent(false);
        $menu['menu.projects']->addChild('menu.projects.qctools', array('route' => 'qc_home'))->setCurrent(false);
        $menu['menu.projects']->addChild('menu.projects.bwfmetaedit', array('route' => 'bwf_home'))->setCurrent(false);
        $menu['menu.projects']->addChild('menu.projects.dvanalyzer', array('uri' => '/DVAnalyzer'))->setCurrent(false);

        return $menu;
    }
}
