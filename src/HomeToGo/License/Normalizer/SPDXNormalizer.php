<?php

namespace HomeToGo\License\Normalizer;

use Composer\Spdx\SpdxLicenses;

class SPDXNormalizer implements NormalizerInterface
{

    /**
     * @var SpdxLicenses|null
     */
    private $licenses;

    /**
     * {@inheritdoc}
     */
    public function normalize($license)
    {
        if ($this->getLicenses()->validate($license)) {
            return $this->getLicenses()->getIdentifierByName(
                $this->getLicenses()->getLicenseByIdentifier($license)[0]
            );
        }

        return $license;
    }

    /**
     * @return SpdxLicenses|null
     */
    private function getLicenses()
    {
        if ($this->licenses === null) {
            $this->licenses = new SpdxLicenses();
        }

        return $this->licenses;
    }
}
