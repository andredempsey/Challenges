<?php

//initialize hands array
$hands = array();
$deck = array();
//start game by building deck and passing result to shuffle function
$deck = shuffle_deck(new_deck());

//deal the initial hands; four cards; first one goes to player
for ($i=1; $i<=4 ; $i++) 
{ 
	$player = ($i % 2 == 0) ? 'Computer' : 'Player';
	deal_card($deck, $hands, $player);
}

showhands($hands);
echo "The Player's total is ";
echo getTotal($hands['Player']);
echo PHP_EOL;
blackjack($hands);

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
    		deal_card($deck, $hands, 'Player');
			showhands($hands);
			echo "The Player's total is ";
			$playerpoints = getTotal($hands['Player']);
			if (strpos(getTotal($hands['Player']),'BUSTED')===false)
			{
				echo $playerpoints;
			}
			else 
			{
			 	echo "$playerpoints Player loses\n";
			 	exit(0);	
			}
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

function new_deck()
//Build deck from scratch
//Shuffle deck
//Return: $deck
{
	//Initialize the cards
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
	return $deck;
}
function shuffle_deck ($deck)
//Shuffle the deck
{
	echo "Shuffling..";
	for ($i=0; $i < 3; $i++) 
	{ 
		shuffle($deck);
		echo ".";
		sleep(1);
	}
	return $deck;
}

function deal_card(&$deck, &$hands, $player)
//Remove card from deck and add to hand
//Used for initial deal, hits
//Return: 
{
	$hands[$player][]=$deck[0];
	unset($deck[0]);
	$deck = array_values($deck); //reindex deck	
}

function showhands($hands, $all=false)
//$all flag determines if dealer's first card is shown or not
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
		sleep(2);
		echo "(".$deck[0].")\n";
		$hands['Computer'][]=$deck[0];
		unset($deck[0]);
		$deck =array_values($deck);
		echo "Computer's score = ";
		echo getTotal($hands['Computer']).PHP_EOL;	
		sleep(3);
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
function blackjack($hands)
{
	if (getTotal($hands['Computer'])==21)
	{
		if (getTotal($hands['Player'])==21) 
		{
			showhands($hands, true);
			echo "Dealer has a Black Jack!\n";
			echo "You have a Black Jack too!\n";
			echo "It's a push!\n";
			exit(0);
		}	
		showhands($hands, true);
		echo "Dealer has a Black Jack!\n";
		echo "Computer Wins!\n";
		exit(0);
	}
	elseif (getTotal($hands['Player'])==21) 
	{
		showhands($hands, true);
		echo "You have a Black Jack!\n";
		echo "You Win!\n";
		exit(0);
	}

}
