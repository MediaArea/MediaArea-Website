<?php

namespace UserBundle\Tests\Form\Type;

use UserBundle\Form\Type\ProfileFormType;
use UserBundle\Tests\TestUser;

class ProfileFormTypeTest extends ValidatorExtensionTypeTestCase
{
    public function testSubmitWithoutUsername()
    {
        $user = new TestUser();
        $form = $this->factory->create(ProfileFormType::class, $user);
        $formData = array(
            'email' => 'usertest@mediaarea.net',
            'name' => 'test',
            'country' => 'GB',
            'language' => 'en_US',
            'professional' => 1,
            'companyName' => 'test',
            'newsletter' => 0,
        );

        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertSame($user, $form->getData());
        $this->assertSame('usertest@mediaarea.net', $user->getEmail());
        $this->assertSame('test', $user->getName());
        $this->assertNotNull($user->getUsername());
        $this->assertEquals(0, $user->getRealUserName());
        $this->assertSame('GB', $user->getCountry());
        $this->assertSame('en_US', $user->getLanguage());
        $this->assertSame(1, $user->getProfessional());
        $this->assertSame('test', $user->getCompanyName());
        $this->assertEquals(0, $user->getNewsletter());
    }

    public function testSubmitWithUsername()
    {
        $user = new TestUser();
        $form = $this->factory->create(ProfileFormType::class, $user);
        $formData = array(
            'username' => 'usertest',
            'email' => 'usertest@mediaarea.net',
        );
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertSame($user, $form->getData());
        $this->assertSame('usertest@mediaarea.net', $user->getEmail());
        $this->assertSame('usertest', $user->getUsername());
        $this->assertEquals(1, $user->getRealUserName());
        $this->assertNull($user->getName());
        $this->assertNull($user->getCountry());
        $this->assertNull($user->getLanguage());
        $this->assertNull($user->getProfessional());
        $this->assertNull($user->getCompanyName());
    }

    /**
     * @return array
     */
    protected function getTypes()
    {
        return array_merge(parent::getTypes(), array(
            new ProfileFormType('UserBundle\Tests\TestUser'),
            new \FOS\UserBundle\Form\Type\ProfileFormType('UserBundle\Tests\TestUser'),
        ));
    }
}
