<?php

declare(strict_types=1);

namespace Vultr\VultrPhp\Services\BareMetal;

use Vultr\VultrPhp\Services\VultrService;
use Vultr\VultrPhp\Util\ListOptions;
use Vultr\VultrPhp\Util\VultrUtil;
use Vultr\VultrPhp\VultrClientException;

class BareMetalService extends VultrService
{
	/**
	 * @see https://www.vultr.com/api/#operation/list-baremetals
	 * @param $options - ListOptions|null - Interact via reference.
	 * @throws BareMetalException
	 * @return BareMetal[]
	 */
	public function getBareMetals(?ListOptions &$options = null) : array
	{
		return $this->getListObjects('bare-metals', new BareMetal(), $options);
	}

	/**
	 * @see https://www.vultr.com/api/#operation/get-baremetal
	 * @param $id - string - Example: cb676a46-66fd-4dfb-b839-443f2e6c0b60
	 * @throws BareMetalException
	 * @return BareMetal
	 */
	public function getBareMetal(string $id) : BareMetal
	{
		return $this->getObject('bare-metals/'.$id, new BareMetal());
	}

	/**
	 * @see https://www.vultr.com/api/#operation/delete-baremetal
	 * @throws BareMetalException
	 * @return void
	 */
	public function deleteBareMetal(string $id) : void
	{
		$this->deleteObject('bare-metals/'.$id, new BareMetal());
	}

	/**
	 * @see https://www.vultr.com/api/#operation/create-baremetal
	 * @param $payload - BareMetalCreate
	 * @throws BareMetalException
	 * @return BareMetal
	 */
	public function createBareMetal(BareMetalCreate $payload) : BareMetal
	{
		return $this->createObject('bare-metals', new BareMetal(), $payload->getPayloadParams());
	}

	/**
	 * @see https://www.vultr.com/api/#operation/update-baremetal
	 * @param $id - string - Example: cb676a46-66fd-4dfb-b839-443f2e6c0b60
	 * @param $payload - BareMetalUpdate
	 * @throws BareMetalException
	 * @return BareMetal
	 */
	public function updateBareMetal(string $id, BareMetalUpdate $payload) : BareMetal
	{
		$client = $this->getClientHandler();

		try
		{
			$response = $client->patch('bare-metals/'.$id, $payload->getPayloadParams());
		}
		catch (VultrClientException $e)
		{
			throw new BareMetalException('Failed to update baremetal server: '.$e->getMessage(), $e->getHTTPCode(), $e);
		}

		$model = new BareMetal();

		return VultrUtil::convertJSONToObject((string)$response->getBody(), $model, $model->getResponseName());
	}

	/**
	 * @see https://www.vultr.com/api/#operation/get-ipv4-baremetal
	 * @param $id - string - Example: cb676a46-66fd-4dfb-b839-443f2e6c0b60
	 * @throws BareMetalException
	 * @throws VultrException
	 * @return BareMetalIPv4Info[]
	 */
	public function getIPv4Addresses(string $id) : array
	{
		$client = $this->getClientHandler();

		try
		{
			$response = $client->get('bare-metals/'.$id.'/ipv4');
		}
		catch (VultrClientException $e)
		{
			throw new BareMetalException('Failed to get baremetal ipv4 information: '.$e->getMessage(), $e->getHTTPCode(), $e);
		}

		$objects = [];
		$decode = VultrUtil::decodeJSON((string)$response->getBody());
		$model = new BareMetalIPv4Info();
		$response_name = $model->getResponseListName();
		foreach ($decode->$response_name as $ipv4)
		{
			$object = VultrUtil::mapObject($ipv4, $model);
			$object->setId($id);
			$objects[] = $object;
		}
		return $objects;
	}

	/**
	 * @see https://www.vultr.com/api/#operation/get-ipv6-baremetal
	 * @param $id - string - Example: cb676a46-66fd-4dfb-b839-443f2e6c0b60
	 * @throws BareMetalException
	 * @throws VultrException
	 * @return BareMetalIPv6Info[]
	 */
	public function getIPv6Addresses(string $id) : array
	{

	}

