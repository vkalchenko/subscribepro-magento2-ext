<?php

namespace Swarming\SubscribePro\Gateway\Config;

class Config extends \Magento\Payment\Gateway\Config\Config
{
    const KEY_ACTIVE = 'active';
    const KEY_ACTIVE_NON_SUBSCRIPTION = 'active_non_subscription';
    const KEY_CC_TYPES = 'cctypes';
    const KEY_CC_TYPES_MAPPER = 'cctypes_mapper';
    const KEY_CC_USE_CCV = 'useccv';

    /**
     * @return bool
     */
    public function isActive()
    {
        return (bool) $this->getValue(self::KEY_ACTIVE);
    }

    /**
     * @return bool
     */
    public function hasVerification()
    {
        return (bool) $this->getValue(self::KEY_CC_USE_CCV);
    }

    /**
     * @return array
     */
    public function getAvailableCardTypes()
    {
        $ccTypes = $this->getValue(self::KEY_CC_TYPES);

        return !empty($ccTypes) ? explode(',', $ccTypes) : [];
    }

    /**
     * @return array
     */
    public function getCcTypesMapper()
    {
        $result = json_decode(
            $this->getValue(self::KEY_CC_TYPES_MAPPER),
            true
        );

        return is_array($result) ? $result : [];
    }

    /**
     * @param string $cardType
     * @return string
     */
    public function getMappedCcType($cardType)
    {
        $mapper = $this->getCcTypesMapper();
        return $cardType && isset($mapper[$cardType]) ? $mapper[$cardType] : $cardType;
    }
}
