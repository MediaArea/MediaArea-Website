<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MenuBuilder
{
    private $factory;
    private $authChecker;

    /**
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     */
    public function __construct(FactoryInterface $factory, AuthorizationCheckerInterface $authChecker)
    {
        $this->factory = $factory;
        $this->authChecker = $authChecker;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function createMainMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav main-menu');

        $menu = $this->mediaAreaMenu($menu);

        $menu->addChild('menu.mediainfo', ['route' => 'mi_home'])->setExtras(['dropdown' => true]);
        $menu['menu.mediainfo']->addChild('menu.about', ['route' => 'mi_home']);
        $menu['menu.mediainfo']
            ->addChild('menu.download', ['route' => 'mi_download'])->setDisplayChildren(false)
            ->addChild('menu.download.windows', ['route' => 'mi_download_windows'])
            ->addChild('menu.download.mac', ['route' => 'mi_download_mac'])
            ->addChild('menu.download.appimage', ['route' => 'mi_download_appimage'])
            ->addChild('menu.download.debian', ['route' => 'mi_download_debian'])
            ->addChild('menu.download.ubuntu', ['route' => 'mi_download_ubuntu'])
            ->addChild('menu.download.rhel', ['route' => 'mi_download_rhel'])
            ->addChild('menu.download.centos', ['route' => 'mi_download_centos'])
            ->addChild('menu.download.fedora', ['route' => 'mi_download_fedora'])
            ->addChild('menu.download.opensuse', ['route' => 'mi_download_opensuse'])
            ->addChild('menu.download.sle', ['route' => 'mi_download_sle'])
            ->addChild('menu.download.mandriva', ['route' => 'mi_download_mandriva'])
            ->addChild('menu.download.solaris', ['route' => 'mi_download_solaris'])
            ->addChild('menu.download.mageia', ['route' => 'mi_download_mageia'])
            ->addChild('menu.download.archlinux', ['route' => 'mi_download_archlinux'])
            ->addChild('menu.download.gentoo', ['route' => 'mi_download_gentoo'])
            ->addChild('menu.download.manjaro', ['route' => 'mi_download_manjaro'])
            ->addChild('menu.download.pclinuxos', ['route' => 'mi_download_pclinuxos'])
            ->addChild('menu.download.slackware', ['route' => 'mi_download_slackware'])
            ->addChild('menu.download.source', ['route' => 'mi_download_source']);
        $menu['menu.mediainfo']->addChild('menu.screenshots', ['route' => 'mi_screenshots']);
        $menu['menu.mediainfo']->addChild('menu.donate', ['route' => 'mi_donate']);
        $menu['menu.mediainfo']
            ->addChild('menu.support', ['route' => 'mi_support'])->setDisplayChildren(false)
            ->addChild('menu.support.faq', ['route' => 'mi_support_faq'])
            ->addChild('menu.support.formats', ['route' => 'mi_support_formats'])
            ->addChild('menu.support.tags', ['route' => 'mi_support_tags'])
            ->addChild('menu.support.build', ['route' => 'mi_support_build'])
            ->addChild('menu.support.build_mil', ['route' => 'mi_support_build_mil'])
            ->addChild('menu.support.sdk', ['route' => 'mi_support_sdk'])
            ->addChild('menu.support.sdk.readfirst', ['route' => 'mi_support_sdk_readfirst'])
            ->addChild('menu.support.sdk.means', ['route' => 'mi_support_sdk_means'])
            ->addChild('menu.support.sdk.more_info', ['route' => 'mi_support_sdk_more_info'])
            ->addChild('menu.support.sdk.buffers', ['route' => 'mi_support_sdk_buffers'])
            ->addChild('menu.support.sdk.duplicate', ['route' => 'mi_support_sdk_duplicate'])
            ->addChild('menu.support.sdk.filtering', ['route' => 'mi_support_sdk_filtering']);
        $menu['menu.mediainfo']->addChild('menu.testimonials', ['route' => 'mi_testimonials']);

        $menu = $this->projectsMenu($menu);
        $menu = $this->supportUsMenu($menu);

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

        $menu->addChild('menu.mediatrace', ['route' => 'mediatrace_home'])->setExtras(['dropdown' => true])
            ->setCurrent(true);
        $menu['menu.mediatrace']->addChild('menu.mediatrace.about', ['uri' => '#about']);
        $menu['menu.mediatrace']->addChild('menu.mediatrace.files', ['uri' => '#files']);
        $menu['menu.mediatrace']->addChild('menu.mediatrace.use', ['uri' => '#use']);
        $menu['menu.mediatrace']->addChild('menu.mediatrace.contact', ['uri' => '#contact']);
        $menu['menu.mediatrace']->addChild('menu.mediatrace.credit', ['uri' => '#credit']);
        $menu['menu.mediatrace']->addChild('menu.mediatrace.license', ['uri' => '#license']);

        $menu = $this->projectsMenu($menu);
        $menu = $this->supportUsMenu($menu);

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

        $menu->addChild('menu.bwfmetaedit', ['route' => 'bwf_home'])->setExtras(['dropdown' => true])->setCurrent(true);
        $menu['menu.bwfmetaedit']->addChild('menu.bwfmetaedit.about', ['route' => 'bwf_home']);
        $menu['menu.bwfmetaedit']->addChild('menu.bwfmetaedit.download', ['route' => 'bwf_download']);

        $menu = $this->projectsMenu($menu);
        $menu = $this->supportUsMenu($menu);

        return $menu;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function createAVIMetaEditMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav main-menu');

        $menu = $this->mediaAreaMenu($menu);

        $menu->addChild('menu.avimetaedit', ['route' => 'avi_home'])->setExtras(['dropdown' => true])->setCurrent(true);
        $menu['menu.avimetaedit']->addChild('menu.avimetaedit.about', ['route' => 'avi_home']);
        $menu['menu.avimetaedit']->addChild('menu.avimetaedit.download', ['route' => 'avi_download']);

        $menu = $this->projectsMenu($menu);
        $menu = $this->supportUsMenu($menu);

        return $menu;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function createMOVMetaEditMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav main-menu');

        $menu = $this->mediaAreaMenu($menu);

        $menu->addChild('menu.movmetaedit', ['route' => 'mov_home'])->setExtras(['dropdown' => true])->setCurrent(true);
        $menu['menu.movmetaedit']->addChild('menu.movmetaedit.about', ['route' => 'mov_home']);
        $menu['menu.movmetaedit']->addChild('menu.movmetaedit.download', ['route' => 'mov_download']);

        $menu = $this->projectsMenu($menu);
        $menu = $this->supportUsMenu($menu);

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

        $menu->addChild('menu.qctools', ['route' => 'qc_home'])->setExtras(['dropdown' => true])->setCurrent(true);
        $menu['menu.qctools']->addChild('menu.qctools.about', ['route' => 'qc_home']);
        $menu['menu.qctools']->addChild('menu.qctools.download', ['route' => 'qc_download']);
        $menu['menu.qctools']->addChild('menu.qctools.gettingStarted', ['route' => 'qc_doc_getting_started']);
        $menu['menu.qctools']->addChild('menu.qctools.howToUse', ['route' => 'qc_doc_how_to_use']);
        $menu['menu.qctools']->addChild('menu.qctools.filterDescriptions', ['route' => 'qc_doc_filter_descriptions']);
        $menu['menu.qctools']->addChild('menu.qctools.playbackFilters', ['route' => 'qc_doc_playback_filters']);
        $menu['menu.qctools']->addChild('menu.qctools.recording', ['route' => 'qc_doc_recording']);
        $menu['menu.qctools']->addChild('menu.qctools.seattle', ['route' => 'qc_doc_seattle']);

        $menu = $this->projectsMenu($menu);
        $menu = $this->supportUsMenu($menu);

        return $menu;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function createDVAnalyzerMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav main-menu');

        $menu = $this->mediaAreaMenu($menu);

        $menu->addChild('menu.dvanalyzer', ['route' => 'dv_home'])->setExtras(['dropdown' => true])->setCurrent(true);
        $menu['menu.dvanalyzer']->addChild('menu.dvanalyzer.about', ['route' => 'dv_home']);
        $menu['menu.dvanalyzer']->addChild('menu.dvanalyzer.download', ['route' => 'dv_download']);

        $menu = $this->projectsMenu($menu);
        $menu = $this->supportUsMenu($menu);

        return $menu;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function createOllistdMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav main-menu');

        $menu = $this->mediaAreaMenu($menu);

        $menu->addChild('menu.ollistd', ['route' => 'ollistd_home']);

        $menu = $this->projectsMenu($menu);
        $menu = $this->supportUsMenu($menu);

        return $menu;
    }

    private function mediaAreaMenu(ItemInterface $menu)
    {
        $menu->addChild('menu.mediaarea', ['route' => 'homepage'])->setExtras(['dropdown' => true]);
        $menu['menu.mediaarea']->addChild('menu.mediaarea.about', ['route' => 'homepage']);
        $menu['menu.mediaarea']->addChild('menu.mediaarea.pro', ['route' => 'ma_professional_services']);
        $menu['menu.mediaarea']->addChild('menu.mediaarea.events', ['route' => 'ma_events']);
        $menu['menu.mediaarea']->addChild('menu.mediaarea.conduct', ['route' => 'ma_conduct']);
        $menu['menu.mediaarea']->addChild('menu.mediaarea.teamrules', ['route' => 'ma_team_rules']);
        $menu['menu.mediaarea']->addChild('menu.mediaarea.legal', ['route' => 'ma_legal']);
        $menu['menu.mediaarea']->addChild('menu.mediaarea.contact', ['route' => 'ma_contact']);

        return $menu;
    }

    private function projectsMenu(ItemInterface $menu)
    {
        $menu->addChild('menu.projects', ['route' => 'mi_home'])->setExtras(['dropdown' => true]);
        $menu['menu.projects']->addChild('menu.projects.mediainfo', ['route' => 'mi_home'])->setCurrent(false);
        $menu['menu.projects']->addChild('menu.projects.mediaconch', ['uri' => '/MediaConch/'])->setCurrent(false);
        $menu['menu.projects']->addChild('menu.projects.mediatrace', ['route' => 'mediatrace_home'])->setCurrent(false);
        $menu['menu.projects']->addChild('menu.projects.qctools', ['route' => 'qc_home'])->setCurrent(false);
        $menu['menu.projects']->addChild('menu.projects.bwfmetaedit', ['route' => 'bwf_home'])->setCurrent(false);
        $menu['menu.projects']->addChild('menu.projects.avimetaedit', ['route' => 'avi_home'])->setCurrent(false);
        $menu['menu.projects']->addChild('menu.projects.movmetaedit', ['route' => 'mov_home'])->setCurrent(false);
        $menu['menu.projects']->addChild('menu.projects.dvanalyzer', ['route' => 'dv_home'])->setCurrent(false);
        $menu['menu.projects']->addChild('menu.projects.ollistd', ['route' => 'ollistd_home'])->setCurrent(false);

        return $menu;
    }

    private function supportUsMenu(ItemInterface $menu)
    {
        $menu->addChild('menu.supportUs', ['route' => 'supportUs_about'])->setExtras(['dropdown' => true]);
        $menu['menu.supportUs']->addChild('menu.supportUs.about', ['route' => 'supportUs_about']);
        $menu['menu.supportUs']->addChild('menu.supportUs.corporate', ['route' => 'supportUs_corporate']);
        $menu['menu.supportUs']->addChild('menu.supportUs.individial', ['route' => 'supportUs_individual']);
        $menu['menu.supportUs']->addChild('menu.supportUs.faq', ['route' => 'supportUs_faq']);
        $menu['menu.supportUs']->addChild('menu.supportUs.sponsorsList', ['route' => 'supportUs_sponsors_list']);
        $menu['menu.supportUs']->addChild('menu.supportUs.supportersList', ['route' => 'supportUs_supporters_list']);
        if ($this->authChecker->isGranted('ROLE_BETA')) {
            $menu['menu.supportUs']->addChild('menu.vote', ['route' => 'vote_list_features']);
        }

        return $menu;
    }
}
