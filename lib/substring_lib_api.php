<?php
//*******************************************************************
//Template Name: SubString_Lib_API.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
//*******************************************************************/
//Longest Common Substring
function LongestCommonSubstring($str1, $str2, &$subStr)
{
	$subStr = "";

	if ($str1 == "" || $str2 == "")
		return 0;

	$num = array();
	$maxlen = 0;
	$lastSubsBegin = 0;
	$subStrBuilder = "";
	$str1Len = strlen($str1);
	$str2Len = strlen($str2);

	for ($i = 0; $i < $str1Len; $i++)
	{
		for ($j = 0; $j < $str2Len; $j++)
		{
			if ($str1[$i] != $str2[$j])
			{
				$num[$i][$j] = 0;
			}
			else
			{
				if (($i == 0) || ($j == 0))
					$num[$i][$j] = 1;
				else
					$num[$i][$j] = 1 + $num[$i - 1][$j - 1];

				if ($num[$i][$j] > $maxlen)
				{
					$maxlen = $num[$i][$j];

					$thisSubsBegin = $i - $num[$i][$j] + 1;

					if ($lastSubsBegin == $thisSubsBegin)
					{
						$subStrBuilder .= $str1[$i];
					}
					else
					{
						$lastSubsBegin = $thisSubsBegin;
						$subStrBuilder = "";
						$subStrBuilder .= substr($str1, $lastSubsBegin, ($i + 1) - $lastSubsBegin);
					}
				}
			}
		}
	}

	$subStr = $subStrBuilder;

	return $maxlen;
}
//Longest Repeated Substring
function LongestRepeatedSubstring($str)
{
	if ($str == null)
		return null;

	$N = strlen($str);
	$substrings = array();

	for ($i = 0; $i < $N; $i++)
	{
		$substrings[$i] = substr($str, $i);
	}

	sort($substrings);

	$result = "";

	for ($i = 0; $i < $N - 1; $i++)
	{
		$lcs = LongestCommonString($substrings[$i], $substrings[$i + 1]);

		if (strlen($lcs) > strlen($result))
		{
			$result = $lcs;
		}
	}

	return $result;
}

function LongestCommonString($a, $b)
{
	$n = min(strlen($a), strlen($b));
	$result = "";

	for ($i = 0; $i < $n; $i++)
	{
		if ($a[$i] == $b[$i])
			$result = $result . $a[$i];
		else
			break;
	}

	return $result;
}
//Brute Force Subtring
function bfSub_String($pattern, $subject) 
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
?>