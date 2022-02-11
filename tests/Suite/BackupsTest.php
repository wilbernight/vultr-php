<?php

namespace Vultr\VultrPhp\Tests\Suite;

use Vultr\VultrPhp\VultrClient;
use Vultr\VultrPhp\Services\Backups\Backup;
use Vultr\VultrPhp\Services\Backups\BackupException;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Exception\RequestException;

use Vultr\VultrPhp\Tests\VultrTest;

class BackupsTest extends VultrTest
{
	public function testGetBackups()
	{
		$data = $this->getDataProvider()->getData();

		$client = $this->getDataProvider()->createClientHandler([
			new Response(200, ['Content-Type' => 'application/json'], json_encode($data)),
			new RequestException('Bad Request', new Request('GET', 'backups'), new Response(400, [], json_encode(['error' => 'Bad Request']))),
		]);

		$backups = $client->backups->getBackups();
		$this->assertEquals($data['meta']['total'], count($backups));
		foreach ($backups as $backup)
		{
			$this->assertInstanceOf(Backup::class, $backup);
			foreach ($data['backups'] as $object)
			{
				if ($object['id'] !== $backup->getId()) continue;

				foreach ($backup->toArray() as $prop => $prop_val)
				{
					$this->assertEquals($prop_val, $object[$prop]);
				}
			}
		}

		$this->expectException(BackupException::class);
		$client->backups->getBackups();
	}

	public function testGetBackupsByInstanceId()
	{
		$id = 'cb676a46-66fd-4dfb-b839-1141515';
		$data = $this->getDataProvider()->getData($id);
		$client = $this->getDataProvider()->createClientHandler([
			new Response(200, ['Content-Type' => 'application/json'], json_encode($data)),
			new RequestException('Bad Request', new Request('GET', 'backups'), new Response(400, [], json_encode(['error' => 'Bad Request'])))
		]);

		$backups = $client->backups->getBackups($id);
		$this->assertEquals($data['meta']['total'], count($backups));
		foreach ($backups as $backup)
		{
			$this->assertInstanceOf(Backup::class, $backup);
			foreach ($data['backups'] as $object)
			{
				if ($object['id'] !== $backup->getId()) continue;

				foreach ($backup->toArray() as $prop => $prop_val)
				{
					$this->assertEquals($prop_val, $object[$prop]);
				}
			}
		}

		$this->expectException(BackupException::class);
		$client->backups->getBackups($id);
	}

	public function testGetBackup()
	{
		$id = 'cb676a46-66fd-4dfb-b839-12312414';
		$data = $this->getDataProvider()->getData($id);

		$mock = new MockHandler([
			new Response(200, ['Content-Type' => 'application/json'], json_encode($data)),
			new RequestException('Not Found', new Request('GET', 'backups/wrong-id'), new Response(404, [], json_encode(['error' => 'Not found']))),
		]);
		$stack = HandlerStack::create($mock);
		$client = VultrClient::create('TEST1234', ['handler' => $stack]);

		$backup = $client->backups->getBackup($id);
		$this->assertInstanceOf(Backup::class, $backup);
		foreach ($backup->toArray() as $attr => $value)
		{
			$this->assertEquals($value, $data['backup'][$attr]);
		}

		$this->expectException(BackupException::class);
		$client->backups->getBackup('wrong-id');
	}
}
