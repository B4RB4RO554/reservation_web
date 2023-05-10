<?php

namespace App\Test\Controller;

use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReservationControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ReservationRepository $repository;
    private string $path = '/reservation/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Reservation::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Reservation index');

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
            'reservation[type]' => 'Testing',
            'reservation[date_r]' => 'Testing',
            'reservation[heure_r]' => 'Testing',
            'reservation[reserved_places]' => 'Testing',
            'reservation[Renseignements]' => 'Testing',
            'reservation[user_email]' => 'Testing',
            'reservation[terrain]' => 'Testing',
        ]);

        self::assertResponseRedirects('/reservation/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Reservation();
        $fixture->setType('My Title');
        $fixture->setDate_r('My Title');
        $fixture->setHeure_r('My Title');
        $fixture->setReserved_places('My Title');
        $fixture->setRenseignements('My Title');
        $fixture->setUser_email('My Title');
        $fixture->setTerrain('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Reservation');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Reservation();
        $fixture->setType('My Title');
        $fixture->setDate_r('My Title');
        $fixture->setHeure_r('My Title');
        $fixture->setReserved_places('My Title');
        $fixture->setRenseignements('My Title');
        $fixture->setUser_email('My Title');
        $fixture->setTerrain('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'reservation[type]' => 'Something New',
            'reservation[date_r]' => 'Something New',
            'reservation[heure_r]' => 'Something New',
            'reservation[reserved_places]' => 'Something New',
            'reservation[Renseignements]' => 'Something New',
            'reservation[user_email]' => 'Something New',
            'reservation[terrain]' => 'Something New',
        ]);

        self::assertResponseRedirects('/reservation/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getType());
        self::assertSame('Something New', $fixture[0]->getDate_r());
        self::assertSame('Something New', $fixture[0]->getHeure_r());
        self::assertSame('Something New', $fixture[0]->getReserved_places());
        self::assertSame('Something New', $fixture[0]->getRenseignements());
        self::assertSame('Something New', $fixture[0]->getUser_email());
        self::assertSame('Something New', $fixture[0]->getTerrain());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Reservation();
        $fixture->setType('My Title');
        $fixture->setDate_r('My Title');
        $fixture->setHeure_r('My Title');
        $fixture->setReserved_places('My Title');
        $fixture->setRenseignements('My Title');
        $fixture->setUser_email('My Title');
        $fixture->setTerrain('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/reservation/');
    }
}
