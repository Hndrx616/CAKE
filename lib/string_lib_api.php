<?php
//*******************************************************************
//Template Name: String_Lib_API.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
//*******************************************************************
//Aho-Corasick
$MaxStates = 6 * 50 + 10;
$MaxChars = 26;

$Out = array();
$FF = array();
$GF = array();

function BuildMatchingMachine($words, $lowestChar = 'a', $highestChar = 'z')
{
	global $Out, $FF, $GF, $MaxStates, $MaxChars;
	
	$Out = array_fill(0, $MaxStates, 0);
	$FF = array_fill(0, $MaxStates, -1);

	for ($i = 0; $i < $MaxStates; $i++)
	{
		for ($j = 0; $j < $MaxChars; $j++)
		{
			$GF[$i][$j] = -1;
		}
	}

	$states = 1;

	for ($i = 0; $i < count($words); $i++)
	{
		$keyword = $words[$i];
		$currentState = 0;

		for ($j = 0; $j < strlen($keyword); $j++)
		{
			$c = ord($keyword[$j]) - ord($lowestChar);

			if ($GF[$currentState][$c] == -1)
			{
				$GF[$currentState][$c] = $states++;
			}

			$currentState = $GF[$currentState][$c];
		}

		$Out[$currentState] |= (1 << $i);
	}

	for ($c = 0; $c < $MaxChars; $c++)
	{
		if ($GF[0][$c] == -1)
		{
			$GF[0][$c] = 0;
		}
	}

	$q = array();
	for ($c = 0; $c <= ord($highestChar) - ord($lowestChar); $c++)
	{
		if ($GF[0][$c] != -1 && $GF[0][$c] != 0)
		{
			$FF[$GF[0][$c]] = 0;
			$q[] = $GF[0][$c];
		}
	}

	while (count($q))
	{
		$state = $q[0];
		unset($q[0]);
		$q = array_values($q);

		for ($c = 0; $c <= ord($highestChar) - ord($lowestChar); $c++)
		{
			if ($GF[$state][$c] != -1)
			{
				$failure = $FF[$state];

				while ($GF[$failure][$c] == -1)
				{
					$failure = $FF[$failure];
				}

				$failure = $GF[$failure][$c];
				$FF[$GF[$state][$c]] = $failure;
				$Out[$GF[$state][$c]] |= $Out[$failure];
				$q[] = $GF[$state][$c];
			}
		}
	}

	return $states;
}

function FindNextState($currentState, $nextInput, $lowestChar = 'a')
{
	global $GF, $FF;

	$answer = $currentState;
	$c = ord($nextInput) - ord($lowestChar);

	while ($GF[$answer][$c] == -1)
	{
		$answer = $FF[$answer];
	}

	return $GF[$answer][$c];
}

function FindAllStates($text, $keywords, $lowestChar = 'a', $highestChar = 'z')
{
	global $Out;
	
	BuildMatchingMachine($keywords, $lowestChar, $highestChar);

	$currentState = 0;
	$retVal = array();

	for ($i = 0; $i < strlen($text); $i++)
	{
		$currentState = FindNextState($currentState, $text[$i], $lowestChar);

		if ($Out[$currentState] == 0)
			continue;

		for ($j = 0; $j < count($keywords); $j++)
		{
			if ($Out[$currentState] & (1 << $j))
			{
				if (count($retVal) == 0) {
					$retVal[0] = $i - strlen($keywords[$j]) + 1;
				}
				else {
					array_unshift($retVal, $i - strlen($keywords[$j]) + 1);
				}
			}
		}
	}

	return $retVal;
}

//Bitap
function bitapSearchString($text, $pattern)
{
	$m = strlen($pattern);
	$textLen = strlen($text);
	$patternMask = array();
	$i;

	if (empty($pattern)) return 0;
	if ($m > 31) return -1; //Error: The pattern is too long!

	$R = ~1;

	for ($i = 0; $i <= 127; ++$i)
		$patternMask[$i] = ~0;

	for ($i = 0; $i < $m; ++$i)
		$patternMask[ord($pattern[$i])] &= ~(1 << $i);

	for ($i = 0; $i < $textLen; ++$i)
	{
		$R |= $patternMask[ord($text[$i])];
		$R <<= 1;

		if (0 == ($R & (1 << $m)))
			return ($i - $m) + 1;
	}

	return -1;
}

//Boyer-Moore
function badCharHeuristic($str, $size, &$badchar)
{
	for ($i = 0; $i < 256; $i++)
		$badchar[$i] = -1;

	for ($i = 0; $i < $size; $i++)
		$badchar[ord($str[$i])] = $i;
}

