<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SslCertFieldData
 *
 * @ORM\Table(name="ssl_cert_field_data")
 * @ORM\Entity
 */
class SslCertFieldData
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
     * @ORM\Column(name="ssl_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $sslId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="insert_time", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_time", type="datetime", nullable=false)
     */
    private $updated;


}
