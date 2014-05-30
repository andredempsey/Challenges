<?php

//Codeup Challenge 
//Plays
//Date:  29 May 14
//Name:  Andre Dempsey
//Codeup Baddies


//function to read in play

function readlines($filename)
{
	if (is_readable($filename))
    {
		$fileSize=fileSize($filename);
		$handle =fopen($filename, 'r');
		$lines_string = trim(fread($handle, $fileSize));
		fclose($handle);
		$lines_array=explode("\n\n", $lines_string);
    }
    else
    {
        echo "File not readable.  Please check the file name and path and try again. \n";
    }
    return $lines_array;
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
        return (trim(fgets(STDIN)));
    }
}

//function to find character's lines

function find_lines($lines, &$cued_lines, $char_name)
{
	$focus_array=[];
	foreach ($lines as $key => $value) 
	{
			if (strpos(strtoupper($value),$char_name)===0) 
			{
				$focus_array[]=$value;
                $cued_lines[]=($key>0)?$lines[$key-1]:"First line of play";
                $cued_lines[]=$value;
                
			}
	}
		return $focus_array;
}

//function to write out to text file

function output_script($lines,$char_name)
{
	$filepathname="characterlines.txt";
	//call function to find/extract character's lines
	$lines = find_lines($lines, $cuedlines, $char_name);

	//open file to write character's lines
    $write_handle = fopen($filepathname, "w");
    if (is_writable($filepathname))
    {
        $new_string=trim(implode("\n------------\n", $lines));
        fwrite($write_handle, "$new_string");
        fclose($write_handle);
    }
        return $filepathname;
}

// function to write out cue lines
function output_cued_script($lines)
{
	$filepathname="cuedcharacterlines.txt";

	//open file to write cued character lines
    $write_handle = fopen($filepathname, "w");
    if (is_writable($filepathname))
    {
        $new_string=trim(implode("\n------------\n", $lines));
        fwrite($write_handle, "$new_string");
        fclose($write_handle);
    }
        return $filepathname;
}

// //function to find/extract stage directions

// function FunctionName($value='')
// {
// 	# code...
// }
$cuedlines=array();
//ask for play name
echo "Enter the file name for your play: ";
$filename = get_input(false);
echo "Script to be loaded from $filename\n";
//call function to read play
$lines = (readlines($filename));

//character name input
echo "Character name is: ";
$char_name=get_input(true);

//call function to write out lines
echo "Lines for $char_name have been extracted and saved in '";
echo output_script($lines,$char_name);
echo "'" . PHP_EOL;

//call function to write out cued character lines
echo "Lines and cues for $char_name have been extracted and saved in '";
$focus_array = find_lines($lines,$cuedlines, $char_name);
echo output_cued_script($cuedlines);
echo "'" . PHP_EOL;
