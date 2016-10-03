<?php
//*******************************************************************
//Template Name: Sorting_Lib_API.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
//*******************************************************************/
//Bead Sort
function BeadSort(&$data)
{
	$i; $j; $max; $sum;
	$dataCount = count($data);

	for ($i = 1, $max = $data[0]; $i < $dataCount; ++$i)
		if ($data[$i] > $max)
			$max = $data[$i];

	$beads = array_fill(0, $max * $dataCount, 0);

	for ($i = 0; $i < $dataCount; ++$i)
		for ($j = 0; $j < $data[$i]; ++$j)
			$beads[$i * $max + $j] = 1;

	for ($j = 0; $j < $max; ++$j)
	{
		for ($sum = $i = 0; $i < $dataCount; ++$i)
		{
			$sum += $beads[$i * $max + $j];
			$beads[$i * $max + $j] = 0;
		}

		for ($i = $dataCount - $sum; $i < $dataCount; ++$i)
			$beads[$i * $max + $j] = 1;
	}

	for ($i = 0; $i < $dataCount; ++$i)
	{
		for ($j = 0; $j < $max && $beads[$i * $max + $j]; ++$j) ;
		$data[$i] = $j;
	}
}
//Bogo Sort
function IsSorted(&$data)
{
	$count = count($data);

	while (--$count >= 1)
		if ($data[$count] < $data[$count - 1]) return false;

	return true;
}

function ShuffleData(&$data)
{
	$count = count($data);
	
	for ($i = 0; $i < $count; ++$i)
	{
		$rnd = rand() % $count;
		$temp = $data[$i];
		$data[$i] = $data[$rnd];
		$data[$rnd] = $temp;
	}
}

function BogoSort(&$data)
{
	while (!IsSorted($data))
		ShuffleData($data);
}
//Bubble Sort
function BubbleSort(&$data, $count) {
	for ($i = 1; $i < $count; $i++)
	{
		for ($j = 0; $j < $count - $i; $j++)
		{
			if ($data[$j] > $data[$j + 1])
			{
				$data[$j] ^= $data[$j + 1];
				$data[$j + 1] ^= $data[$j];
				$data[$j] ^= $data[$j + 1];
			}
		}
	}
}
//Bucket Sort
function BucketSort(&$data)
{
	$minValue = $data[0];
	$maxValue = $data[0];
	$dataLength = count($data);

	for ($i = 1; $i < $dataLength; $i++)
	{
		if ($data[$i] > $maxValue)
			$maxValue = $data[$i];
		if ($data[$i] < $minValue)
			$minValue = $data[$i];
	}

	$bucket = array();
	$bucketLength = $maxValue - $minValue + 1;
	
	for ($i = 0; $i < $bucketLength; $i++)
	{
		$bucket[$i] = array();
	}

	for ($i = 0; $i < $dataLength; $i++)
	{
		array_push($bucket[$data[$i] - $minValue], $data[$i]);
	}
	
	$k = 0;
	for ($i = 0; $i < $bucketLength; $i++)
	{
		$bucketCount = count($bucket[$i]);
		
		if ($bucketCount > 0)
		{
			for ($j = 0; $j < $bucketCount; $j++)
			{
				$data[$k] = $bucket[$i][$j];
				$k++;
			}
		}
	}
}

//Cocktail Shaker Sort
function csSwap(&$a, &$b)
{
	$a ^= $b;
	$b ^= $a;
	$a ^= $b;
}

