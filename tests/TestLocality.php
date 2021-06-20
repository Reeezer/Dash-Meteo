<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once 'core/App.php';
require_once 'core/DatabaseManager.php';

require_once "app/models/Locality.php";

final class TestLocality extends TestCase
{

    static $user_id = 1;
    static $name = "Some random place";

    // requires a user with id 1 that is set up for testing
    public function testCreateAndFetch(): void
    {
        App::load_config('config.php');
        DatabaseManager::setup_database();

        $baseLocality = new Locality();
        $baseLocality->set(TestLocality::$user_id, 2.0, -32.5, TestLocality::$name, "NA");
        $baseLocality->save(DatabaseManager::$dbh);

        
        $fetchedLocality = Locality::fetchLocality(DatabaseManager::$dbh, TestLocality::$user_id, TestLocality::$name);

        $this->assertInstanceOf(Locality::class, $fetchedLocality);
        $this->assertEquals($fetchedLocality->getName(), TestLocality::$name);
    }

    /**
     * @depends testCreateAndFetch
     * tell phpunit that the first test function must be called before
     */
    public function testDeleteLocality()
    {
        $beforeDeleteLocality = Locality::fetchLocality(DatabaseManager::$dbh, TestLocality::$user_id, TestLocality::$name);
        $this->assertNotEquals($beforeDeleteLocality, false);

        Locality::deleteLocality(DatabaseManager::$dbh, TestLocality::$user_id, TestLocality::$name);

        $afterDeleteLocality = Locality::fetchLocality(DatabaseManager::$dbh, TestLocality::$user_id, TestLocality::$name);
        $this->assertEquals(false, $afterDeleteLocality);
    }
}

