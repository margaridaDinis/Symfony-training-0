<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testNew()
    {
    //todo: it's not a part of the test. You can move it into setUp() method or into bootstrap file
        shell_exec('php bin/console doctrine:database:drop --force;');
        shell_exec('php bin/console doctrine:database:create;');
        shell_exec('php bin/console doctrine:schema:update --force;');

        $client = static::createClient();
        $crawler = $client->request('Get', '/batterypack/new');

        $showAction = 'AppBundle\Controller\DefaultController::showAction';

//todo: this is a configuration of test case, it should be in DataProvider, together with expected counts (Search "phpunit dataProvider")
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
        //todo: "foreach" loop would work much better here
        for ($case = 0; $case < 3; $case++) {
            $form = $crawler->selectButton('Create')->form($cases[$case]);
            $client->submit($form);
            $client->followRedirect();
            $this->assertEquals($showAction, $client->getRequest()->attributes->get('_controller'));
        }
    }
    public function testIndex()
    {
    //todo: this test should be a part of previous one: after you submitted form 3 times - you have to check statistics
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
