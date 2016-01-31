<?php

namespace DoctrineProject\Test;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityManager
     */
    protected $em = null;

    public function setUp()
    {
        $em = $this->getEntityManager();
        $tool = new SchemaTool($em);
        // busca a informação de todas as entidades
        $classes = $em->getMetadataFactory()->getAllMetadata();
        // cria a base de dados para os testes
        $tool->createSchema($classes);
        parent::setUp();
    }

    public function tearDown()
    {
        $em = $this->getEntityManager();
        $tool = new SchemaTool($em);
        $classes = $em->getMetadataFactory()->getAllMetadata();
        // Remove a base de dados
        $tool->dropSchema($classes);
        parent::tearDown();
    }

    public function getEntityManager()
    {
        if(! $this->em) {
            $this->em = require __DIR__. '/../../../tests/bootstrap.php';
        }
        return $this->em;
    }
}