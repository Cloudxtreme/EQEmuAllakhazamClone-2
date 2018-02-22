<?php

$name = (isset($_GET['name']) ? addslashes($_GET['name']) : '');

$page_title = "Pet :: $name";

$query = "
    SELECT
        $npc_types_table.*
    FROM
        $npc_types_table
    WHERE
        $npc_types_table.`name` = '$name'
    LIMIT 1
";
$result = db_mysql_query($query) or message_die('npc.php', 'MYSQL_QUERY', $query, $db->mysql_error());
$npc = $db->mysql_fetch_array($result);

$print_buffer .= "<table class='container_div' style='width:500px'><tr valign=top><td>";
if (file_exists($npcs_dir . $item_id . ".jpg")) {
    $print_buffer .= "<img src=" . $npcs_dir . $item_id . ".jpg>";
}
$print_buffer .= "<p><table>";
$print_buffer .= "
    <tr>
        <td style='text-align:right;width:200px !important'><b>Full name</b></td>
        <td>" . str_replace("_", " ", $npc["name"]);
if ($npc["lastname"] != "") {
    $print_buffer .= str_replace("_", " ", " (" . $npc["lastname"] . ")");
}
$print_buffer .= "</td></tr>";
$print_buffer .= "<tr><td style='text-align:right'  ><b>Level</b></td><td>" . $npc["level"] . "</td></tr>";
$print_buffer .= "<tr><td style='text-align:right' ><b>Race</b></td><td>" . $dbiracenames[$npc["race"]] . "</td></tr>";
$print_buffer .= "<tr><td style='text-align:right' ><b>Class</b></td><td>" . $dbclasses[$npc["class"]] . "</td></tr>";
$print_buffer .= "<tr><td style='text-align:right' ><b>HP</b></td><td>" . $npc["hp"] . "</td></tr>";
$print_buffer .= "<tr><td style='text-align:right' ><b>Damage</b></td><td>" . $npc["mindmg"] . " to " . $npc["maxdmg"] . "</td></tr>";
$print_buffer .= "<tr><td style='text-align:right' ><b>HP Regen</b></td><td>" . $npc["hp_regen_rate"] . " Per Tick</td></tr>";
$print_buffer .= "<tr><td style='text-align:right' ><b>Mana Regen</b></td><td>" . $npc["mana_regen_rate"] . " Per Tick</td></tr>";

$print_buffer .= "<tr><td style='text-align:right' ><b>Strength</b></td><td>" . $npc["STR"] . "</td></tr>";
$print_buffer .= "<tr><td style='text-align:right' ><b>Stamina</b></td><td>" . $npc["STA"] . "</td></tr>";
$print_buffer .= "<tr><td style='text-align:right' ><b>Dexterity</b></td><td>" . $npc["DEX"] . "</td></tr>";
$print_buffer .= "<tr><td style='text-align:right' ><b>Agility</b></td><td>" . $npc["AGI"] . "</td></tr>";
$print_buffer .= "<tr><td style='text-align:right' ><b>Intelligence</b></td><td>" . $npc["_INT"] . "</td></tr>";
$print_buffer .= "<tr><td style='text-align:right' ><b>Wisdom</b></td><td>" . $npc["WIS"] . "</td></tr>";
$print_buffer .= "<tr><td style='text-align:right' ><b>Charisma</b></td><td>" . $npc["CHA"] . "</td></tr>";
$print_buffer .= "<tr><td style='text-align:right' ><b>Magic Resist</b></td><td>" . $npc["MR"] . "</td></tr>";
$print_buffer .= "<tr><td style='text-align:right' ><b>Fire Resist</b></td><td>" . $npc["FR"] . "</td></tr>";
$print_buffer .= "<tr><td style='text-align:right' ><b>Cold Resist</b></td><td>" . $npc["CR"] . "</td></tr>";
$print_buffer .= "<tr><td style='text-align:right' ><b>Disease Resist</b></td><td>" . $npc["DR"] . "</td></tr>";
$print_buffer .= "<tr><td style='text-align:right' ><b>Poison Resist</b></td><td>" . $npc["PR"] . "</td></tr>";


if ($npc["npcspecialattks"] != '') {
    $print_buffer .= "<tr><td style='text-align:right'><b>Special Attacks</b></td><td>" . SpecialAttacks($npc["npcspecialattks"]) . "</td></tr>";
}

$print_buffer .= "</tr></table>";

$print_buffer .= "</td><td width=0% nowrap>"; // right column

$print_buffer .= "<tr><td colspan=2></td><tr>";

$print_buffer .= "<tr valign=top>";

if ($npc["npc_spells_id"] > 0) {
    $query = "SELECT * FROM $npc_spells_table WHERE id=" . $npc["npc_spells_id"];
    $result = db_mysql_query($query) or message_die('npc.php', 'MYSQL_QUERY', $query, $db->mysql_error());
    if ($db->mysql_num_rows($result) > 0) {
        $g = $db->mysql_fetch_array($result);
        $print_buffer .= "<td colspan='2'>
            <h2 class='section_header'>This pet casts the following spells</h2>
        ";
        $query = "
            SELECT
                $npc_spells_entries_table.spellid
            FROM
                $npc_spells_entries_table
            WHERE
                $npc_spells_entries_table.npc_spells_id = " . $npc["npc_spells_id"] . "
            AND $npc_spells_entries_table.minlevel <= " . $npc["level"] . "
            AND $npc_spells_entries_table.maxlevel >= " . $npc["level"] . "
            ORDER BY
                $npc_spells_entries_table.priority DESC
        ";
        $result2 = db_mysql_query($query) or message_die('npc.php', 'MYSQL_QUERY', $query, $db->mysql_error());

        $print_buffer .= '<ul>';
        if ($db->mysql_num_rows($result2) > 0) {
            $print_buffer .= "<li><b>Listname</b> " . $g["name"];
            if ($g["attack_proc"] == 1) {
                $print_buffer .= " (Procs)";
            }
            $print_buffer .= "</ll>";
            while ($row = $db->mysql_fetch_array($result2)) {
                $spell = getspell($row["spellid"]);
                $print_buffer .= "<li><a href=?a=spell&id=" . $row["spellid"] . ">" . $spell["name"] . "</a></li>";
            }
        }
        $print_buffer .= '</ul>';
        $print_buffer .= "</td></tr></table></td>";
    }
}

$print_buffer .= "</td></tr></table><p>";


?>