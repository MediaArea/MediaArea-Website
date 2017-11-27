<?php

namespace VoteBundle\Tests\Controller;

use UserBundle\Tests\Controller\UserAbstractControllerTest;

class DefaultControllerTest extends UserAbstractControllerTest
{
    public function testIndex()
    {
        // User not loggued in (beta period)
        $client = static::createClient();
        $client->request('GET', '/Vote');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        // User loggued in without ROLE_BETA
        $client = $this->createRegularUserClient();
        $client->request('GET', '/Vote');
        $this->assertEquals(403, $client->getResponse()->getStatusCode());

        // User loggued in with ROLE_BETA
        $client = $this->createBetaUserClient();
        $client->request('GET', '/Vote');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testIndexDisplayTable()
    {
        $client = $this->createBetaUserClient();
        $crawler = $client->request('GET', '/Vote');
        $this->assertEquals(2, $crawler->filter('#features-table tbody tr')->count());
        $this->assertEquals(5, $crawler->filter('#features-table tbody tr:nth-child(1) td')->count());
        $this->assertEquals('A super feature title', $crawler->filter('#features-table tbody tr:nth-child(1) td')
            ->first()->text());
        $this->assertEquals('0', $crawler->filter('#features-table tbody tr:nth-child(1) td')->eq(1)->text());
        $this->assertEquals('0', $crawler->filter('#features-table tbody tr:nth-child(1) td')->eq(2)->text());
        $this->assertEquals('50', $crawler->filter('#features-table tbody tr:nth-child(1) td')->eq(3)->text());
        $this->assertEquals('0', $crawler->filter('#features-table tbody tr:nth-child(1) td')->eq(4)->text());

        $link = $crawler->filter('#features-table tbody tr td a')->first();
        $this->assertEquals('A super feature title', $link->text());

        $link = $crawler->filter('#features-table tbody tr:nth-child(2) td a');
        $this->assertEquals('Another super feature title', $link->text());
        $this->assertEquals('/Vote/Another-Super-Feature-Title-2', $link->attr('href'));
        $crawler = $client->click($link->link());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Another super feature title', $crawler->filter('h1')->text());
    }

    public function testShowFeature()
    {
        $client = $this->createBetaUserClient();
        $crawler = $client->request('GET', '/Vote/A-Super-Feature-Title-1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('A super feature title', $crawler->filter('h1')->text());
        $this->assertEquals(50, $crawler->filter('.vote-feature-target')->text());
        $this->assertEquals(0, $crawler->filter('.vote-feature-count')->text());
        $this->assertEquals(0, $crawler->filter('.vote-feature-ratio')->text());
        $this->assertEquals(23, $crawler->filter('.vote-user-total-points')->text());
        $this->assertEquals(0, $crawler->filter('.vote-user-feature-points')->count());
    }

    public function testShowFeatureFirstVote()
    {
        $client = $this->createBetaUserClient();
        $crawler = $client->request('GET', '/Vote/A-Super-Feature-Title-1');

        $form = $crawler->selectButton('Vote')->form();
        $values = $form->getValues();
        $this->assertEquals(0, $values['vote[vote]']);
        $form->setValues(['vote[vote]' => 5]);
        $crawler = $client->submit($form);
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/Vote/A-Super-Feature-Title-1'));
        $crawler = $client->followRedirect();
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
        $form = $crawler->selectButton('Update your vote')->form();
        $values = $form->getValues();
        $this->assertEquals(5, $values['vote[vote]']);
    }

    public function testShowFeatureUpdateVote()
    {
        $client = $this->createBetaUserClient();
        $crawler = $client->request('GET', '/Vote/A-Super-Feature-Title-1');

        $this->assertEquals(50, $crawler->filter('.vote-feature-target')->text());
        $this->assertEquals(5, $crawler->filter('.vote-feature-count')->text());
        $this->assertEquals(10, $crawler->filter('.vote-feature-ratio')->text());
        $this->assertEquals(18, $crawler->filter('.vote-user-total-points')->text());
        $this->assertEquals(5, $crawler->filter('.vote-user-feature-points')->text());

        $form = $crawler->selectButton('Update your vote')->form();
        $values = $form->getValues();
        $this->assertEquals(5, $values['vote[vote]']);
        $form->setValues(['vote[vote]' => 8]);
        $crawler = $client->submit($form);
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/Vote/A-Super-Feature-Title-1'));
        $crawler = $client->followRedirect();
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
        $form = $crawler->selectButton('Update your vote')->form();
        $values = $form->getValues();
        $this->assertEquals(8, $values['vote[vote]']);
    }

    public function testShowFeatureRemoveVote()
    {
        $client = $this->createBetaUserClient();
        $crawler = $client->request('GET', '/Vote/A-Super-Feature-Title-1');

        $this->assertEquals(50, $crawler->filter('.vote-feature-target')->text());
        $this->assertEquals(8, $crawler->filter('.vote-feature-count')->text());
        $this->assertEquals(16, $crawler->filter('.vote-feature-ratio')->text());
        $this->assertEquals(15, $crawler->filter('.vote-user-total-points')->text());
        $this->assertEquals(8, $crawler->filter('.vote-user-feature-points')->text());

        $form = $crawler->selectButton('Update your vote')->form();
        $values = $form->getValues();
        $this->assertEquals(8, $values['vote[vote]']);
        $form->setValues(['vote[vote]' => 0]);
        $crawler = $client->submit($form);
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/Vote/A-Super-Feature-Title-1'));
        $crawler = $client->followRedirect();
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
        $form = $crawler->selectButton('Vote')->form();
        $values = $form->getValues();
        $this->assertEquals(0, $values['vote[vote]']);
    }

    public function testShowFeatureVoteNotEnoughVotingPoints()
    {
        $client = $this->createBetaUserClient();
        $crawler = $client->request('GET', '/Vote/A-Super-Feature-Title-1');

        $form = $crawler->selectButton('Vote')->form();
        $form->setValues(['vote[vote]' => 100]);
        $values = $form->getValues();
        $crawler = $client->submit($form);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('span.help-block')->count());
    }

    public function testShowFeatureVoteIsNotInteger()
    {
        $client = $this->createBetaUserClient();
        $crawler = $client->request('GET', '/Vote/A-Super-Feature-Title-1');

        $form = $crawler->selectButton('Vote')->form();
        $form->setValues(['vote[vote]' => 'test']);
        $values = $form->getValues();
        $crawler = $client->submit($form);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('span.help-block')->count());
    }

    public function testShowFeatureSlugRedirect()
    {
        $client = $this->createBetaUserClient();
        $crawler = $client->request('GET', '/Vote/Slug-Have-Changed-1');
        $this->assertEquals(301, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/Vote/A-Super-Feature-Title-1'));
    }

    public function testShowClosedFeature()
    {
        $client = $this->createBetaUserClient();
        $crawler = $client->request('GET', '/Vote/A-Close-Feature-Title-3');
        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }
}
