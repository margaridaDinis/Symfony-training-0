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
        $crawler = $client->request('Get', '/batterypack/new');

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

        //Case 1 to 3
        for ($case = 0; $case < 3; $case++) {
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

        //Case 4
        $rows= $crawler->filter("tbody tr");
        $count = count($rows);
        $this->assertEquals(2, $count);

        //Case 5 - 6
        $AA= $crawler->filter(".batteryStatistic-AA");
        $this->assertContains('AA', $AA->text());
        $this->assertContains('5', $AA->text());

        //Case 7 - 8
        $AAA = $crawler->filter(".batteryStatistic-AAA");
        $this->assertContains('AAA', $AAA->text());
        $this->assertContains('3', $AAA->text());
    }
}
