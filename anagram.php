-<?php
 
 //Anagrams
 function getFile($filename)
 {
 	$fileSize=fileSize($filename);
 	$handle =fopen($filename, 'r');
 	$wordlist = trim(fread($handle, $fileSize));
 	fclose($handle);
 	return explode("\n", $wordlist);
 }
 
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
         return ucfirst(trim(fgets(STDIN)));
     }
 }
 $master_array=getFile('words.txt');
 $match =False;
 $targetarray =pickword($master_array);
 $targetword =jumble($targetarray[0]);
 $target_position = ($targetarray[1]);
 $tot_guesses=1;
 $guesses_allowed=6;
 do 
 {
 	echo "What is the following word\n";
 	echo $targetword;	
 	echo PHP_EOL;
 	echo "Please enter your guess ";
 	// echo "\npssst... the word is $targetarray[0]\n";
 	if (array_search(get_input(false), $master_array) == $target_position) //look for guess in array and make sure the position matches
 	{
 		echo "You are correct!\n";
 		echo "You guessed it in {$tot_guesses} tries.\n";
 		$match=true;
 	}
 	else
 	{
 		$tot_guesses++;
 		$guesses_left = $guesses_allowed-$tot_guesses;
 		echo $guesses_left==0?"Game Over!":"You have " . $guesses_left . " left.  Try again.\n";
 	}
 } 
 while ($match!=true && $tot_guesses <$guesses_allowed);
 if ($match!=true) 
 {
 	echo "\nThe word was $targetarray[0]\n";
 }