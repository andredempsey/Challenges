<?php


//Program to shuffle deck of cards and deal based on number of players


// //How many players?
// fwrite(STDOUT, "How many players are there? ");

// $num_players = trim(fgets(STDIN));

// //Get player name(s)

// for ($i=1; $i <= $num_players; $i++) 
// { 
// 	fwrite(STDOUT, "Enter player name=> ");
// 	$players[]=fgets(STDIN);
// } 

//print_r($players);
//Initialize the cards
//load cards
$suits=array('H','D','S','C');
foreach ($suits as $key=>$suit) 
{
	for ($card_num = 1; $card_num <= 13 ; $card_num++) 
	{ 
		switch ($card_num) 
		{
			case 1:
				$deck[]="A"."-".$suit;
				break;
			case 2:
				$deck[]="K"."-".$suit;
				break;
			case 3:
				$deck[]="Q"."-".$suit;
				break;
			case 4:
				$deck[]="J"."-".$suit;
				break;
			default:
				$deck[]=($card_num-3)."-".$suit;
				break;
		}
	}
}

// Intro();

echo "Shuffling..";
for ($i=0; $i < 3; $i++) 
{ 
	shuffle($deck);
	echo ".";
	sleep(1);
}
// print_r($deck);
echo PHP_EOL;

//initial deal
$cards_in_deck=52;

for ($i=0; $i < 4; $i++) //change 4 value to a multiple of 2 times the number of players
{ 
	if ($i%2==0) 
	{
		$hands['Player'][]=$deck[$i];
	}
	else
	{
		$hands['Computer'][]=$deck[$i];
	}
	unset($deck[$i]);
}
$deck =array_values($deck); //reindex deck
showhands($hands);
echo "The Player's total is ";
echo getTotal($hands['Player']);
echo PHP_EOL;

// echo "The Computer's total is \n";
// echo getTotal($hands['Computer']);


//ask for choices

do 
{
	// Show the menu options
	echo '(H)it, (S)tay, (Q)uit : ';

	$input = strtoupper(trim(fgets(STDIN)));

	// Check for actionable input
    switch ($input) 
    {
    	case 'H':
    		//check if total is greater than 21
    		//call hit function
    		echo "Hit Function called\n";
    		$temparray=(hitme($deck,$hands));
    		$deck=unserialize($temparray[0]);
    		$hands=unserialize($temparray[1]);
    		//print_r($deck);
    		break;
    	case 'S':
    		//call computer_play function
			echo "Computer's turn.\n";
			comp_turn($hands,$deck);
			break;
    	case 'Q':
    		echo "Thanks for playing.\n";
    		break;
    	default:
    		echo "That's not a valid play.\n";
    		break;
    }

}
// Exit when input is (Q)uit
while ($input != 'Q');

function showhands($hands, $all=false)  //need to refactor to ONLY show hands; call the hit function multiple times for the initial deal
{
	//print_r($hands); //delete after debugging
	foreach ($hands as $hand => $cards) 
	{
		echo "{$hand}'s hand is ";//shows 'Computer's hand is...' and 'Player's hand is...'
		foreach ($cards as $card=>$value) 
		{	
			if ($hand == "Computer") //Computer
			{
				switch ($card) 
				{
					case 0:
						if ($all) 
						{
							echo "({$value})";
						}
						else
						{
							echo "(?-?)";
						}
						break;
					default:
						echo "({$value})";
						break;
				}
			}
			else  //Player
			{
				echo "({$value})";
			}
		}
		echo PHP_EOL;
	}
return $hands;
}

function comp_turn($hands,$deck)
{
	// print_r($hands);
	// print_r($deck);
	// sleep(5);
	while (getTotal($hands['Computer'])<= 16) 
	{
		echo "Computer takes a hit...It's a ";
		echo "(".$deck[0].")\n";
		$hands['Computer'][]=$deck[0];
		unset($deck[0]);
		$deck =array_values($deck);
		echo "Computer's score = ";
		echo getTotal($hands['Computer']).PHP_EOL;	
		sleep(4);
	}
	showhands($hands,True); 
	echo "Computer's score = ";
	echo getTotal($hands['Computer']).PHP_EOL;
	echo "Player's score = ";
	echo getTotal($hands['Player']).PHP_EOL;
	echo "****************************\n";
	if (strpos(getTotal($hands['Computer']),'BUSTED')===false)
	{
		echo checkwinner(getTotal($hands['Computer']), getTotal($hands['Player'])).PHP_EOL;
	}
	else
	{
		echo "Computer BUSTED...You won!!\n";
	}
	exit(0);
}

function hitme($deck,$hands)
{
	$hands['Player'][]=$deck[0];
	unset($deck[0]);
	$deck =array_values($deck);
	showhands($hands,false); 
	if (strpos(getTotal($hands['Player']),'BUSTED')!==false) 
	{
		echo getTotal($hands['Player']);
		echo PHP_EOL;
		showhands($hands,True); 
		echo "Computer wins!";
		echo PHP_EOL;
		exit(0);
	}
	echo "Player's score = ";
	echo getTotal($hands['Player']).PHP_EOL;
	$multiarray = array(serialize($deck), serialize($hands));
	return $multiarray;
}

function getTotal($hand)
{
	$total = 0;
	$Aces=0;
    // loop through hand and calculate total value
		foreach ($hand as $card)
	{
		$pieces=(explode('-', $card));
		if (is_numeric($pieces[0])) 
		{
			$total+=$pieces[0];
		}
		elseif ($pieces[0]=='A') 
		{
			$Aces+=1;
			$total+=11;
		}
		else
		{
			$total+=10;
		}
		while ($total>21 && $Aces>=1)
			{
				$total-=10;
				$Aces--;
			}
	}
	return ($total<=21)?$total:"$total (BUSTED!)";
}


function checkwinner($comp_tot, $player_tot)
{

	if ($player_tot>$comp_tot && $player_tot<=21) 
	{
		return "You won!";
	}
	elseif($player_tot<$comp_tot && $comp_tot<=21) 
	{
		return "Computer won!";
	}
	else
	{
		return "It's a push.";
	}
}

