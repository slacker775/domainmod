This is a ground-up re-write of DomainMod - https://github.com/domainmod/domainmod - by Greg Chetcuti.

The purpose of the re-write was to leverage modern frameworks and libraries to remove
all of the painful coding required for DB access, maintaining relationships, etc.

This version is built on Symfony 5, Doctrine 2 and AdminLTE 3.

There are also plans to add more capabilities such as:

Domain Monitoring via API/whois - has a domain been updated at a registrar but not via the app?  Let's know that and update expirations

SSL Certificate revocation/renewal - lets leverage things like OCSP to verify that a cert is still valid

Utilize work queue framework to provide back-end processing without requiring cron jobs which can wind up having jobs
call an API numerous times, exhausting quotas.

Potentially add URL and IP subnet support.  For a large, multi-national organization, you need to track
URLs used (a different URL may be a different application), and IP subnet allocations globally.  This information
is required for asset purchase/divestiture, penetration tests, etc.
