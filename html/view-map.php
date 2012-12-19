<?php
  /*
   * motes-info.php
   *
   * INPUTS: 
   *
   * OUTPUTS:
   *
   * FUNCTION:
   *
   * GOES:
   *
   * CREATED: 07 Jun 2004
   *
   * AUTHOR: Swies
   */

  include_once "nav/sitespecific.php";
  include_once "nav/phpdefaults.php";
  $floor = $_GET['floor'];
  $motes = $_GET['motes'];
  if (is_array($motes))
    $imgarg = implode(",", $motes);
  $radius = 10; /* radius of imagemap hotspots */

  global $_DSN;

  $DB = DB::connect($_DSN);

  if (DB::isError($DB)) {
    die ($DB->GetMessage());
  }

  $latestInfoQuery = "select UNIX_TIMESTAMP(created) as created" .
                     " from connectivity order by groupno desc" .
                     " limit 1";
  $latestInfoResult = doDBQuery($latestInfoQuery);
  $latestInfoRow = $latestInfoResult->fetchRow(DB_FETCHMODE_ASSOC);
  $latestInfo = date("j M Y \a\\t G:i:s", $latestInfoRow['created']);
?>

<html>
<head><title>Mote Map</title></head>
<body>

<img src="img/color-maps.php?floor=<?=$floor?>&motes=<?=$imgarg?>" usemap="#motemap" border=0>

<p>Map data collected on <?=$latestInfo?>

<form method="get" action="<?=$_SERVER['PHP_SELF']?>">
<select name="motes[]" size=8 multiple="true">

<?php
  $floorMotesQuery = "select moteid, pixelx, pixely from ".
                     "$_MOTESTABLENAME where floor=$floor";
  $floorMotesResult = doDBQuery($floorMotesQuery);
  while ($floorMotesRow = $floorMotesResult->fetchRow(DB_FETCHMODE_ASSOC)) {
    if (in_array($floorMotesRow['moteid'], $motes))
      print "<option selected ";
    else
      print "<option ";
    print "value=\"${floorMotesRow['moteid']}\">" . 
          "${floorMotesRow['moteid']}</option>\n";
  }
?>

</select>
<input type="hidden" name="floor" value="<?=$floor?>">
<input type="submit" value="Display only selected motes">
</form>

<map name="motemap">

<?php
  /* include extra image map hotspots for single mote viewing */
  if (is_array($motes) && count($motes) == 1) {
    $loneMote = $motes[0];
    $connectQuery = "select moteid, linkquality from " .
                    $_MOTESTABLENAME .
                    " where floor=" . $floor;
    $connect = doDBQueryAssoc($connectQuery);
    while (list($moteid, $connectinfo) = each($connect)) {
      $innerSplit = array();
      $innerSplit = explode("|", $connectinfo);
      $finalConnectInfo[$moteid] = array();
      foreach ($innerSplit as $currentInner) {
        $innerElement = sscanf($currentInner, "( %d, %f, %f )");
        if ($moteid == $loneMote || $innerElement[0] == $loneMote) {
          $motes = array_merge($motes, array($moteid, $innerElement[0]));
        }
      } 
    }
  }

  $floorMotesResult = doDBQuery($floorMotesQuery);
  while ($floorMotesRow = $floorMotesResult->fetchRow(DB_FETCHMODE_ASSOC)) {
    if (!is_array($motes) || in_array($floorMotesRow['moteid'], $motes))
      print "<area href=\"${_SERVER['PHP_SELF']}?floor=$floor&" .
            "motes[]=${floorMotesRow['moteid']}\" " .
            "alt=\"Show only mote ${floorMotesRow['moteid']}\" " .
            "shape=\"circle\" coords=\"" .
            "${floorMotesRow['pixelx']}, ${floorMotesRow['pixely']}," .
            "$radius\">\n"; 
  }
?>

</map>

</body>
</html>

<?php
  $DB->disconnect();
?>
