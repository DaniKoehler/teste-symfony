<?php

namespace App\Test\Controller;

use App\Entity\Pessoa;
use App\Repository\PessoaRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

class PessoaControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PessoaRepository $repository;
    private string $path = '/pessoa/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Pessoa::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Lista de Pessoas');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());
        
        $this->client->request('GET', sprintf('%snew', $this->path));
        
        self::assertResponseStatusCodeSame(200);
        
        $this->client->submitForm('Cadastrar', [
            'pessoa[nome]' => 'Pessoa',
        ]);

        self::assertResponseRedirects('/pessoa/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $fixture = new Pessoa();
        $fixture->setNome('Pessoa Teste');

        $this->repository->add($fixture, true);

        $response = $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Detalhes');
        
        $hasName = $response->filter('td')->each(function (Crawler $node, $i) {
            if ($node->text() === 'Pessoa Teste') {
                return true;
            }
            return false;
        });

        self::assertTrue(in_array(true, $hasName));
    }

    public function testEdit(): void
    {
        $fixture = new Pessoa();
        $fixture->setNome('Pessoa Teste');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Atualizar', [
            'pessoa[nome]' => 'Pessoa Teste',
        ]);

        self::assertResponseRedirects('/pessoa/');

        $fixture = $this->repository->findAll();

        self::assertSame('Pessoa Teste', $fixture[0]->getNome());
    }

    public function testRemove(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Pessoa();
        $fixture->setNome('Pessoa Teste');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Excluir');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/pessoa/');
    }
}
