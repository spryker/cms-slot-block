<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\CmsSlotBlock\Business;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\FilterTransfer;
use Orm\Zed\CmsBlock\Persistence\Map\SpyCmsBlockTableMap;
use Orm\Zed\CmsBlock\Persistence\SpyCmsBlockQuery;
use Spryker\Zed\CmsSlotBlock\Business\CmsSlotBlockBusinessFactory;
use Spryker\Zed\CmsSlotBlock\Business\CmsSlotBlockFacade;
use Spryker\Zed\CmsSlotBlock\Business\CmsSlotBlockFacadeInterface;
use Spryker\Zed\CmsSlotBlock\Persistence\CmsSlotBlockRepository;
use SprykerTest\Zed\CmsSlotBlock\CmsSlotBlockConfigTest;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group CmsSlotBlock
 * @group Business
 * @group Facade
 * @group CmsSlotBlockFacadeTest
 * Add your own group annotations below this line
 */
class CmsSlotBlockFacadeTest extends Unit
{
    /**
     * @var \SprykerTest\Zed\CmsSlotBlock\CmsSlotBlockBusinessTester
     */
    protected $tester;

    /**
     * @var \Spryker\Zed\CmsSlotBlock\Persistence\CmsSlotBlockRepository
     */
    protected $cmsSlotBlockRepository;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->cmsSlotBlockRepository = new CmsSlotBlockRepository();

