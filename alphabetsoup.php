<?php

//Codeup Challenge 
//Alphabet Soup
//Date:  27 May 14
//Name:  Andre Dempsey
//Codeup Baddies

//get user input for a string
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
        return (trim(fgets(STDIN)));
    }
}

//put each word into an array and
//sort array 
function sort_word($phrase)
{
	foreach ($phrase as $key => $word) 
	{
		$temp_array = str_split($phrase[$key]);
		asort($temp_array, SORT_NATURAL|SORT_FLAG_CASE);
		$phrase[$key] = implode("",$temp_array);
	}
	return $phrase;
}
//output values
$orig_phrase = get_input(false);
echo $orig_phrase . " becomes \n";
$phrase = explode(" ", $orig_phrase);
echo "The result is ";
print_r (implode(" ",(sort_word($phrase))));
echo PHP_EOL;

// ($phrase);
