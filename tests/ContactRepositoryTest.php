<?php

namespace Tests;

use App\ContactRepository;
use PDO;
use PHPUnit\Framework\TestCase;

/**
 * Testa o CRUD completo (create, read, update, delete) do
 * ContactRepository usando um banco SQLite em memória.
 */
class ContactRepositoryTest extends TestCase
{
    private PDO $pdo;
    private ContactRepository $repo;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec(
            'CREATE TABLE contacts (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                phone TEXT NOT NULL,
                observations TEXT
            )'
        );

        $this->repo = new ContactRepository($this->pdo);
    }

    public function testCreateReturnsIdAndPersists(): void
    {
        $id = $this->repo->create('Joao', '11999', 'obs');

        $this->assertSame(1, $id);

        $contact = $this->repo->find($id);
        $this->assertSame('Joao', $contact['name']);
        $this->assertSame('11999', $contact['phone']);
        $this->assertSame('obs', $contact['observations']);
    }

    public function testCreateAllowsNullObservations(): void
    {
        $id = $this->repo->create('Maria', '2288', null);
        $contact = $this->repo->find($id);

        $this->assertNull($contact['observations']);
    }

    public function testFindReturnsNullWhenNotFound(): void
    {
        $this->assertNull($this->repo->find(9999));
    }

    public function testAllReturnsEmptyArrayInitially(): void
    {
        $this->assertSame([], $this->repo->all());
    }

    public function testAllReturnsAllContactsOrdered(): void
    {
        $this->repo->create('Ana', '1');
        $this->repo->create('Bruno', '2');
        $this->repo->create('Carla', '3');

        $all = $this->repo->all();

        $this->assertCount(3, $all);
        $this->assertSame('Ana', $all[0]['name']);
        $this->assertSame('Bruno', $all[1]['name']);
        $this->assertSame('Carla', $all[2]['name']);
    }

    public function testUpdateChangesData(): void
    {
        $id = $this->repo->create('Joao', '11999', 'obs');

        $ok = $this->repo->update($id, 'Joao Editado', '11000', 'nova obs');

        $this->assertTrue($ok);
        $contact = $this->repo->find($id);
        $this->assertSame('Joao Editado', $contact['name']);
        $this->assertSame('11000', $contact['phone']);
        $this->assertSame('nova obs', $contact['observations']);
    }

    public function testUpdateReturnsFalseWhenIdDoesNotExist(): void
    {
        $this->assertFalse($this->repo->update(9999, 'X', 'Y', 'Z'));
    }

    public function testDeleteRemovesContact(): void
    {
        $id = $this->repo->create('Joao', '11999');

        $ok = $this->repo->delete($id);

        $this->assertTrue($ok);
        $this->assertNull($this->repo->find($id));
        $this->assertCount(0, $this->repo->all());
    }

    public function testDeleteReturnsFalseWhenIdDoesNotExist(): void
    {
        $this->assertFalse($this->repo->delete(9999));
    }

    public function testFullCrudLifecycle(): void
    {
        // CREATE
        $id = $this->repo->create('Contato', '0000', 'inicial');
        $this->assertCount(1, $this->repo->all());

        // READ
        $this->assertSame('Contato', $this->repo->find($id)['name']);

        // UPDATE
        $this->repo->update($id, 'Contato Alterado', '1111', 'alterado');
        $this->assertSame('Contato Alterado', $this->repo->find($id)['name']);

        // DELETE
        $this->repo->delete($id);
        $this->assertCount(0, $this->repo->all());
    }
}
