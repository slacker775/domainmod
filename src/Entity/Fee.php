<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fees
 *
 * @ORM\Table(name="fees")
 * @ORM\Entity
 */
class Fee
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="registrar_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $registrarId;

    /**
     * @var string
     *
     * @ORM\Column(name="tld", type="string", length=50, nullable=false)
     */
    private $tld;

    /**
     * @var string
     *
     * @ORM\Column(name="initial_fee", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $initialFee;

    /**
     * @var string
     *
     * @ORM\Column(name="renewal_fee", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $renewalFee;

    /**
     * @var string
     *
     * @ORM\Column(name="transfer_fee", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $transferFee;

    /**
     * @var string
     *
     * @ORM\Column(name="privacy_fee", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $privacyFee;

    /**
     * @var string
     *
     * @ORM\Column(name="misc_fee", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $miscFee;

    /**
     * @var int
     *
     * @ORM\Column(name="currency_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $currencyId;

    /**
     * @var bool
     *
     * @ORM\Column(name="fee_fixed", type="boolean", nullable=false)
     */
    private $feeFixed = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="insert_time", type="datetime", nullable=false, options={"default"="'1970-01-01 00:00:00'"})
     */
    private $insertTime = '\'1970-01-01 00:00:00\'';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_time", type="datetime", nullable=false, options={"default"="'1970-01-01 00:00:00'"})
     */
    private $updateTime = '\'1970-01-01 00:00:00\'';


}
