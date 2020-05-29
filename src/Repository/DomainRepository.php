<?php
namespace App\Repository;

use App\Entity\Domain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class DomainRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Domain::class);
    }

    public function getActiveDomainCount(): int
    {
        $query = $this->getEntityManager()->createQuery("SELECT count(d) FROM App\Entity\Domain d WHERE d.active NOT IN ('0','10')");
        return $query->getSingleScalarResult();
    }

    public function getDomainCountByStatus(int $status): int
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT count(d) FROM App\Entity\Domain d WHERE d.active = :status")
            ->setParameter('status', $status);
        return $query->getSingleScalarResult();
    }
    
    public function getDomainTotalCost(): float
    {
        $query = $this->getEntityManager()->createQuery("SELECT SUM(d.total_cost * cc.conversion) FROM App\Entity\Domain d JOIN d.cat");
        
        return $query->getSingleScalarResult();
        
        $grand_total = $pdo->query("
    SELECT SUM(d.total_cost * cc.conversion)
    FROM domains AS d, registrar_accounts AS ra, registrars AS r, owners AS o, categories AS cat, 
fees AS f, currencies AS c, currency_conversions AS cc, dns AS dns, ip_addresses AS ip, hosting AS h
    WHERE d.account_id = ra.id
      AND ra.registrar_id = r.id
      AND ra.owner_id = o.id
      AND d.cat_id = cat.id
      AND d.fee_id = f.id
      AND d.dns_id = dns.id
      AND d.ip_id = ip.id
      AND d.hosting_id = h.id
      AND f.currency_id = c.id
      AND c.id = cc.currency_id
      AND cc.user_id = '" . $_SESSION['s_user_id'] . "'
      $is_active_string
      $segid_string
      $pcid_string
      $oid_string
      $dnsid_string
      $ipid_string
      $whid_string
      $rid_string
      $raid_string
      $range_string
      $tld_string
      $search_string")->fetchColumn();
    }
}