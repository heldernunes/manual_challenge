<?php

namespace App\Service\Product;

use App\Model\Request\MedicationReqModel;
use App\Model\Request\QuestionnaireResponseCollectionModel;

class ProductExclusionVoter
{
    public string $exclusionDetails;

    private array $exclusions;

    /**
     * @param array $exclusions
     *
     * @return \App\Service\Product\ProductExclusionVoter
     */
    public function setExclusions(array $exclusions): static
    {
        $this->exclusions = $exclusions;

        return $this;
    }

    /**
     * @return string
     */
    public function getExclusionDetails(): string
    {
        return $this->exclusionDetails;
    }

    /**
     * @param string $exclusionDetails
     *
     * @return $this
     */
    public function setExclusionDetails(string $exclusionDetails): ProductExclusionVoter
    {
        $this->exclusionDetails = $exclusionDetails;
        return $this;
    }

    /**
     * @param \App\Model\Request\QuestionnaireResponseCollectionModel $responses
     *
     * @return bool
     */
    public function vote(QuestionnaireResponseCollectionModel &$responses): bool
    {
        foreach ($responses as $key => $response) {
            $answerId = $response->getAnswerId();
            if ($this->hasExcludeAllRestriction($answerId)) {
                return false;
            }
            if (isset($this->exclusions[$answerId])) {
                $responses->offsetUnset($key);
            }
        }

        return true; // Continue the flow if no 'exclude_all' restrictions are found
    }

    /**
     * @param int $answerId
     *
     * @return bool
     */
    private function hasExcludeAllRestriction(int $answerId): bool
    {
        /** @var \App\Entity\QuestionAnswerRestriction $restriction */
        foreach ($this->exclusions as $restriction) {
            if ($restriction->getAnswerId() === $answerId && $restriction->getExclusionType() === 'exclude_all') {
                $this->setExclusionDetails($restriction->getExclusionDetails());
                return true;
            }
        }
        return false;
    }
}