	/**
	 * @see https://www.vultr.com/api/#operation/start-baremetal
	 * @param $id - string - Example: cb676a46-66fd-4dfb-b839-443f2e6c0b60
	 * @throws BareMetalException
	 * @return void
	 */
	public function startBareMetal(string $id) : void
	{

	}

	/**
	 * @see https://www.vultr.com/api/#operation/start-bare-metals
	 * @param $ids - array - Example: [cb676a46-66fd-4dfb-b839-443f2e6c0b60, cb676a46-66fd-4dfb-b839-443f2e6c0b65]
	 * @throws BareMetalException
	 * @return void
	 */
	public function startBareMetals(array $ids) : void
	{

	}

	/**
	 * @see https://www.vultr.com/api/#operation/reboot-baremetal
	 * @param $id - string - Example: cb676a46-66fd-4dfb-b839-443f2e6c0b60
	 * @throws BareMetalException
	 * @return void
	 */
	public function rebootBareMetal(string $id) : void
	{

	}

	/**
	 * @see https://www.vultr.com/api/#operation/reboot-bare-metals
	 * @param $ids - array - Example: [cb676a46-66fd-4dfb-b839-443f2e6c0b60, cb676a46-66fd-4dfb-b839-443f2e6c0b65]
	 * @throws BareMetalException
	 * @return void
	 */
	public function rebootBareMetals(array $ids) : void
	{

	}

	/**
	 * @see https://www.vultr.com/api/#operation/reinstall-baremetal
	 * @param $id - string - Example: cb676a46-66fd-4dfb-b839-443f2e6c0b60
	 * @throws BareMetalException
	 * @return BareMetal
	 */
	public function reinstallBareMetal(string $id) : BareMetal
	{

	}

	/**
	 * @see https://www.vultr.com/api/#operation/halt-baremetal
	 * @param $id - string - Example: cb676a46-66fd-4dfb-b839-443f2e6c0b60
	 * @throws BareMetalException
	 * @return void
	 */
	public function haltBareMetal(string $id) : void
	{

	}

	/**
	 * @see https://www.vultr.com/api/#operation/halt-baremetals
	 * @param $ids - array - Example: [cb676a46-66fd-4dfb-b839-443f2e6c0b60, cb676a46-66fd-4dfb-b839-443f2e6c0b65]
	 * @throws BareMetalException
	 * @return void
	 */
	public function haltBareMetals(array $ids) : void
	{

	}

	/**
	 * @see https://www.vultr.com/api/#operation/get-bandwidth-baremetal
	 * @param $id - string - Example: cb676a46-66fd-4dfb-b839-443f2e6c0b60
	 * @throws BareMetalException
	 * @return array
	 */
	public function getBandwidth(string $id) : array
	{

	}

	/**
	 * @see https://www.vultr.com/api/#operation/get-bare-metal-userdata
	 * @param $id - string - Example: cb676a46-66fd-4dfb-b839-443f2e6c0b60
	 * @throws BareMetalException
	 * @return string
	 */
	public function getUserData(string $id) : string
	{

	}

	/**
	 * @see https://www.vultr.com/api/#operation/get-bare-metals-upgrades
	 * @param $id - string - Example: cb676a46-66fd-4dfb-b839-443f2e6c0b60
	 * @param $type - string - filter based on upgrade types.
	 * @throws BareMetalException
	 * @return OperatingSystem|Application[]
	 */
	public function getAvailableUpgrades(string $id, string $type = 'all') : array
	{

	}

	/**
	 * @see https://www.vultr.com/api/#operation/get-bare-metal-vnc
	 * @param $id - string - Example: cb676a46-66fd-4dfb-b839-443f2e6c0b60
	 * @throws BareMetalException
	 * @return string
	 */
	public function getVNCUrl(string $id) : string
	{

	}
}
