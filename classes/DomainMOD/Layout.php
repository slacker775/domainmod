<?php
/**
 * /classes/DomainMOD/Layout.php
 *
 * This file is part of DomainMOD, an open source domain and internet asset manager.
 * Copyright (C) 2010-2015 Greg Chetcuti <greg@chetcuti.com>
 *
 * Project: http://domainmod.org   Author: http://chetcuti.com
 *
 * DomainMOD is free software: you can redistribute it and/or modify it under the terms of the GNU General Public
 * License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later
 * version.
 *
 * DomainMOD is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with DomainMOD. If not, see
 * http://www.gnu.org/licenses/.
 *
 */
?>
<?php
namespace DomainMOD;

class Layout
{

    public function pageBrowser($parameters)
    {

        list($totalrows, $numLimit, $amm, $queryStr, $numBegin, $begin, $num) = $parameters;

        $larrow = "&nbsp;&laquo; Prev &nbsp;";
        $rarrow = "&nbsp;Next &raquo;&nbsp;";
        $wholePiece = "<B>Page:</B> ";

        if ($totalrows > 0) {

            $numSoFar = 1;
            $cycle = ceil($totalrows / $amm);

            if (!isset($numBegin) || $numBegin < 1) {
                $numBegin = 1;
                $num = 1;
            }

            $minus = $numBegin - 1;
            $start = $minus * $amm;

            if (!isset($begin)) {
                $begin = $start;
            }

            $preBegin = $numBegin - $numLimit;
            $preVBegin = $start - $amm;
            $preRedBegin = $numBegin - 1;

            if ($start > 0 || $numBegin > 1) {

                $wholePiece .= "<a href='?num=" . $preRedBegin
                    . "&numBegin=" . $preBegin
                    . "&begin=" . $preVBegin
                    . $queryStr . "'>"
                    . $larrow . "</a>\n";

            }

            for ($i = $numBegin; $i <= $cycle; $i++) {

                if ($numSoFar == $numLimit + 1) {

                    $piece = "<a href='?numBegin=" . $i
                        . "&num=" . $i
                        . "&begin=" . $start
                        . $queryStr . "'>"
                        . $rarrow . "</a>\n";
                    $wholePiece .= $piece;
                    break;

                }

                $piece = "<a href='?begin=" . $start
                    . "&num=" . $i
                    . "&numBegin=" . $numBegin
                    . $queryStr
                    . "'>";

                if ($num == $i) {
                    $piece .= "</a><b>$i</b><a>";
                } else {
                    $piece .= "$i";
                }

                $piece .= "</a>\n";
                $start = $start + $amm;
                $numSoFar++;
                $wholePiece .= $piece;

            }

            $wholePiece .= "\n";
            $wheBeg = $begin + 1;
            $wheEnd = $begin + $amm;
            $wheToWhe = "<b>" . number_format($wheBeg) . "</b>-<b>";

            if ($totalrows <= $wheEnd) {
                $wheToWhe .= $totalrows . "</b>";
            } else {
                $wheToWhe .= number_format($wheEnd) . "</b>";
            }

            $sqlprod = " LIMIT " . $begin . ", " . $amm;

        } else {

            $wholePiece = "";
            $wheToWhe = "<b>0</b> - <b>0</b>";
            $sqlprod = "";

        }

        return array($sqlprod, $wheToWhe, $wholePiece);

    }

    public function assetBlock()
    {
        ob_start(); ?>
        <div class="asset-management-block-outer">
            <div class="asset-management-block-left">
                <div class="subheadline">Domains</div><BR>
                <a href="registrars.php">Domain Registrars</a><BR>
                <a href="registrar-accounts.php">Domain Registrar Accounts</a><BR>
                <a href="dns.php">DNS Profiles</a><BR>
                <a href="hosting.php">Web Hosting Providers</a>
            </div>
            <div class="asset-management-block-center">
                <div class="subheadline">SSL Certificates</div><BR>
                <a href="ssl-providers.php">SSL Providers</a><BR>
                <a href="ssl-accounts.php">SSL Provider Accounts</a><BR>
                <a href="ssl-types.php">SSL Certificate Types</a>
            </div>
            <div class="asset-management-block-right">
                <div class="subheadline">Shared</div><BR>
                <a href="account-owners.php">Account Owners</a><BR>
                <a href="categories.php">Categories</a><BR>
                <a href="ip-addresses.php">IP Addresses</a>
            </div>
        </div>
        <div style="clear: both;"></div><?php

        return ob_get_clean();
    }

    public function jumpMenu()
    {

        ob_start(); ?>

        <script type="text/javascript">
            <!--
            function MM_jumpMenu(targ, selObj, restore) { //v3.0
                eval(targ + ".location='" + selObj.options[selObj.selectedIndex].value + "'");
                if (restore) selObj.selectedIndex = 0;
            }
            //-->
        </script><?php

        return ob_get_clean();

    }

}
