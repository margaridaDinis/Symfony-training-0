<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testNew()
    {
        shell_exec('php bin/console doctrine:database:drop --force;');
        shell_exec('php bin/console doctrine:database:create;');
        shell_exec('php bin/console doctrine:schema:update --force;');

        $client = static::createClient();
        $showAction = 'AppBundle\Controller\DefaultController::showAction';

        $cases = array(
            array(
                'form[name]' => '',
                'form[type]' => 'AA',
                'form[count]' => '4'
            ),
            array(
                'form[name]' => '',
                'form[type]' => 'AAA',
                'form[count]' => '3'
            ),
            array(
                'form[name]' => '',
                'form[type]' => 'AA',
                'form[count]' => '1'
            )
        );
        for ($case = 0; $case < 3; $case++) {
            $crawler = $client->request('Get', '/batterypack/new');
            $form = $crawler->selectButton('Create')->form($cases[$case]);
            $client->submit($form);
            $client->followRedirect();
            $this->assertEquals($showAction, $client->getRequest()->attributes->get('_controller'));
        }
    }
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $rows= $crawler->filter("tbody tr");

        $count = count($rows);
        $this->assertEquals(2, $count);

        $AA= $crawler->filter(".batteryStatistic-AA");
        $this->assertContains('AA', $AA->text());
        $this->assertContains('5', $AA->text());

        $AAA = $crawler->filter(".batteryStatistic-AAA");
        $this->assertContains('AAA', $AAA->text());
        $this->assertContains('3', $AAA->text());
    }
}
