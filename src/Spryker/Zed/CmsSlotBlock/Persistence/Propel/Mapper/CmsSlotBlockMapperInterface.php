<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsSlotBlock\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\CmsBlockCollectionTransfer;
use Generated\Shared\Transfer\CmsSlotBlockCollectionTransfer;
use Generated\Shared\Transfer\CmsSlotBlockTransfer;
use Orm\Zed\CmsSlotBlock\Persistence\SpyCmsSlotBlock;
use Propel\Runtime\Collection\Collection;

interface CmsSlotBlockMapperInterface
{
    public function mapCmsSlotBlockTransferToEntity(
        CmsSlotBlockTransfer $cmsSlotBlockTransfer,
        SpyCmsSlotBlock $cmsSlotBlockEntity
    ): SpyCmsSlotBlock;

    public function mapCmsSlotBlockEntityCollectionToTransferCollection(
        Collection $cmsSlotBlockEntities,
        CmsSlotBlockCollectionTransfer $cmsSlotBlockCollectionTransfer
    ): CmsSlotBlockCollectionTransfer;

    /**
     * @param \Propel\Runtime\Collection\Collection $cmsBlockEntities
     *
     * @return array<\Generated\Shared\Transfer\CmsBlockTransfer>
     */
    public function mapCmsBlockEntitiesToTransfers(Collection $cmsBlockEntities): array;

    public function mapCmsBlockEntitiesToCmsBlockCollectionTransfer(
        Collection $cmsBlockEntities,
        CmsBlockCollectionTransfer $cmsBlockCollectionTransfer
    ): CmsBlockCollectionTransfer;
}