function CocktailSort(&$data)
{
	$count = count($data);
	
	while (true)
	{
		$flag;
		$start = array(1, $count - 1);
		$end = array($count, 0);
		$inc = array(1, -1);

		for ($it = 0; $it < 2; ++$it)
		{
			$flag = true;

			for ($i = $start[$it]; $i != $end[$it]; $i += $inc[$it])
			{
				if ($data[$i - 1] > $data[$i])
				{
					csSwap($data[$i - 1], $data[$i]);
					$flag = false;
				}
			}

			if ($flag)
				return;
		}
	}
}
//Comb Sort
function CombSort(&$data, $count) {
	$gap = $count;
	$swaps = true;

	while ($gap > 1 || $swaps)
	{
		$gap /= 1.247330950103979;

		if ($gap < 1)
			$gap = 1;

		$i = 0;
		$swaps = false;

		while ($i + $gap < $count)
		{
			$igap = $i + $gap;

			if ($data[$i] > $data[$igap])
			{
				$temp = $data[$i];
				$data[$i] = $data[$igap];
				$data[$igap] = $temp;
				$swaps = true;
			}

			$i++;
		}
	}
}
//Counting Sort
function CountingSort(&$data, $n, $min, $max) {
	$cLen = $max - $min + 1;
	$z = 0;

	for ($i = 0; $i < $cLen; $i++)
		$count[$i] = 0;

	for ($i = 0; $i < $n; $i++)
		$count[$data[$i] - $min]++;

	for ($i = $min; $i <= $max; $i++)
	{
		while ($count[$i - $min]-- > 0)
		{
			$data[$z] = $i;
			$z++;
		}
	}

	$count = null;
}
//Gnome Sort
function GnomeSort(&$data)
{
	$dataCount = count($data);
	for ($i = 1; $i < $dataCount;)
	{
		if ($data[$i - 1] <= $data[$i])
			++$i;
		else
		{
			$tmp = $data[$i];
			$data[$i] = $data[$i - 1];
			$data[$i - 1] = $tmp;
			--$i;
			if ($i == 0)
				$i = 1;
		}
	}
}
//Heap Sort
function MaxHeapify(&$data, $heapSize, $index) {
	$left = ($index + 1) * 2 - 1;
	$right = ($index + 1) * 2;
	$largest = 0;

	if ($left < $heapSize && $data[$left] > $data[$index])
		$largest = $left;
	else
		$largest = $index;

	if ($right < $heapSize && $data[$right] > $data[$largest])
		$largest = $right;

	if ($largest != $index)
	{
		$temp = $data[$index];
		$data[$index] = $data[$largest];
		$data[$largest] = $temp;

		MaxHeapify($data, $heapSize, $largest);
	}
}

function HeapSort(&$data, $count) {
	$heapSize = $count;

	for ($p = ($heapSize - 1) / 2; $p >= 0; $p--)
		MaxHeapify($data, $heapSize, $p);

	for ($i = $count - 1; $i > 0; $i--)
	{
		$temp = $data[$i];
		$data[$i] = $data[0];
		$data[0] = $temp;

		$heapSize--;
		MaxHeapify($data, $heapSize, 0);
	}
}

//Insertion Sort
function InsertionSort(&$data, $count) {
	for ($i = 1; $i < $count; $i++)
	{
		$j = $i;

		while ($j > 0)
		{
			if ($data[$j - 1] > $data[$j])
			{
				$data[$j - 1] ^= $data[$j];
				$data[$j] ^= $data[$j - 1];
				$data[$j - 1] ^= $data[$j];

				$j--;
			}
			else
			{
				break;
			}
		}
	}
}
//Intro Sort
function IntroSort(&$data, $count) {
	$partitionSize = Partition($data, 0, $count - 1);

	if ($partitionSize < 16)
	{
		InsertionSort($data, $count);
	}
	else if ($partitionSize >(2 * log($count)))
	{
		HeapSort($data, $count);
	}
	else
	{
		QuickSortRecursive($data, 0, $count - 1);
	}
}

//Merge Sort Iterative
function msiMerge(&$data, $left, $mid, $right) {
	$n1 = $mid - $left + 1;
	$n2 = $right - $mid;

	for ($i = 0; $i < $n1; $i++)
		$L[$i] = $data[$left + $i];

	for ($j = 0; $j < $n2; $j++)
		$R[$j] = $data[$mid + 1 + $j];

	$i = 0;
	$j = 0;
	$k = $left;

	while ($i < $n1 && $j < $n2)
	{
		if ($L[$i] <= $R[$j])
		{
			$data[$k] = $L[$i];
			$i++;
		}
		else
		{
			$data[$k] = $R[$j];
			$j++;
		}

		$k++;
	}

	while ($i < $n1)
	{
		$data[$k] = $L[$i];
		$i++;
		$k++;
	}

	while ($j < $n2)
	{
		$data[$k] = $R[$j];
		$j++;
		$k++;
	}

	$L = null;
	$R = null;
}

function MergeSortIterative(&$data, $count) {
	for ($currentSize = 1; $currentSize <= $count - 1; $currentSize = 2 * $currentSize)
	{
		for ($leftStart = 0; $leftStart < $count - 1; $leftStart += 2 * $currentSize)
		{
			$mid = $leftStart + $currentSize - 1;
			$rightEnd = min($leftStart + 2 * $currentSize - 1, $count - 1);

			msiMerge($data, $leftStart, $mid, $rightEnd);
		}
	}
}
//Merge Sort Recursive
function msrMerge(&$data, $left, $mid, $right) {
	$n1 = $mid - $left + 1;
	$n2 = $right - $mid;

	for ($i = 0; $i < $n1; $i++)
		$L[$i] = $data[$left + $i];

	for ($j = 0; $j < $n2; $j++)
		$R[$j] = $data[$mid + 1 + $j];

	$i = 0;
	$j = 0;
	$k = $left;

	while ($i < $n1 && $j < $n2)
	{
		if ($L[$i] <= $R[$j])
		{
			$data[$k] = $L[$i];
			$i++;
		}
		else
		{
			$data[$k] = $R[$j];
			$j++;
		}

		$k++;
	}

	while ($i < $n1)
	{
		$data[$k] = $L[$i];
		$i++;
		$k++;
	}

	while ($j < $n2)
	{
		$data[$k] = $R[$j];
		$j++;
		$k++;
	}

	$L = null;
	$R = null;
}

