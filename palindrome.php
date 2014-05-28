<?php

//Codeup Challenge 
//Palindrome
//Date:  28 May 14
//Name:  Andre Dempsey
//Codeup Baddies

//Create the function so it will return a bool value true if the entered word is a palindrome. 
//Function name example could be is_palindrome(). After you are complete test several known palindromes, 
//then test regular words in your function.

//get user input for a string
function get_input($orig_input) 
// Get STDIN, strip whitespace and newlines, 
// and convert to uppercase 
{
    return strtoupper(trim($orig_input));
}

//put each letter into an array and
//reorder array 
function is_palindrome($phrase)
{
	$split_phrase = str_split($phrase); //split the word into an array by letter
    
    foreach ($split_phrase as $key => $letter) 
    {
	   if (!ctype_alpha($letter))
       {
            unset($split_phrase[$key]);
       }
	}
    $reverse_array = $split_phrase;
    $orig_phrase = implode("", $split_phrase);
    krsort($reverse_array);
    $rev_phrase = implode("", $reverse_array);
    if ($orig_phrase==$rev_phrase) 
    {
        echo " is a palindrome.\n";
        return true;

    }
    else
    {
        echo " is not a palindrome.\n";
        return false;
    }
}

echo "Please enter a word or phrase to check if it is a palindrome: ";
$orig = fgets(STDIN);
echo PHP_EOL;
echo trim($orig);
echo is_palindrome(get_input($orig));

