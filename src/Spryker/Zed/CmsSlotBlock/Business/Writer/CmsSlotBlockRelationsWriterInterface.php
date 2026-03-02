<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsSlotBlock\Business\Writer;

use Generated\Shared\Transfer\CmsSlotBlockCollectionTransfer;
use Generated\Shared\Transfer\CmsSlotBlockCriteriaTransfer;

interface CmsSlotBlockRelationsWriterInterface
{
    public function createCmsSlotBlockRelations(CmsSlotBlockCollectionTransfer $cmsSlotBlockCollectionTransfer): void;

    public function deleteCmsSlotBlockRelationsByCriteria(CmsSlotBlockCriteriaTransfer $cmsSlotBlockCriteriaTransfer): void;
}
