<?php declare(strict_types=1);

namespace App\Slack\Builder;

use App\Milestone;
use App\Slack\Accessory;
use App\Slack\Block;

class XurBuilder extends AbstractBuilder
{
    /**
     * @param int $milestoneHash
     * @param array $milestoneData
     *
     * @return array|Block[]
     */
    public function buildBlocks(int $milestoneHash, array $milestoneData): array
    {
        $blocks = [];
        $milestone = Milestone::byBungieId($milestoneHash)->first();

        $blocks[] = Block::sectionWithImage(
            '*' . data_get(
                $milestone->json,
                'displayProperties.name'
            ) . "*\n\n" . data_get($milestone->json, 'displayProperties.description'),
            Accessory::makeInverted(
                'https://bungie.net' . data_get($milestone->json, 'displayProperties.icon'),
                data_get($milestone->json, 'displayProperties.description')
            )
        );

        foreach ($this->client->getXurInventory() as $inventoryItem) {
            $blocks[] = Block::sectionWithImage(
                '*' . data_get(
                    $inventoryItem->json,
                    'displayProperties.name'
                ) . "*\n\n" . data_get($inventoryItem->json, 'displayProperties.description'),
                Accessory::make(
                    'https://bungie.net' . data_get($inventoryItem->json, 'displayProperties.icon'),
                    data_get($inventoryItem->json, 'displayProperties.description')
                )
            );
        }

        $blocks[] = Block::divider();

        return $blocks;
    }
}
