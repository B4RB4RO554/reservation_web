<?php

namespace App\Test\Controller;

use App\Entity\Terrain;
use App\Repository\TerrainRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TerrainControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private TerrainRepository $repository;
    private string $path = '/terrain/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Terrain::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Terrain index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'terrain[nom_t]' => 'Testing',
            'terrain[nb_places]' => 'Testing',
            'terrain[surface]' => 'Testing',
            'terrain[type_r]' => 'Testing',
            'terrain[type_c]' => 'Testing',
            'terrain[prix]' => 'Testing',
            'terrain[img]' => 'Testing',
        ]);

        self::assertResponseRedirects('/terrain/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Terrain();
        $fixture->setNom_t('My Title');
        $fixture->setNb_places('My Title');
        $fixture->setSurface('My Title');
        $fixture->setType_r('My Title');
        $fixture->setType_c('My Title');
        $fixture->setPrix('My Title');
        $fixture->setImg('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Terrain');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Terrain();
        $fixture->setNom_t('My Title');
        $fixture->setNb_places('My Title');
        $fixture->setSurface('My Title');
        $fixture->setType_r('My Title');
        $fixture->setType_c('My Title');
        $fixture->setPrix('My Title');
        $fixture->setImg('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'terrain[nom_t]' => 'Something New',
            'terrain[nb_places]' => 'Something New',
            'terrain[surface]' => 'Something New',
            'terrain[type_r]' => 'Something New',
            'terrain[type_c]' => 'Something New',
            'terrain[prix]' => 'Something New',
            'terrain[img]' => 'Something New',
        ]);

        self::assertResponseRedirects('/terrain/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNom_t());
        self::assertSame('Something New', $fixture[0]->getNb_places());
        self::assertSame('Something New', $fixture[0]->getSurface());
        self::assertSame('Something New', $fixture[0]->getType_r());
        self::assertSame('Something New', $fixture[0]->getType_c());
        self::assertSame('Something New', $fixture[0]->getPrix());
        self::assertSame('Something New', $fixture[0]->getImg());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Terrain();
        $fixture->setNom_t('My Title');
        $fixture->setNb_places('My Title');
        $fixture->setSurface('My Title');
        $fixture->setType_r('My Title');
        $fixture->setType_c('My Title');
        $fixture->setPrix('My Title');
        $fixture->setImg('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/terrain/');
    }
}
