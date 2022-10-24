<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new AppBundle\AppBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new EasyCorp\Bundle\EasyAdminBundle\EasyAdminBundle(),
            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new JMS\Payment\CoreBundle\JMSPaymentCoreBundle(),
            new JMS\Payment\PaypalBundle\JMSPaymentPaypalBundle(),
            new KJ\Payment\StripeBundle\KJPaymentStripeBundle(),
            new Nelmio\CorsBundle\NelmioCorsBundle(),
            new TFox\MpdfPortBundle\TFoxMpdfPortBundle(),
            new Vich\UploaderBundle\VichUploaderBundle(),
            new EWZ\Bundle\RecaptchaBundle\EWZRecaptchaBundle(),
            new MediaTraceBundle\MediaTraceBundle(),
            new BWFMetaEditBundle\BWFMetaEditBundle(),
            new QCToolsBundle\QCToolsBundle(),
            new DVAnalyzerBundle\DVAnalyzerBundle(),
            new OllistdBundle\OllistdBundle(),
            new AVIMetaEditBundle\AVIMetaEditBundle(),
            new MediaInfoBundle\MediaInfoBundle(),
            new UserBundle\UserBundle(),
            new PaymentBundle\PaymentBundle(),
            new SupportUsBundle\SupportUsBundle(),
            new MOVMetaEditBundle\MOVMetaEditBundle(),
            new NoTimeToWaitBundle\NoTimeToWaitBundle(),
            new BlogBundle\BlogBundle(),
            new VoteBundle\VoteBundle(),
            new RAWcookedBundle\RAWcookedBundle(),
            new DVRescueBundle\DVRescueBundle(),
            new MediaConchBundle\MediaConchBundle(),
            new MediaBinBundle\MediaBinBundle(),
            new MediaConchOnlineBundle\MediaConchOnlineBundle(),
            new LeaveSDBundle\LeaveSDBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();

            if ('dev' === $this->getEnvironment()) {
                $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
                $bundles[] = new Symfony\Bundle\WebServerBundle\WebServerBundle();
            }
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
