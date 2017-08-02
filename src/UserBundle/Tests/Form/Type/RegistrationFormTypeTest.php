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
        );
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertSame($user, $form->getData());
        $this->assertSame('usertest@mediaarea.net', $user->getEmail());
        $this->assertSame('test123', $user->getPlainPassword());
        $this->assertNotNull($user->getUsername());
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
        );
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertSame($user, $form->getData());
        $this->assertSame('usertest@mediaarea.net', $user->getEmail());
        $this->assertSame('test123', $user->getPlainPassword());
        $this->assertSame('usertest', $user->getUsername());
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
