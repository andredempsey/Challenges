<?php

//Anagrams

$master_array=['pizza','banana','apple','orange','ice cream', 'donuts', 'panda', 'jason', 'chris', 'omar', 'ben', 'thomas', 'michael', 'ryan', 'codeup'];

function pickword($an_array)
{
	$posnum = mt_rand(0,count($an_array)-1);
	$item = $an_array[$posnum];
	//return an array which includes word and position
	return array($item, $posnum);
}

function jumble($word)
{
	$word_array= str_split($word);
	shuffle($word_array);
	return strtoupper(implode('_', $word_array));

}

function get_input($upper = FALSE) 
// Get STDIN, strip whitespace and newlines, 
// and convert to uppercase if $upper is true
{
    // Return filtered STDIN input
    if ($upper) 
    {
        return strtoupper(trim(fgets(STDIN)));
    }
    else
    {
        return strtolower(trim(fgets(STDIN)));
    }
}

$match =False;
$targetarray =pickword($master_array);
$targetword =jumble($targetarray[0]);
$target_position = ($targetarray[1]);

do 
{
	echo "What is the following word\n";
	echo $targetword;	
	echo PHP_EOL;
	echo "Please enter your guess ";
	if (array_search(get_input(false), $master_array) == $target_position) 
	{
		echo "You are correct!\n";
		$match=true;
	}
	else
	{
		echo "Not quite....try again!\n";
	}
} 
while ($match!=true);