        $this->tester->ensureCmsSlotBlockTableIsEmpty();
        $this->tester->ensureCmsSlotTableIsEmpty();
        $this->tester->ensureCmsSlotTemplateTableIsEmpty();
    }

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->tester->ensureCmsSlotBlockTableIsEmpty();
        $this->tester->ensureCmsSlotTableIsEmpty();
        $this->tester->ensureCmsSlotTemplateTableIsEmpty();
    }

    /**
     * @return void
     */
    public function testCreateCmsSlotBlockRelationsAddsNewRelations(): void
    {
        // Arrange
        $cmsBlockTransfers = $this->tester->createCmsBlocksInDb(3);
        $cmsSlotTransfers = $this->tester->createCmsSlotsInDb(2);
        $cmsSlotTemplateTransfers = $this->tester->createCmsSlotTemplatesInDb(2);

        $idCmsBlock1 = $cmsBlockTransfers[0]->getIdCmsBlock();
        $idCmsBlock2 = $cmsBlockTransfers[1]->getIdCmsBlock();
        $idCmsBlock3 = $cmsBlockTransfers[2]->getIdCmsBlock();
        $idCmsSlot1 = $cmsSlotTransfers[0]->getIdCmsSlot();
        $idCmsSlot2 = $cmsSlotTransfers[1]->getIdCmsSlot();
        $idCmsSlotTemplate1 = $cmsSlotTemplateTransfers[0]->getIdCmsSlotTemplate();
        $idCmsSlotTemplate2 = $cmsSlotTemplateTransfers[1]->getIdCmsSlotTemplate();

        $cmsSlotBlockTransfer1_1 = $this->tester->createCmsSlotBlockTransfer($idCmsSlotTemplate1, $idCmsSlot1, $idCmsBlock1);
        $cmsSlotBlockTransfer1_2 = $this->tester->createCmsSlotBlockTransfer($idCmsSlotTemplate1, $idCmsSlot1, $idCmsBlock2);
        $cmsSlotBlockTransfer2 = $this->tester->createCmsSlotBlockTransfer($idCmsSlotTemplate2, $idCmsSlot2, $idCmsBlock3);
        $cmsSlotBlockCollectionTransfer = $this->tester->createCmsSlotBlockCollectionTransfer([
            $cmsSlotBlockTransfer1_1,
            $cmsSlotBlockTransfer1_2,
            $cmsSlotBlockTransfer2,
        ]);

        // Act
        $this->tester->createCmsSlotBlockFacade()->createCmsSlotBlockRelations($cmsSlotBlockCollectionTransfer);

        $cmsSlotBlocks1 = $this->cmsSlotBlockRepository->getCmsSlotBlocks(
            $this->tester->createCmsSlotBlockCriteriaTransfer($idCmsSlotTemplate1, $idCmsSlot1)
        )->getCmsSlotBlocks();
        $cmsSlotBlocks2 = $this->cmsSlotBlockRepository->getCmsSlotBlocks(
            $this->tester->createCmsSlotBlockCriteriaTransfer($idCmsSlotTemplate2, $idCmsSlot2)
        )->getCmsSlotBlocks();

        $cmsSlotBlockTransferFromDb1_1 = $cmsSlotBlocks1[0];
        $cmsSlotBlockTransferFromDb1_2 = $cmsSlotBlocks1[1];
        $cmsSlotBlockTransferFromDb2 = $cmsSlotBlocks2[0];

        $cmsSlotBlockTransfer1_1->setIdCmsSlotBlock($cmsSlotBlockTransferFromDb1_1->getIdCmsSlotBlock());
        $cmsSlotBlockTransfer1_2->setIdCmsSlotBlock($cmsSlotBlockTransferFromDb1_2->getIdCmsSlotBlock());
        $cmsSlotBlockTransfer2->setIdCmsSlotBlock($cmsSlotBlockTransferFromDb2->getIdCmsSlotBlock());

        // Assert
        $this->assertCount(2, $cmsSlotBlocks1);
        $this->assertCount(1, $cmsSlotBlocks2);
        $this->assertEquals($cmsSlotBlockTransfer1_1, $cmsSlotBlockTransferFromDb1_1);
        $this->assertEquals($cmsSlotBlockTransfer1_2, $cmsSlotBlockTransferFromDb1_2);
        $this->assertEquals($cmsSlotBlockTransfer2, $cmsSlotBlockTransferFromDb2);
    }

    /**
     * @return void
     */
    public function testDeleteCmsSlotBlockRelationsByCriteriaRemovesRelations(): void
    {
        // Arrange
        $cmsBlockTransfers = $this->tester->createCmsBlocksInDb(2);

        $idCmsBlock1 = $cmsBlockTransfers[0]->getIdCmsBlock();
        $idCmsBlock2 = $cmsBlockTransfers[1]->getIdCmsBlock();
        $idCmsSlot = $this->tester->createCmsSlotsInDb()[0]->getIdCmsSlot();
        $idCmsSlotTemplate = $this->tester->createCmsSlotTemplatesInDb()[0]->getIdCmsSlotTemplate();

        $this->tester->createCmsSlotBlockInDb($idCmsSlotTemplate, $idCmsSlot, $idCmsBlock1);
        $this->tester->createCmsSlotBlockInDb($idCmsSlotTemplate, $idCmsSlot, $idCmsBlock2);

        // Act
        $cmsSlotBlockCriteriaTransfer = $this->tester->createCmsSlotBlockCriteriaTransfer($idCmsSlotTemplate, $idCmsSlot);
        $this->tester->createCmsSlotBlockFacade()->deleteCmsSlotBlockRelationsByCriteria($cmsSlotBlockCriteriaTransfer);
        $cmsSlotBlocks = $this->cmsSlotBlockRepository->getCmsSlotBlocks($cmsSlotBlockCriteriaTransfer)->getCmsSlotBlocks();

        // Assert
        $this->assertCount(0, $cmsSlotBlocks);
    }

    /**
     * @return void
     */
    public function testGetCmsSlotBlockCollectionReturnsCorrectData(): void
    {
        // Arrange
        $cmsBlockTransfers = $this->tester->createCmsBlocksInDb(2);
        $idCmsBlock1 = $cmsBlockTransfers[0]->getIdCmsBlock();
        $idCmsBlock2 = $cmsBlockTransfers[1]->getIdCmsBlock();
        $idCmsSlot = $this->tester->createCmsSlotsInDb()[0]->getIdCmsSlot();
        $idCmsSlotTemplate = $this->tester->createCmsSlotTemplatesInDb()[0]->getIdCmsSlotTemplate();

        $cmsSlotBlockTransfer1 = $this->tester->createCmsSlotBlockInDb($idCmsSlotTemplate, $idCmsSlot, $idCmsBlock1);
        $cmsSlotBlockTransfer2 = $this->tester->createCmsSlotBlockInDb($idCmsSlotTemplate, $idCmsSlot, $idCmsBlock2);
        $cmsSlotBlockCriteriaTransfer = $this->tester->createCmsSlotBlockCriteriaTransfer($idCmsSlotTemplate, $idCmsSlot);

        // Act
        $cmsSlotBlocks = $this->tester->createCmsSlotBlockFacade()->getCmsSlotBlockCollection(
            $cmsSlotBlockCriteriaTransfer
        )->getCmsSlotBlocks();

        // Assert
        $this->assertCount(2, $cmsSlotBlocks);
        $this->assertEquals($cmsSlotBlockTransfer1->toArray(), $cmsSlotBlocks[0]->toArray());
        $this->assertEquals($cmsSlotBlockTransfer2->toArray(), $cmsSlotBlocks[1]->toArray());
    }

    /**
     * @return void
     */
    public function testGetCmsSlotBlockCollectionReturnsEmptyCollectionIfRelationsDoNotExist(): void
    {
        // Arrange
        $cmsSlotBlockCriteriaTransfer = $this->tester->createCmsSlotBlockCriteriaTransfer(1, 1);

        // Act
        $cmsSlotBlocks = $this->tester->createCmsSlotBlockFacade()
            ->getCmsSlotBlockCollection($cmsSlotBlockCriteriaTransfer)
            ->getCmsSlotBlocks();

        // Assert
        $this->assertCount(0, $cmsSlotBlocks);
    }

    /**
     * @return void
     */
    public function testGetTemplateConditionsByPathIsSuccessful(): void
    {
        //Act
        $templateConditionsAssignment = $this->createCmsSlotBlockFacade()
            ->getTemplateConditionsByPath('@Test/test/test/test.twig');

        //Assert
        $this->assertIsArray($templateConditionsAssignment);
        $this->assertEquals(['test'], $templateConditionsAssignment);
    }

    /**
     * @return void
     */
    public function testGetTemplateConditionsByPathIsFailed(): void
    {
        //Act
        $templateConditionsAssignment = $this->createCmsSlotBlockFacade()
            ->getTemplateConditionsByPath('@Test/test/test/test2.twig');

        //Assert
        $this->assertIsArray($templateConditionsAssignment);
        $this->assertEmpty($templateConditionsAssignment);
    }

    /**
     * @return void
     */
    public function testGetCmsBlocksWithSlotRelationsReturnsDataWithCorrectLimit(): void
    {
        // Arrange
        $countCmsBlocks = SpyCmsBlockQuery::create()->count();
        $this->tester->createCmsBlocksInDb();
        $filterTransfer = (new FilterTransfer())->setLimit($countCmsBlocks + 1);

        // Act
        $cmsBlockTransfers = $this->tester->createCmsSlotBlockFacade()->getCmsBlocksWithSlotRelations($filterTransfer);

        // Assert
        $this->assertCount($countCmsBlocks, $cmsBlockTransfers);
    }

    /**
     * @return void
     */
    public function testGetCmsBlocksWithSlotRelationsReturnsDataWithCorrectOffset(): void
    {
        // Arrange
        $countCmsBlocks = SpyCmsBlockQuery::create()->count();
        $this->tester->createCmsBlocksInDb();
        $filterTransfer = (new FilterTransfer())->setOffset($countCmsBlocks - 1);

        // Act
        $cmsBlockTransfers = $this->tester->createCmsSlotBlockFacade()->getCmsBlocksWithSlotRelations($filterTransfer);

        // Assert
        $this->assertCount(1, $cmsBlockTransfers);
    }

    /**
     * @return void
     */
    public function testGetCmsBlocksWithSlotRelationsReturnsDataWithOrderAsc(): void
    {
        // Arrange
        $cmsBlockTransfer = $this->tester->createCmsBlocksInDb(2)[1];
        $filterTransfer = (new FilterTransfer())
            ->setOrderBy(SpyCmsBlockTableMap::COL_ID_CMS_BLOCK)
            ->setOrderDirection('ASC');

        // Act
        $cmsBlockTransfers = $this->tester->createCmsSlotBlockFacade()->getCmsBlocksWithSlotRelations($filterTransfer);
        $lastCmsBlockTransfer = $cmsBlockTransfers[count($cmsBlockTransfers) - 1];

        // Assert
        $this->assertEquals($cmsBlockTransfer->getIdCmsBlock(), $lastCmsBlockTransfer->getIdCmsBlock());
    }

    /**
     * @return void
     */
    public function testGetCmsBlocksWithSlotRelationsReturnsDataWithOrderDesc(): void
    {
        // Arrange
        $cmsBlockTransfer = $this->tester->createCmsBlocksInDb(2)[1];
        $filterTransfer = (new FilterTransfer())
            ->setOrderBy(SpyCmsBlockTableMap::COL_ID_CMS_BLOCK)
            ->setOrderDirection('DESC');

        // Act
        $cmsBlockTransfers = $this->tester->createCmsSlotBlockFacade()->getCmsBlocksWithSlotRelations($filterTransfer);

        // Assert
        $this->assertEquals($cmsBlockTransfer->getIdCmsBlock(), $cmsBlockTransfers[0]->getIdCmsBlock());
    }

    /**
     * @return \Spryker\Zed\CmsSlotBlock\Business\CmsSlotBlockFacadeInterface
     */
    protected function createCmsSlotBlockFacade(): CmsSlotBlockFacadeInterface
    {
        $factory = new CmsSlotBlockBusinessFactory();
        $config = new CmsSlotBlockConfigTest();
        $factory->setConfig($config);

        $facade = new CmsSlotBlockFacade();
        $facade->setFactory($factory);

        return $facade;
    }
}
