<?php

// Using wordlist containing words indexed by a series of five digit numbers, consisting of the digits 1 - 6. 
// Roll five dice to generate an index and lookup a unique word on the list. 
// Repeat number of times based on user input
// User will tell the application how many words she wants to generate (using either $argv or fgets(STDIN)), 
// ingest diceware wordlist.txt
// generate as many indexes as the user requested
// Using those indices the program will lookup the relevant words and then output them out to the user before exiting.

function getFile($filename) 
{
	if (is_readable($filename))
    {
		$fileSize=fileSize($filename);
		$handle =fopen($filename, 'r');
		$wordlist = trim(fread($handle, $fileSize));
		fclose($handle);
		$words=explode("\n", $wordlist);
		foreach ($words as $key => $value) 
		{
			$temparray =explode("\t", $value);
			$keyedarray[$temparray[0]]=$temparray[1];
		}
    }
    else
    {
        echo "File not readable.  Please check the file name and path and try again. \n";
    }
    return $keyedarray;
}
//using five six-sided dice; randomly generate a five digit number
function random_number()
{
	for ($i=0; $i < 5; $i++) 
	{ 
		$index_array[$i]=mt_rand(1,6);
	}

	$index = implode("",$index_array);	
	return (int)$index;	
}

function lookup_word($words,$index)
{	
		return trim($words[$index]);

}
$password="";
//user enters number of words to generate password
echo "How many words do you want in the password? ";
$numberofwords=trim(fgets(STDIN));
//read in word list; returns key word pair with key as the five digit number
$words=getFile("wordlist.txt");
//build password from looked up words based on number of words desired in password
for ($i=0; $i < $numberofwords; $i++) 
{ 
	$index = random_number();
	$word=lookup_word($words,$index);
	$password.=$word;
}

echo "Your password is $password\n";