<?php
// tlds.php
// 
// Domain Manager - A web-based application written in PHP & MySQL used to manage a collection of domain names.
// Copyright (C) 2010 Greg Chetcuti
// 
// Domain Manager is free software; you can redistribute it and/or modify it under the terms of the GNU General
// Public License as published by the Free Software Foundation; either version 2 of the License, or (at your
// option) any later version.
// 
// Domain Manager is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the
// implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License
// for more details.
// 
// You should have received a copy of the GNU General Public License along with Domain Manager. If not, please 
// see http://www.gnu.org/licenses/
?>
<?php
session_start();

include("../_includes/config.inc.php");
include("../_includes/database.inc.php");
include("../_includes/software.inc.php");
include("../_includes/auth/auth-check.inc.php");

$page_title = "Top Level Domain Breakdown";
$software_section = "system";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$software_title?> :: <?=$page_title?></title>
<?php include("../_includes/head-tags.inc.php"); ?>
</head>
<body>
<?php include("../_includes/header.inc.php"); ?>
This is a breakdown of the Top Level Domains that are currently active in the system.
<BR><BR>
<?php
$sql = "SELECT tld, count(*) AS total_tld_count
		FROM domains
		WHERE active NOT IN ('0', '10')
		GROUP BY tld
		ORDER BY total_tld_count desc, tld asc";
$result = mysql_query($sql,$connection);
?>
<strong>Number of Active TLDs:</strong> <?=mysql_num_rows($result)?>
<?php 
if (mysql_num_rows($result) > 0) { ?>

    <BR><BR>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr height="30">
        <td width="100">
            <font class="subheadline">TLD</font>
        </td>
        <td>
            <font class="subheadline"># of Domains</font>
        </td>
    </tr>

    <?php 
	while ($row = mysql_fetch_object($result)) { ?>
        <tr height="20">
            <td>
                <?php echo ".$row->tld"; ?>
            </td>
            <td>
                <a class="nobold" href="../domains.php?tld=<?=$row->tld?>"><?=number_format($row->total_tld_count)?></a>
            </td>
        </tr>
    <?php 
	} ?>

    </table><?php 

} else {

	echo "<BR><BR>You must add some domains before your TLD breakdown will show up here."; 	

}
?>
<?php include("../_includes/footer.inc.php"); ?>
</body>
</html>