function MergeSortRecursive(&$data, $left, $right) {
	if ($left < $right)
	{
		$m = $left + ($right - $left) / 2;

		MergeSortRecursive($data, $left, $m);
		MergeSortRecursive($data, $m + 1, $right);
		msrMerge($data, $left, $m, $right);
	}
}
//Quick Sort Iterative
function qsiSwap(&$a, &$b)
{
	$temp = $a;
	$a = $b;
	$b = $temp;
}

function qsiPartition(&$data, $left, $right)
{
	$x = $data[$right];
	$i = ($left - 1);

	for ($j = $left; $j <= $right - 1; $j++)
	{
		if ($data[$j] <= $x)
		{
			$i++;
			qsiSwap($data[$i], $data[$j]);
		}
	}

	qsiSwap($data[$i + 1], $data[$right]);

	return ($i + 1);
}

function QuickSortIterative(&$data, $count) {
	$startIndex = 0;
	$endIndex = $count - 1;
	$top = -1;

	$stack = array();
	$stack[$top++] = $startIndex;
	$stack[$top++] = $endIndex;

	while ($top >= 0)
	{
		$top--;
		$endIndex = $stack[$top];
		$top--;
		$startIndex = $stack[$top];

		$p = qsiPartition($data, $startIndex, $endIndex);

		if ($p - 1 > $startIndex)
		{
			$stack[$top++] = $startIndex;
			$stack[$top++] = $p - 1;
		}

		if ($p + 1 < $endIndex)
		{
			$stack[$top++] = $p + 1;
			$stack[$top++] = $endIndex;
		}
	}

	$stack = null;
}
//Quick Sort Recursive
function qsrPartition(&$data, $left, $right) {
	$pivot = $data[$right];
	$temp;
	$i = $left;

	for ($j = $left; $j < $right; $j++)
	{
		if ($data[$j] <= $pivot)
		{
			$temp = $data[$j];
			$data[$j] = $data[$i];
			$data[$i] = $temp;
			$i++;
		}
	}

	$data[$right] = $data[$i];
	$data[$i] = $pivot;

	return $i;
}

function QuickSortRecursive(&$data, $left, $right) {
	if ($left < $right)
	{
		$q = qsrPartition($data, $left, $right);
		QuickSortRecursive($data, $left, $q - 1);
		QuickSortRecursive($data, $q + 1, $right);
	}
}
//Radix Sort
function RadixSort(&$data, $count) {
	for ($shift = 31; $shift > -1; $shift--)
	{
		$j = 0;

		for ($i = 0; $i < $count; $i++)
		{
			$move = ($data[$i] << $shift) >= 0;

			if ($shift == 0 ? !$move : $move)
				$data[$i - $j] = $data[$i];
			else
				$temp[$j++] = $data[$i];
		}

		for ($i = 0; $i < $j; $i++)
		{
			$data[($count - $j) + $i] = $temp[$i];
		}
	}

	$temp = null;
}
//Selection Sort
function SelectionSort(&$data, $count) {
	for ($i = 0; $i < $count - 1; $i++)
	{
		$min = $i;

		for ($j = $i + 1; $j < $count; $j++)
		{
			if ($data[$j] < $data[$min])
			{
				$min = $j;
			}
		}

		$temp = $data[$min];
		$data[$min] = $data[$i];
		$data[$i] = $temp;
	}
}
//Shell Sort
function ShellSort(&$data, $count) {
	$hSort = 1;

	while ($hSort < floor($count / 3))
		$hSort = (3 * $hSort) + 1;

	while ($hSort >= 1)
	{
		for ($i = $hSort; $i < $count; $i++)
		{
			for ($a = $i; $a >= $hSort && ($data[$a] < $data[$a - $hSort]); $a -= $hSort)
			{
				$data[$a] ^= $data[$a - $hSort];
				$data[$a - $hSort] ^= $data[$a];
				$data[$a] ^= $data[$a - $hSort];
			}
		}

		$hSort = floor($hSort / 3);
	}
}
?>