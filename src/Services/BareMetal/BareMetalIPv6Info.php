<?php

declare(strict_types=1);

namespace Vultr\VultrPhp\Services\BareMetal;

use Vultr\VultrPhp\Util\Model;

class BareMetalIPv6Info extends Model
{
	// The baremetal id this info belongs too
	protected string $id;

	// The response data.
	protected string $ip;
	protected string $network;
	protected int $networkSize;
	protected string $type;

	public function getId() : string
	{
		return $this->id;
	}

	public function setId(string $id) : void
	{
		$this->id = $id;
	}

	public function getIp() : string
	{
		return $this->ip;
	}

	public function setIp(string $ip) : void
	{
		$this->ip = $ip;
	}

	public function getNetwork() : string
	{
		return $this->network;
	}

	public function setNetwork(string $network) : void
	{
		$this->network = $network;
	}

	public function getNetworkSize() : int
	{
		return $this->networkSize;
	}

	public function setNetworkSize(int $size) : void
	{
		$this->networkSize = $size;
	}

	public function getType() : string
	{
		return $this->type;
	}

	public function setType(string $type) : void
	{
		$this->type = $type;
	}

	public function getResponseName() : string
	{
		return 'ipv6';
	}
}
