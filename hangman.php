<?php

//hangman

function getFile($filename) //randomly pick a string for the user to guess from a list of words
{
	$fileSize=fileSize($filename);
	$handle =fopen($filename, 'r');
	$wordlist = strtoupper(trim(fread($handle, $fileSize)));
	fclose($handle);
	return explode("\n", $wordlist);
}

function pickword($an_array)
{
	$posnum = mt_rand(0,count($an_array)-1);
	//select word randomly from the master list
	//return an array of the word's letters
	return str_split($an_array[$posnum]);
}

function InitialMask($secret_word)
{
	foreach ($secret_word as $spot => $letter) 
	{
		$masked_array[$spot]="_";
	}
		return implode(' ', $masked_array);
}

function DisplayMask($secret_word, $guess_array) 
{
	$masked_array=explode(' ', InitialMask($secret_word));

	foreach ($guess_array as $guess) 
	{
		foreach ($secret_word as $posnum => $letter) //check if letter is in string
		{
			if ($letter==$guess) 
			{
				$masked_array[$posnum]=$guess;
			}
		}
	}
		$masked_string = trim(implode(' ', $masked_array));
		echo $masked_string;
		echo PHP_EOL;
		if (in_array("_", $masked_array)) 
		{
			return $guess_array;
		}
		else
		{
			echo "Win!\n";
			exit(0);
		}
}

function CountMisses($secret_word, $guess_array)
{
	$misses=0;
	foreach ($guess_array as $guess) 
	{
		if (in_array($guess, $secret_word)==false)
		{
			$misses++;
		}
	}
		return $misses;
}

$secret_word=pickword(getFile("words.txt"));
echo InitialMask($secret_word);
echo PHP_EOL;
$misses=0;

do 
{
	//ask player to guess a letter
	echo "Please guess a letter ";
	$input=strtoupper(trim(fgets(STDIN)));
	$guess_array[]=$input;
	$guess_array = DisplayMask($secret_word, $guess_array);
	$misses= CountMisses($secret_word,$guess_array);
	echo "You have $misses bad guesses.\n";
	echo PHP_EOL;
	echo "Letters guessed include " . implode(" | ",$guess_array);
	echo PHP_EOL;
} 
while ( $misses < 9);

//track and display letters which have been guessed
