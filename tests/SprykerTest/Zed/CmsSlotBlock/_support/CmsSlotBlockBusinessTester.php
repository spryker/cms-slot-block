<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\CmsSlotBlock;

use Codeception\Actor;
use Generated\Shared\Transfer\CmsBlockTransfer;
use Generated\Shared\Transfer\CmsSlotBlockCollectionTransfer;
use Generated\Shared\Transfer\CmsSlotBlockCriteriaTransfer;
use Generated\Shared\Transfer\CmsSlotBlockTransfer;
use Generated\Shared\Transfer\CmsSlotTemplateTransfer;
use Generated\Shared\Transfer\CmsSlotTransfer;
use Generated\Shared\Transfer\StoreRelationTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use Orm\Zed\CmsBlock\Persistence\SpyCmsBlockQuery;
use Spryker\Zed\CmsSlotBlock\Business\CmsSlotBlockFacade;
use Spryker\Zed\CmsSlotBlock\Business\CmsSlotBlockFacadeInterface;

/**
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 * @method \Spryker\Zed\CmsSlotBlock\Business\CmsSlotBlockFacade getFacade()
 *
 * @SuppressWarnings(PHPMD)
 */
class CmsSlotBlockBusinessTester extends Actor
{
    use _generated\CmsSlotBlockBusinessTesterActions;

    /**
     * @var string
     */
    protected const STORE_NAME = 'DE';

    /**
     * @param int $blocksNumber
     * @param string $blockNamePattern
     *
     * @return array<\Generated\Shared\Transfer\CmsBlockTransfer>
     */
    public function createCmsBlocksInDb(int $blocksNumber = 1, string $blockNamePattern = ''): array
    {
        $storeTransfer = $this->haveStore([StoreTransfer::NAME => static::STORE_NAME]);
        $cmsBlockTransfers = [];

        $cmsBlockData = [
            CmsBlockTransfer::STORE_RELATION => [StoreRelationTransfer::ID_STORES => [$storeTransfer->getIdStore()]],
        ];

        for ($i = 0; $i < $blocksNumber; $i++) {
            if ($blockNamePattern !== '') {
                $cmsBlockData[CmsBlockTransfer::NAME] = $blockNamePattern . $i;
            }

            $cmsBlockTransfers[] = $this->haveCmsBlock($cmsBlockData);
        }

        return $cmsBlockTransfers;
    }

    /**
     * @param int $slotsNumber
     *
     * @return array<\Generated\Shared\Transfer\CmsSlotTransfer>
     */
    public function createCmsSlotsInDb(int $slotsNumber = 1): array
    {
        $cmsSlotTransfers = [];
        for ($i = 0; $i < $slotsNumber; $i++) {
            $cmsSlotTransfers[] = $this->haveCmsSlotInDb([
                CmsSlotTransfer::KEY => 'test-slt-' . $i,
            ]);
        }

        return $cmsSlotTransfers;
    }

    /**
     * @param int $slotTemplatesNumber
     *
     * @return array<\Generated\Shared\Transfer\CmsSlotTemplateTransfer>
     */
    public function createCmsSlotTemplatesInDb(int $slotTemplatesNumber = 1): array
    {
        $cmsSlotTemplateTransfers = [];
        for ($i = 0; $i < $slotTemplatesNumber; $i++) {
            $cmsSlotTemplateTransfers[] = $this->haveCmsSlotTemplateInDb([
                CmsSlotTemplateTransfer::PATH => 'test-path-' . $i,
            ]);
        }

        return $cmsSlotTemplateTransfers;
    }

    /**
     * @param int $idCmsSlotTemplate
     * @param int $idCmsSlot
     * @param int $idCmsBlock
     *
     * @return \Generated\Shared\Transfer\CmsSlotBlockTransfer
     */
    public function createCmsSlotBlockInDb(int $idCmsSlotTemplate, int $idCmsSlot, int $idCmsBlock): CmsSlotBlockTransfer
    {
        return $this->haveCmsSlotBlockInDb([
            CmsSlotBlockTransfer::ID_SLOT_TEMPLATE => $idCmsSlotTemplate,
            CmsSlotBlockTransfer::ID_SLOT => $idCmsSlot,
            CmsSlotBlockTransfer::ID_CMS_BLOCK => $idCmsBlock,
        ]);
    }

    /**
     * @param int $idCmsSlotTemplate
     * @param int $idCmsSlot
     *
     * @return \Generated\Shared\Transfer\CmsSlotBlockCriteriaTransfer
     */
    public function createCmsSlotBlockCriteriaTransfer(int $idCmsSlotTemplate, int $idCmsSlot): CmsSlotBlockCriteriaTransfer
    {
        return (new CmsSlotBlockCriteriaTransfer())
            ->setIdCmsSlotTemplate($idCmsSlotTemplate)
            ->setIdCmsSlot($idCmsSlot);
    }

    /**
     * @param int $idCmsSlotTemplate
     * @param int $idCmsSlot
     * @param int $idCmsBlock
     *
     * @return \Generated\Shared\Transfer\CmsSlotBlockTransfer
     */
    public function createCmsSlotBlockTransfer(int $idCmsSlotTemplate, int $idCmsSlot, int $idCmsBlock): CmsSlotBlockTransfer
    {
        return (new CmsSlotBlockTransfer())->setIdCmsBlock($idCmsBlock)
            ->setIdSlotTemplate($idCmsSlotTemplate)
            ->setIdSlot($idCmsSlot)
            ->setPosition(1);
    }

    /**
     * @param array<\Generated\Shared\Transfer\CmsSlotBlockTransfer> $cmsSlotBlockCollection
     *
     * @return \Generated\Shared\Transfer\CmsSlotBlockCollectionTransfer
     */
    public function createCmsSlotBlockCollectionTransfer(array $cmsSlotBlockCollection = []): CmsSlotBlockCollectionTransfer
    {
        $cmsSlotBlockCollectionTransfer = new CmsSlotBlockCollectionTransfer();
        foreach ($cmsSlotBlockCollection as $cmsSlotBlockTransfer) {
            $cmsSlotBlockCollectionTransfer->addCmsSlotBlock($cmsSlotBlockTransfer);
        }

        return $cmsSlotBlockCollectionTransfer;
    }

    /**
     * @return \Spryker\Zed\CmsSlotBlock\Business\CmsSlotBlockFacadeInterface
     */
    public function createCmsSlotBlockFacade(): CmsSlotBlockFacadeInterface
    {
        return new CmsSlotBlockFacade();
    }

    /**
     * @return int
     */
    public function getCmsBlockCount(): int
    {
        return SpyCmsBlockQuery::create()->count();
    }
}
