<?php

namespace App\Tests\Integration;

use App\Tests\Helper\DatabaseHelper;
use Doctrine\DBAL\DriverManager;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GetQuestionnaireTest extends KernelTestCase
{
    protected Client $connection;

    protected $dbConnection;
    protected $questionnaire;

    /**
     * @return void
     * @throws \Doctrine\DBAL\Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        self::bootKernel();
        $dbConfig = DatabaseHelper::getDBConfig();
        $this->dbConnection = DriverManager::getConnection($dbConfig);

        $this->connection = new Client([
            'verify' => false,
            'base_uri' => 'http://nginx',
        ]);

        $sql = 'INSERT INTO `questionnaire` (name, description) 
                VALUES (:name, :description)';
        $params = [
            'name' => 'test questionnaire',
            'description' => 'test description for questionnaire',
        ];

        $this->dbConnection->executeQuery($sql, $params);

        $allAssociative = $this->dbConnection->fetchAllAssociative(
            "SELECT * From `questionnaire` WHERE `name` = 'test questionnaire'"
        );
        $this->questionnaire = $allAssociative;
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->dbConnection->executeQuery(
            "DELETE FROM `questionnaire` WHERE `id` = :id",
            ['id' => $this->questionnaire[0]['id']]
        );

        $this->dbConnection->close();
    }

    public function testGetQuestionnaire()
    {
        $response = $this->connection->get('/questionnaire/' . $this->questionnaire[0]['id']);
        $result = json_decode($response->getBody()->getContents(), true);

        $expected = $this->questionnaire[0];
        $questionnaireData = $result['data'];

        $this->assertTrue($expected['id'] == $questionnaireData['id']);
        $this->assertEquals($expected['name'], $questionnaireData['name']);
        $this->assertTrue($expected['description'] == $questionnaireData['description']);
    }
}
