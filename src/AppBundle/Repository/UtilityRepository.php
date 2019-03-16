<?php

namespace AppBundle\Repository;

use AppBundle\Model\Item;
use Exception;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

class UtilityRepository
{
    /** @var string */
    private $jsonPath;

    /** @var string */
    private $apiPath;

    /** @var int */
    private $minItemValue;

    /** @var int */
    private $maxQueries;

    /** @var int */
    private $natureRuneId;

    /** @var Client */
    private $client;

    /** @var LoggerInterface */
    private $logger;

    /** @var int */
    private $natureRuneCost;

    /** @var string[] */
    private $urls = null;

    /**
     * @param string $jsonPath
     * @param string $apiPath
     * @param int $minItemValue
     * @param int $maxQueries
     * @param int $natureRuneId
     * @param Client $client
     * @param LoggerInterface $logger
     */
    public function __construct(
        $jsonPath,
        $apiPath,
        $minItemValue,
        $maxQueries,
        $natureRuneId,
        Client $client,
        LoggerInterface $logger
    ) {
        $this->jsonPath = $jsonPath;
        $this->apiPath = $apiPath;
        $this->minItemValue = $minItemValue;
        $this->maxQueries = $maxQueries;
        $this->natureRuneId = $natureRuneId;
        $this->client = $client;
        $this->logger = $logger;
    }

    /**
     * @return Item[]
     */
    public function parseStaticItemInfo()
    {
        $json = file_get_contents($this->jsonPath);
        return $this->buildItems(json_decode($json, true));
    }

    /**
     * @param array $json
     * @return Item[]
     */
    private function buildItems(array $json)
    {
        $items = array();
        foreach ($json as $key => $value) {
            if (($value['tradeable'] && $value['value'] >= $this->minItemValue) || $key == $this->natureRuneId) {
                $item = new Item();
                $item->setId($key);
                $item->setName($value['name']);
                $item->setTradeable($value['tradeable']);
                $item->setValue($value['value']);
                $items[$key] = $item;
            }
        }

        $this->logger->info('UtilityRepository.buildItems: Built ' . sizeof($items) . ' Items');
        return $items;
    }

    /**
     * @param Item[] $items
     * @return Item[]
     */
    public function getCurrentData(array $items)
    {
        if (is_null($this->urls)) {
            $this->urls = $this->buildUrls($items);
        }

        foreach ($this->urls as $url) {
            try {
                $response = $this->client->get($url);
                $items = $this->updateItems(json_decode($response->getBody(), true), $items);
            } catch (Exception $e) {}

            sleep(0.5);
        }

        $this->natureRuneCost = isset($items[$this->natureRuneId]) ? $items[$this->natureRuneId]->getBuying() : 250;
        $items = $this->calculateItemInfo($items);

        return $items;
    }

    /**
     * @param array $json
     * @param Item[] $items
     * @return Item[]
     */
    private function updateItems(array $json, array $items)
    {
        foreach ($json as $key => $value) {
            $item = $items[$key];
            $item->setBuying($value['selling']);
            $item->setBuyingQuantity($value['buyingQuantity']);
            $item->setSelling($value['buying']);
            $item->setSellingQuantity($value['sellingQuantity']);
            $item->setOverall($value['overall']);
        }
        return $items;
    }

    /**
     * @param Item[] $items
     * @return Item[]
     */
    private function calculateItemInfo(array $items)
    {
        foreach ($items as $key => $item) {
            if ($item->getBuying() <= 0 || $item->getSelling() <= 0 || $item->getOverall() <= 0) {
                unset($items[$key]);
            } else {
                $item->setProfit($item->getHighAlchemyValue() - ($item->getBuying() + $this->natureRuneCost));
                $item->setHighestBuyPrice($item->getHighAlchemyValue() - $this->natureRuneCost);
                $item->setFlippingMargin($item->getSelling() - $item->getBuying());
            }
        }
        return $items;
    }

    /**
     * @param Item[] $items
     * @return string[]
     */
    private function buildUrls(array $items)
    {
        $urls = array();
        $url = $this->apiPath;
        $count = 0;

        foreach ($items as $item) {
            if ($count >= $this->maxQueries) {
                $urls[] = $url;
                $url = $this->apiPath;
                $count = 0;
            }
            $url .= '&i=' . $item->getId();
            $count += 1;
        }

        $url .= '&i=' . $this->natureRuneId;  // Add Nature Rune
        $urls[] = $url;

        $this->logger->info('UtilityRepository.buildUrls: Querying ' . sizeof($this->urls) . ' URLs');
        return $urls;
    }
}
