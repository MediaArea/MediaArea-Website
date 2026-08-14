<?php

namespace UserBundle\Tests\Form\Type;

use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use EWZ\Bundle\RecaptchaBundle\Locale\LocaleResolver;
use Symfony\Component\HttpFoundation\RequestStack;
use UserBundle\Form\Type\RegistrationFormType;
use UserBundle\Tests\TestUser;

class RegistrationFormTypeTest extends ValidatorExtensionTypeTestCase
{
    public function testSubmitWithoutUsername(): void
    {
        $user = new TestUser();
        $form = $this->factory->create(RegistrationFormType::class, $user);
        $formData = [
            'email' => 'usertest@mediaarea.net',
            'plainPassword' => [
                'first' => 'test123',
                'second' => 'test123',
            ],
            'name' => 'test',
            'country' => 'GB',
            'language' => 'en_US',
            'professional' => 1,
            'companyName' => 'test',
            'newsletter' => 0,
            'companyUrl' => '',
        ];
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertTrue($form->isValid());
        $this->assertSame($user, $form->getData());
        $this->assertSame('usertest@mediaarea.net', $user->getEmail());
        $this->assertSame('test123', $user->getPlainPassword());
        $this->assertNotNull($user->getUsername());
        $this->assertEquals(0, $user->getRealUserName());
        $this->assertSame('test', $user->getName());
        $this->assertSame('GB', $user->getCountry());
        $this->assertSame('en_US', $user->getLanguage());
        $this->assertSame(1, $user->getProfessional());
        $this->assertSame('test', $user->getCompanyName());
        $this->assertEquals(0, $user->getNewsletter());
    }

    public function testSubmitWithUsername(): void
    {
        $user = new TestUser();
        $form = $this->factory->create(RegistrationFormType::class, $user);
        $formData = [
            'username' => 'usertest',
            'email' => 'usertest@mediaarea.net',
            'plainPassword' => [
                'first' => 'test123',
                'second' => 'test123',
            ],
            'companyUrl' => '',
        ];
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertTrue($form->isValid());
        $this->assertSame($user, $form->getData());
        $this->assertSame('usertest@mediaarea.net', $user->getEmail());
        $this->assertSame('test123', $user->getPlainPassword());
        $this->assertSame('usertest', $user->getUsername());
        $this->assertNull($user->getName());
        $this->assertNull($user->getCountry());
        $this->assertNull($user->getLanguage());
        $this->assertNull($user->getProfessional());
        $this->assertNull($user->getCompanyName());
    }

    public function testSubmitWithCompanyUrl(): void
    {
        $user = new TestUser();
        $form = $this->factory->create(RegistrationFormType::class, $user);
        $formData = [
            'username' => 'usertest',
            'email' => 'usertest@mediaarea.net',
            'plainPassword' => [
                'first' => 'test123',
                'second' => 'test123',
            ],
            'companyUrl' => 'my company',
        ];
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertFalse($form->isValid());
    }

    /**
     * @return array
     */
    protected function getTypes()
    {
        $localeResolver = new LocaleResolver('en', false, new RequestStack());

        return \array_merge(parent::getTypes(), [
            new RegistrationFormType('UserBundle\Tests\TestUser'),
            new \FOS\UserBundle\Form\Type\RegistrationFormType('UserBundle\Tests\TestUser'),
            new EWZRecaptchaType('test-key', false, false, $localeResolver),
        ]);
    }
}
