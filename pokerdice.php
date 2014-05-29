<?php

// function to take user input on STDIN
// performing stringtoupper if $upper is true
function getInput($upper = false) 
{
	$input = trim(fgets(STDIN));
    return $upper ? strtoupper($input) : $input;
}

// generate an array of 5 dice
// each die should have a random roll between 1 and 6
// sort the dice before returning
function rollDice($sides=6) 
{
	$dice = [];
	// todo
	for ($i=1; $i < $sides; $i++) 
	{ 
		$dice[]=mt_rand(1,$sides);
	}
	sort($dice);
	return $dice;
}

// show the dice array
// output should be in the format...
// Dice: 1 2 3 4 5
function showDice($dice) 
{
	// todo
	return implode(" ", $dice) . "\n";
}

// determine the type of roll, the base score, and the bonus
// for a given array of dice
function scoreRoll($dice) 
{
	// generate a result in the following data structure
	$result = ['type' => '', 'base_score' => 0, 'bonus' => 0];
	$type = [0,0,0,0,0,0,0];
	$dice_total=0;
	// base score is a sum of all dice
	foreach ($dice as $die => $value) 
	{
		$dice_total+=$value;
		// todo
		//count occurances of 1, 2, 3, 4, 5, 6
		$type[($value)]=$type[($value)]+1;
	}
	$result['base_score']=$dice_total;
	unset($type[0]);
	// a straight = 40
	// nada = 0
	$result['bonus']=($type[1]==0 ||$type[6]==0)?40:0;
	$result['type']=($type[1]==0 ||$type[6]==0)?'straight':'nada';
	rsort($type);
	// hand type and bonus point system
	switch ($type[0]) 
	{
		case 5:
		// five of a kind = 100
			$result['bonus']=100;
			$result['type']='five of a kind';
			break;
		case 4:
		// four of a kind = 75
			$result['bonus']=75;
			$result['type']='four of a kind';
			break;
		case 3:
		// a full house = 50
		// three of a kind = 25
			$result['bonus']=($type[1]==2)?50:25;
			$result['type']=($type[1]==2)?'full house':'three of a kind';
			break;
		case 2:
		// two pair = 15
		// a pair = 5
			$result['bonus']=($type[1]==2)?15:5;
			$result['type']=($type[1]==2)?'two pair':'pair';
			break;
		default:
			break;
	}
	// return the result
	return $result;
}

// add an entry to the history log to keep track
// of how many rolls there have been of a given type
// sort history with highest occurring type first
function logHistory(&$history, $type) 
{
	// todo
		$history[$type]= $history[$type]+1;
		arsort($history);
		return $history;
}

// display stats from history log based on number of rolls
// desired display format:
// >> STATS ------------
// a pair: 47.47 %
// two pair: 23.67 %
// three of a kind: 15.43 %
// a straight: 7.42 %
// a full house: 3.77 %
// four of a kind: 2.24 %
// << STATS -------------
function showStats($history, $totalRolls) 
{
	echo ">> STATS ------------\n";
	// todo
	foreach ($history as $rolltype => $times_rolled) 
	{
		echo "$rolltype : " . round(($times_rolled/$totalRolls)*100,2) . "%\n";
	}
	echo "<< STATS -------------\n";
}

// track the total score
$score = 0;

// track the total rolls
$rolls = 0;

// track the roll type history
$history = ['nada'=>0,'pair'=>0,'two pair'=>0,'three of a kind'=>0,'full house'=>0,'four of a kind'=>0,'four of a kind'=>0,'five of a kind'=>0,'straight'=>0];

// welcome the user
echo "Welcome to Poker Dice!\n";
echo "Press enter to get started with your first roll...\n";

$input = getInput(true);
$total_score=0;
while ($input != 'Q') 
{

	// roll the dice
	// todo
	$dice=rollDice(6);

	// score the result
	// todo: use scoreRoll function
	$current_roll=(scoreRoll($dice));

	// add the current roll to the total score
	// todo
	$rolls++;
	$score+=$current_roll['base_score']+$current_roll['bonus'];

	// log the roll type history
	// todo: use logHistory function
	$history=logHistory($history, $current_roll['type']);
	// show the dice
	// todo: use showDice function
	echo showDice($dice);

	// display roll type, base score, and bonus
	// ex: You rolled a straight for a base score of 20 and a bonus of 40.
	// todo
	echo "You rolled a " . $current_roll['type'] . " for a base score of " . $current_roll['base_score'];
	echo " and a bonus of " . $current_roll['bonus']. PHP_EOL;

	// display total score
	// ex: Total Score: 32306, in 849 rolls.
	// todo
	echo "Total Score: {$score}, in {$rolls} rolls.\n";
	// show roll type statistics
	// todo: use showStats function
	showStats($history,$rolls);
	// prompt use to roll again or quit
	echo "Press enter to roll again, or Q to quit.\n";
	$input = getInput(true);
}

?>