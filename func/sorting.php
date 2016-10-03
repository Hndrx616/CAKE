<?php
//*******************************************************************
//Template Name: Sorting.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
//*******************************************************************/
if (!defined('GIG_CATALYSTKEY_DOCUMENT_ROOT')) {
    define('GIG_CATALYSTKEY_DOCUMENT_ROOT', dirname(__FILE__) == '/' ? '' : dirname(__FILE__));
}
if (file_exists(GIG_CATALYSTKEY_DOCUMENT_ROOT . '/sorting_lib_api.php')) {
    require_once GIG_CATALYSTKEY_DOCUMENT_ROOT . '/sorting_lib_api.php';
}
if (!defined('GIG_CATALYSTKEY_INCLUDE_PATH')) {
    define('GIG_CATALYSTKEY_INCLUDE_PATH', GIG_CATALYSTKEY_DOCUMENT_ROOT);
}

require_once GIG_CATALYSTKEY_INCLUDE_PATH . 'api/lib/bootstrap.php';
require_once GIG_CATALYSTKEY_INCLUDE_PATH . 'api/lib/dispatch.php';
?>
<?php
//Bead Sort
public function BeadSort($data) {
	$data = array(586, 25, 58964, 8547, 119, 0, 78596);
	BeadSort($data);
}
//Bogo Sort
public function BogoSort($data) {
	$data = array(-1, 25, -58964, 8547, -119, 0, 78596);
	BogoSort($data);
}
//Bubble Sort
public function BubbleSort($data) {
	$data = array(-1, 25, -58964, 8547, -119, 0, 78596);
	BubbleSort($data, 7);
}
//Bucket Sort
public function BucketSort($data) {
	$data = array(-1, 25, -58964, 8547, -119, 0, 78596);
	BucketSort($data, 7);
}
//Cocktail Shaker Sort
public function CocktailSort($data) {
	$data = array(-1, 25, -58964, 8547, -119, 0, 78596);
	CocktailSort($data);
}
//Comb Sort
public function CombSort($data) {
	$data = array(-1, 25, -58964, 8547, -119, 0, 78596);
	CombSort($data, 7);
}
//Counting Sort
public function CountingSort($data) {
	$data = array(-1, 25, -58964, 8547, -119, 0, 78596);
	CountingSort($data, 7, -58964, 78596);
}
//Gnome Sort
public function GnomeSort($data) {
	$data = array(-1, 25, -58964, 8547, -119, 0, 78596);
	GnomeSort($data);
}
//Heap Sort
public function HeapSort($data) {
	$data = array(-1, 25, -58964, 8547, -119, 0, 78596);
	HeapSort($data, 7);
}
//Insertion Sort
public function InsertionSort($data) {
	$data = array(-1, 25, -58964, 8547, -119, 0, 78596);
	InsertionSort($data, 7);
}
//Intro Sort
public function IntroSort($data) {
	$data = array( -1, 25, -58964, 8547, -119, 0, 78596);
	IntroSort($data, 7);
}
//Merge Sort Iterative
public function MergeSortIterative($data) {
	$data = array(-1, 25, -58964, 8547, -119, 0, 78596);
	MergeSortIterative($data, 7);
}
//Merge Sort Recursive
public function MergeSortRecursive($data) {
	$data = array(-1, 25, -58964, 8547, -119, 0, 78596);
	MergeSortRecursive($data, 0, 6);
}
//Quick Sort Iterative
public function QuickSortIterative($data) {
	$data = array(-1, 25, -58964, 8547, -119, 0, 78596);
	QuickSortIterative($data, 7);
}
//Quick Sort Recursive
public function QuickSortRecursive($data) {
	$data = array(-1, 25, -58964, 8547, -119, 0, 78596);
	QuickSortRecursive($data, 0, 6);
}
//Radix Sort
public function RadixSort($data) {
	$data = array(-1, 25, -58964, 8547, -119, 0, 78596);
	RadixSort($data, 7);
}
//Selection Sort
public function SelectionSort($data) {
	$data = array(-1, 25, -58964, 8547, -119, 0, 78596);
	SelectionSort($data, 7);
}
//Shell Sort
public function ShellSort($data) {
	$data = array(-1, 25, -58964, 8547, -119, 0, 78596);
	ShellSort($data, 7);
}
?>