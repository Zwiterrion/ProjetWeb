<?php

// retourne correspondance entre les chaînes a et b (0 à 1)
// méthode très tolérante, marche mal sur des grandes chaînes 
function fit($a, $b)
{
  $a = iconv("UTF-8", "ASCII//TRANSLIT//IGNORE", $a);
  $b = iconv("UTF-8", "ASCII//TRANSLIT//IGNORE", $b);

  $aCount = strlen($a);
  $bCount = strlen($a);

  $aPos = charPos($a);
  $bPos = charPos($b);

  if (count($aPos) == 0 or count($bPos) == 0)
    return 0;

  $aCharFit = 1 - (filter($aPos, $bPos) / (float) $aCount);
  $bCharFit = 1 - (filter($bPos, $aPos) / (float) $bCount);
  $charFit = max($aCharFit, $bCharFit);

  $avg = avgShift($aPos, $bPos, 0, 'identity');

  $shiftFit1 = 1 - (avgShift($aPos, $bPos, $avg, 'abs') / (float) max($aCount,$bCount));
  $shiftFit2 = 1 - (avgShift($aPos, $bPos, 0, 'abs')    / (float) max($aCount,$bCount));
  $shiftFit = max($shiftFit1, $shiftFit2);

  return 0.4 * $charFit + 0.6 * $shiftFit;
}

function avgShift($aPos, $bPos, $shift, $f)
{
  $sum = 0;
  $count = 0;

  foreach($aPos as $c => $aPos_)
  {
    $bPos_ = $bPos[$c];

    foreach($aPos_ as $i => $p1)
    {
      if (! isset($bPos_[$i]))
	break;

      $sum += $f($p1 - $bPos_[$i] - $shift);
      $count++;
    }
  }

  return $sum / (float) $count;
}
function identity($x) { return $x; };

function charPos($str)
{
  $res = [];
  for ($i=0; $i<strlen($str); $i++)
  {
    $c = $str[$i];
    if (! isset($res[$c]))
      $res[$c] = [];

    array_push($res[$c], $i);
  }

  return $res;
}

function filter(&$array, $filter)
{
  $count = 0;
  foreach($array as $k => $v)
  {
    if (! array_key_exists($k, $filter))
    {
      $count += count($v);
      unset($array[$k]);
    }
  }

  return $count;
}