function bmSearchString($str, $pat) {
	$m = strlen($pat);
	$n = strlen($str);
	$i = 0;

	badCharHeuristic($pat, $m, $badchar);

	$s = 0;
	while ($s <= ($n - $m))
	{
		$j = $m - 1;

		while ($j >= 0 && $pat[$j] == $str[$s + $j])
			$j--;

		if ($j < 0)
		{
			$arr[$i++] = $s;
			$s += ($s + $m < $n) ? $m - $badchar[ord($str[$s + $m])] : 1;
		}
		else
			$s += max(1, $j - $badchar[ord($str[$s + $j])]);
	}

	for ($j = 0; $j < $i; $j++)
	{
		$result[$j] = $arr[$j];
	}

	return $result;
}
//Brute Force
function bfString($pattern, $subject) 
{
	$n = strlen($subject);
	$m = strlen($pattern);
 
	for ($i = 0; i < $n-$m; $i++) {
		$j = 0;
		while ($j < $m && $subject[$i+$j] == $pattern[$j]) {
			$j++;
		}
		if ($j == $m) return $i;
	}
	return -1;
}
//Finite-State Automaton
function fsaSearchString($str, $pat)
{
	$retVal = array();
	$M = strlen($pat);
	$N = strlen($str);
	$state = 0;

	ComputeTF($pat, $M, $TF);

	for ($i = 0; $i < $N; $i++)
	{
		$state = $TF[$state][ord($str[$i])];

		if ($state == $M)
		{
			array_push($retVal, $i - $M + 1);
		}
	}

	return $retVal;
}

function ComputeTF($pat, $M, &$TF)
{
	for ($state = 0; $state <= $M; $state++)
		for ($x = 0; $x < 256; $x++)
			$TF[$state][$x] = GetNextState($pat, $M, $state, $x);
}

function GetNextState($pat, $M, $state, $x)
{
	if ($state < $M && $x == ord($pat[$state]))
		return $state + 1;

	for ($ns = $state; $ns > 0; $ns--)
	{
		if (ord($pat[$ns - 1]) == $x)
		{
			for ($i = 0; $i < $ns - 1; $i++)
			{
				if (ord($pat[$i]) != ord($pat[$state - $ns + 1 + $i]))
					break;
			}

			if ($i == $ns - 1)
				return $ns;
		}
	}

	return 0;
}
//Fuzzy Bitap
function fbitapSearchString($text, $pattern, $k)
{
	$result = -1;
	$m = strlen($pattern);
	$textLen = strlen($text);
	$R = array();
	$patternMask = array();
	$i;
	$d;

	if (empty($pattern[0])) return 0;
	if ($m > 31) return -1; //Error: The pattern is too long!

	$R = array();
	for ($i = 0; $i <= $k; ++$i)
		$R[$i] = ~1;

	for ($i = 0; $i <= 127; ++$i)
		$patternMask[$i] = ~0;

	for ($i = 0; $i < $m; ++$i)
		$patternMask[ord($pattern[$i])] &= ~(1 << $i);

	for ($i = 0; $i < $textLen; ++$i)
	{
		$oldRd1 = $R[0];

		$R[0] |= $patternMask[ord($text[$i])];
		$R[0] <<= 1;

		for ($d = 1; $d <= $k; ++$d)
		{
			$tmp = $R[$d];

			$R[$d] = ($oldRd1 & ($R[$d] | $patternMask[ord($text[$i])])) << 1;
			$oldRd1 = $tmp;
		}

		if (0 == ($R[$k] & (1 << $m)))
		{
			$result = ($i - $m) + 1;
			break;
		}
	}

	unset($R);
	return $result;
}
//Knuth–Morris–Pratt
function kmpSearchString($str, $pat)
{
	$retVal = array();
	$M = strlen($pat);
	$N = strlen($str);
	$i = 0;
	$j = 0;
	$lps = array();

	ComputeLPSArray($pat, $M, $lps);

	while ($i < $N)
	{
		if ($pat[$j] == $str[$i])
		{
			$j++;
			$i++;
		}

		if ($j == $M)
		{
			array_push($retVal, $i - $j);
			$j = $lps[$j - 1];
		}

		else if ($i < $N && $pat[$j] != $str[$i])
		{
			if ($j != 0)
				$j = $lps[$j - 1];
			else
				$i = $i + 1;
		}
	}

	return $retVal;
}

