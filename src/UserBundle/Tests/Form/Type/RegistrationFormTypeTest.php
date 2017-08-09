<?php

namespace UserBundle\Tests\Form\Type;

use UserBundle\Form\Type\RegistrationFormType;
use UserBundle\Tests\TestUser;

class RegistrationFormTypeTest extends ValidatorExtensionTypeTestCase
{
    public function testSubmitWithoutUsername()
    {
        $user = new TestUser();
        $form = $this->factory->create(RegistrationFormType::class, $user);
        $formData = array(
            'email' => 'usertest@mediaarea.net',
            'plainPassword' => array(
                'first' => 'test123',
                'second' => 'test123',
            ),
            'name' => 'test',
            'country' => 'GB',
            'language' => 'en_US',
            'professional' => 1,
            'companyName' => 'test',
            'newsletter' => 0,
            'companyUrl' => '',
        );
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

    public function testSubmitWithUsername()
    {
        $user = new TestUser();
        $form = $this->factory->create(RegistrationFormType::class, $user);
        $formData = array(
            'username' => 'usertest',
            'email' => 'usertest@mediaarea.net',
            'plainPassword' => array(
                'first' => 'test123',
                'second' => 'test123',
            ),
            'companyUrl' => '',
        );
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

    public function testSubmitWithCompanyUrl()
    {
        $user = new TestUser();
        $form = $this->factory->create(RegistrationFormType::class, $user);
        $formData = array(
            'username' => 'usertest',
            'email' => 'usertest@mediaarea.net',
            'plainPassword' => array(
                'first' => 'test123',
                'second' => 'test123',
            ),
            'companyUrl' => 'my company',
        );
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertFalse($form->isValid());
    }

    /**
     * @return array
     */
    protected function getTypes()
    {
        return array_merge(parent::getTypes(), array(
            new RegistrationFormType('UserBundle\Tests\TestUser'),
            new \FOS\UserBundle\Form\Type\RegistrationFormType('UserBundle\Tests\TestUser'),
        ));
    }
}
