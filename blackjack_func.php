<?php
//This is a challenge to  
//create a function which will total value of cards in Black Jack
//Date:  16 May 14
//Name:  Andre Dempsey
//Codeup Baddies


function getTotal($hand)
{
	$total = 0;
	$Aces=0;
    // loop through hand and calculate total value
    // use "explode" function to separate card suit and value
    // aces count as 11 unless you are over 21 and then they count as 1
    // K, Q, and J count as 10
    // numeric cards count as their value

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
		while ($total>21) 
		{
			while ($Aces>=1)
			{
				$total-=10;
				$Aces--;
				if ($total<=21) 
				{
					$Aces=0;
				}
			}
		}
	}
	return $total;
}

$hand = array('A-H', '5-D', 'K-C', 'A-S', 'A-H');

echo getTotal($hand);
echo PHP_EOL;