function ComputeLPSArray($pat, $m, &$lps)
{
	$len = 0;
	$i = 1;

	$lps[0] = 0;

	while ($i < $m)
	{
		if ($pat[$i] == $pat[$len])
		{
			$len++;
			$lps[$i] = $len;
			$i++;
		}
		else
		{
			if ($len != 0)
			{
				$len = $lps[$len - 1];
			}
			else
			{
				$lps[$i] = 0;
				$i++;
			}
		}
	}
}
//Levenshtein Distance
function MIN3($a, $b, $c)
{
	return (($a) < ($b) ? (($a) < ($c) ? ($a) : ($c)) : (($b) < ($c) ? ($b) : ($c)));
}

function LevenshteinDistance($s1, $s2)
{
	$x; $y; $lastdiag; $olddiag;
	$s1len = strlen($s1);
	$s2len = strlen($s2);
	$column = array();

	for ($y = 1; $y <= $s1len; ++$y)
		$column[$y] = $y;

	for ($x = 1; $x <= $s2len; ++$x)
	{
		$column[0] = $x;

		for ($y = 1, $lastdiag = $x - 1; $y <= $s1len; ++$y)
		{
			$olddiag = $column[$y];
			$column[$y] = MIN3($column[$y] + 1, $column[$y - 1] + 1, ($lastdiag + ($s1[$y - 1] == $s2[$x - 1] ? 0 : 1)));
			$lastdiag = $olddiag;
		}
	}

	return $column[$s1len];
}
//Morris Pratt
function preprocessMorrisPratt($pattern, &$nextTable)
{
	$i = 0;
	$j = $nextTable[0] = -1;
	$len = strlen($pattern);
 
	while ($i < $len) {
		while ($j > -1 && $pattern[$i] != $pattern[$j]) {
			$j = $nextTable[$j];
		}
 
		$nextTable[++$i] = ++$j;
	}
}

function mpSearchString($text, $pattern)
{
	// get the text and pattern lengths
	$n = strlen($text);
	$m = strlen($pattern);
	$nextTable = array();
 
	// calculate the next table
	preprocessMorrisPratt($pattern, $nextTable);
 
	$i = $j = 0;
	while ($j < $n) {
		while ($i > -1 && $pattern[$i] != $text[$j]) {
			$i = $nextTable[$i];
		}
		$i++;
		$j++;
		if ($i >= $m) {
			return $j - $i;
		}
	}
	return -1;
}
//Naive String Search
function naivSearchString($str, $pat)
{
	$retVal = array();
	$M = strlen($pat);
	$N = strlen($str);

	for ($i = 0; $i <= $N - $M; $i++)
	{
		$j = 0;

		for ($j = 0; $j < $M; $j++)
		{
			if ($str[$i + $j] != $pat[$j])
				break;
		}

		if ($j == $M)
			array_push($retVal, $i);
	}

	return $retVal;
}
//Rabin–Karp
function rkSearchString($A, $B)
{
	$retVal = array();
	$siga = 0;
	$sigb = 0;
	$Q = 100007;
	$D = 256;
	$BLen = strlen($B);
	$ALen = strlen($A);

	for ($i = 0; $i < $BLen; $i++)
	{
		$siga = ($siga * $D + $A[$i]) % $Q;
		$sigb = ($sigb * $D + $B[$i]) % $Q;
	}

	if ($siga == $sigb)
		array_push($retVal, 0);

	$pow = 1;

	for ($k = 1; $k <= $BLen - 1; $k++)
		$pow = ($pow * $D) % $Q;

	for ($j = 1; $j <= $ALen - $BLen; $j++)
	{
		$siga = ($siga + $Q - $pow * $A[$j - 1] % $Q) % $Q;
		$siga = ($siga * $D + $A[$j + $BLen - 1]) % $Q;

		if ($siga == $sigb)
			if (substr($A, $j, $BLen) == $B)
				array_push($retVal, $j);
	}

	return $retVal;
}
//Sørensen–Dice Coefficient
function DiceMatch($string1, $string2)
{
	if (empty($string1) || empty($string2))
		return 0;

	if ($string1 == $string2)
		return 1;

	$strlen1 = strlen($string1);
	$strlen2 = strlen($string2);

	if ($strlen1 < 2 || $strlen2 < 2)
		return 0;

	$length1 = $strlen1 - 1;
	$length2 = $strlen2 - 1;

	$matches = 0;
	$i = 0;
	$j = 0;

	while ($i < $length1 && $j < $length2)
	{
		$a = substr($string1, $i, 2);
		$b = substr($string2, $j, 2);
		$cmp = strcasecmp($a, $b);

		if ($cmp == 0)
			$matches += 2;

		++$i;
		++$j;
	}

	return $matches / ($length1 + $length2);
}
?>