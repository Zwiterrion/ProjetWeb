<?php

/* 
   Recherche en texte libre fait maison.
*/

// retourne correspondance de la chaîne b avec la chaîne de référence a (0 à 1)
// méthode très (trop) tolérante, marche mal sur des grandes chaînes avec plusieurs mots
// améliorations simples possibles: ordre; nb occurence max dans filter...
function fit($a, $b)
{
  $a = iconv("UTF-8", "ASCII//TRANSLIT//IGNORE", $a);
  $b = iconv("UTF-8", "ASCII//TRANSLIT//IGNORE", $b);

  $aCount = strlen($a);
  $bCount = strlen($a);

  $aPos = charPos($a);
  $bPos = charPos($b);

  $aCharFit = 1 - (filter($aPos, $bPos) / (float) $aCount);
  $bCharFit = 1 - (filter($bPos, $aPos) / (float) $bCount);

  if (count($aPos) == 0 or count($bPos) == 0)
    return 0;

  $avg = avgShift($aPos, $bPos, 0, 'identity');

  $shiftFit1 = 1 - (avgShift($aPos, $bPos, $avg, 'abs') / (float) max($aCount,$bCount));
  $shiftFit2 = 1 - (avgShift($aPos, $bPos, 0, 'abs')    / (float) max($aCount,$bCount));
  $shiftFit = max($shiftFit1, $shiftFit2);

  return 0.2 * $aCharFit + 0.1 * $bCharFit + 0.7 * $shiftFit;
}

function avgShift($aPos, $bPos, $shift, $f)
{
  $sum = 0;
  $count = 0;

  foreach($aPos as $c => $aPos_)
  {
    $bPos_ = $bPos[$c];

    foreach($aPos_ as $i => $p1)
    {
      if (! isset($bPos_[$i]))
	break;

      $sum += $f($bPos_[$i] - ($p1 + $shift));
      $count++;
    }
  }

  return $sum / (float) $count;
}
function identity($x) { return $x; };

function charPos($str)
{
  $res = [];
  for ($i=0; $i<strlen($str); $i++)
  {
    $c = $str[$i];
    if (! isset($res[$c]))
      $res[$c] = [];

    array_push($res[$c], $i);
  }

  return $res;
}

function filter(&$array, $filter)
{
  $count = 0;
  foreach($array as $k => $v)
  {
    if (! array_key_exists($k, $filter))
    {
      $count += count($v);
      unset($array[$k]);
    }
  }

  return $count;
}

/*
$testdb =  [

["SongName","ArtistName","AlbumName"]
,["New Born","Muse","Origin of Symmetry"]
,["Wolf & Raven","Sonata Arctica","Silence"]
,["Friend Or Foe","T A T U","Dangerous and Moving"]
,["Acid Rain","Angra","Rebirth"]
,["The Mass","Era","The Mass"]
,["All About Us","T A T U","Dangerous and Moving"]
,["No Son of Mine","Genesis","Turn It On Again: The Hits"]
,["Introduction","Mike Oldfield","Tubular Bells 2003"]
,["To Zanarkand","植松伸夫","Final Fantasy X Ost"]
,["San Sebastian","Sonata Arctica","Winterheart's Guild"]
,["4000 Rainy Nights","Stratovarius","The Chosen Ones"]
,["Primavera","Ludovico Einaudi","Divenire"]
,["Sweet Home Chicago","Eric Clapton","Sessions for Robert J"]
,["Close My Eyes Forever","Ozzy Osbourne","Secret Songs"]
,["Transylvania","Iron Maiden","Iron Maiden [Bonus Track]"]
,["Misery Is a Butterfly","Blonde Redhead","Misery Is a Butterfly"]
,["La Ritournelle","Sébastien Tellier","Sessions"]
,["Testarossa Autodrive","Kavinsky","Teddy Boy"]
,["Testarossa Nightdrive","Kavinsky","Teddy Boy EP"]
,["Rock You Like A Hurricane","Scorpions","Love At First Sting"]
,["Waves","Guthrie Govan","Erotic Cakes"]
,["Funk (The Bloody Beetroots Remix)","Etienne De Crecy","Commercial EP2"]
,["What Kind of Love","Avantasia","The Scarecrow"]
,["Can't Stand Losing You","The Police","Greatest Hits"]
,["Don't Say a Word","Sonata Arctica","Reckoning Night"]
,["Walking on the Moon","The Police","Greatest Hits"]
,["Evidence","Marilyn Manson","Eat Me Drink Me"]
,["Human Nature","Miles Davis","This is Jazz, Vol. 38: Electric"]
,["... Passing By","Ulrich Schnauss","Far Away Trains Passing By"]
,["Dead Cruiser","Kavinsky","Mini LP"]
,["We As Americans","Eminem","Encore"]
,["The Beginning","ᛏᛣᚱ","Ragnarok"]
,["The Rage of the Skullgaffer","ᛏᛣᚱ","Ragnarok"]
,["Bye Bye Beautiful","Nightwish","Dark Passion Play"]
,["Victoria's Secret","Sonata Arctica","Winterheart's Guild"]
,["One","Metallica","...and Justice for All"]
,["Crimson Tide / Deep Blue Sea (live)","Nightwish","From Wishes To Eternity"]
,["Toccata & Fugue in D Minor","Johann Sebastian Bach","Bach: Greatest Hits"]
,["Fade to Black","Sonata Arctica","Great Metal Covers 15"]
,["Heartbeats","The Knife","XMIX_2006"]
,["Wasted Years","Iron Maiden","Best of the Beast"]
,["Fear of the Dark (live)","Iron Maiden","Best of the Beast"]
,["Welcome Home (Sanitarium)","Metallica","1992-10-24: Blitzkrieg on Wembley: London, UK"]
,["Ding Dong Song","Günther & The Sunshine Girls","Pleasureman"]
,["Space-Dye Vest","Dream Theater","Awake Demos 1994"]
,["The Legend Of Zelda","System of a Down","Songs"]
,["Tonight","Yuksek","Away From the Sea"]
,["Gather the Faithful (instrumental)","Cain's Offering","Gather the Faithful"]
,["Another Part Of Me (Single Version)","Michael Jackson","The Collection"]
,["Hibernaculum","Mike Oldfield","The Songs of Distant Earth"]
,["Exogenesis: Symphony, Part 1: Overture","Muse","The Resistance"]
,["Exogenesis: Symphony, Part 2: Cross-Pollination","Muse","The Resistance"]
,["Exogenesis: Symphony, Part 3: Redemption","Muse","The Resistance"]
,["Zeroes","Sonata Arctica","The Days of Grays"]
,["Second Streets Have No Name (feat. Beta Bow)","The Bloody Beetroots","Romborama"]
,["Dominos","The Big Pink","A Brief History of Love"]
,["The Death of Cornelius (Overture)","The Bloody Beetroots","Cornelius EP"]
,["Splash","Sub Focus","Sub Focus"]
,["Rock It","Sub Focus","Sub Focus"]
,["Ameno","Era","Ameno"]
,["Mausam & Escape","A. R. Rahman","Slumdog Millionaire"]
,["Vodka","Korpiklaani","Karkelo"]
,["Liberian Girl","Michael Jackson","BAD"]
,["Deep Frozen","Delain","Lucidity"]
,["You're No Different","Ozzy Osbourne","Bark at the Moon"]
,["Down The Drain","Lilly wood & the prick ","Lilly What & Who ?"]
,["Draw Me","Sonata Arctica","Winterheart's Guild"]
,["A Thousand Words","Gwyllion","The Edge Of All I Know"]
,["Entwined","Gwyllion","The Edge Of All I Know"]
,["Roots of Reality","Gwyllion","The Edge Of All I Know"]
,["The Night Awakes","Gwyllion","The Edge Of All I Know"]
,["Somebody Told Me","The Killers","Live From The Royal Albert Hall"]
,["A Thousand Miles","Vanessa Carlton","Be Not Nobody"]
,["Amoureux de ma femme","Richard Anthony","Les Plus Grandes Chansons"]
,["L'aigle noir","Barbara",""]
,["Moonlight Reflection","Sengir","Guilty Water"]
,["Your Star","Evanescence","The Open Door"]
,["Gethsemane","Nightwish","Oceanborn (Finnish 2008 Edition)"]
,["Intimate","Crystal Castles","Crystal Castles"]
,["Please Betray Me","Dark Princess","Stop My Heart"]
,["No Pain","Dark Princess","Stop My Heart"]
,["Oops! I Did It Again","Children Of Bodom","Covers by Children of Bodom"]
,["The Misery","Sonata Arctica","Metal Ballads"]
,["05 - The Burning","ᛏᛣᚱ","Ragnarok"]
,["Phantom, Part II","Justice","✝"]
,["Genesis","Justice","†"]
,["Tragedy","Bee Gees","The Ultimate Bee Gees"]
,["They don't care about us","Micheal Jackson","History Continues"]
,["Toccata","David Garrett","Rock Symphonies"]
,["She Will Be Loved","Runner Runner","Rockin' Romance"]
,["General Motors, Detroit, America","Acid Washed","Acid Washed"]
,["Not in Love (feat. Robert Smith)","Crystal Castles","Not in Love"]
,["1986 (Unreleased)","Kavinsky","Blazer EP"]
,["While Your Lips Are Still Red","Nightwish","Made in Hong Kong (and in Various Other Places)"]
,["Say Good-Bye","Forever Slave","Tales for Bad Girls"]
,["Scary Like a G6 (Baby Armie Blend)","Far East Movement vs. Skrillex","Always the Movement"]
,["Phantom","Justice","✝"]
,["Grand Canyon","Kavinsky","Mini LP"]
,["Nightcall","Kavinsky","Nightcall"]
,["My Life Be Like","Grits","My Life"]
,["Smooth Criminal","Micheal Jackson","R'n'B 70-80-90"]
,["Come Now Follow","Amberian Dawn","End of Eden"]
,["Live to Tell","Madonna","The Immaculate Collection"]
,["Holy Solos","Stratovarius","Visions of Europe"]
,["Untrust Us","Crystal Castles","Untrust Us"]
,["Beat It","Micheal Jackson","Beat It"]
,["Rain And Tears","Aphrodite's Child","The best of 50-60-70-80-90"]
,["Dream","P. Lion","Springtime"]
,["Toxicity (Version 7.0)","System of a Down","Toxicity"]
,["Pimpa's Paradise (feat. Stephen Marley & Black Thought)","Damian Marley","Welcome to Jamrock"]
,["Fear of the dark","Iron Maiden","A Real Dead One"]
,["Bleeding Heart","Angra","Rebirth"]
,["Deception","Saint Deamon","Pandeamonium"]
,["A Day to Come","Saint Deamon","Pandeamonium"]
,["Solar Sailer (Remixed By Pretty Lights)","Daft Punk","Tron Legacy Reconfigured"]
,["Midnight Mover","Accept","Metal Heart"]
,["Solar Sailer","Pretty Lights","TRON: Legacy R3CONF1GUR3D"]
,["Tetra","SebastiAn","Total"]
,["Radio/Video","System of a Down","Mezmerize"]
,["Nine Worlds Of Lore","ᛏᛣᚱ","The Lay of Thrym"]
,["Flames Of The Free","ᛏᛣᚱ","The Lay of Thrym"]
,["My Name Is Stain","Shaka Ponk","The Geeks and the Jerkin' Socks?"]
,["Born Again","Black Sabbath","Born Again"]
,["Smells Like Teen Spirit","David Garrett","Rock Symphonies"]
,["Dirty Diana","Micheal Jackson","Number Ones"]
,["Shall We Take a Turn?","Korpiklaani","Korven kuningas"]
,["Last night","Skillet","Comatose"]
,["Concerto For Violin In G Minor (Summer): III. Presto","Vivaldi","Vivaldi: The Four Seasons"]
,["Hold The Line","Toto","Toto - Best Of"]
,["A merced de la lluvia","Ebony Ark","When the City Is Quiet"]
,["Julia","Eurythmics","1984: For the Love of Big Brother"]
,["Guilty Water","Sengir","Guilty Water"]
,["Spiders","System of a Down","American Recordings"]
,["Funk (The Bloody Beetroots remix)","The Bloody Beetroots","Best of... Remixes"]
,["Wuthering Heights","Angra","Angels Cry"]
,["She Bop","Cyndi Lauper","The Body Acoustic"]
,["D.A.N.C.E.","EMPdragon","✝"]
,["Fade to Black","Metallica","Ride the Lightning"]
,["Comptine d'un autre été : L'Après-midi","Yann Tiersen","Le Fabuleux Destin d'Amélie Poulain"]
,["Jeanne","Laurent Voulzy","Lys and Love"]
,["The Final Count Down","Europe","The Final Countdown"]
,["Ghost River","Nightwish","Imaginaerum"]
,["I Want My Tears Back","Nightwish","Imaginaerum"]
,["The Crow, the Owl and the Dove","Nightwish","Imaginaerum"]
,["Morpheus","Etienne De Crecy","Super Discount 2"]
,["Moonlight Shadow","Mike Oldfield","Crises"]
,["Call Me When You’re Sober","Evanescence","The Open Door"]
,["The Islander","Nightwish","The Islander"]
,["Blackout (Billy Van Remix)","Billy Van","The Cardigan EP"]
,["Roadgame","Kavinsky","Nightcall EP + Roadgame"]
,["Born Yesterday","Rob Dougan","Furious Angels"]
,["Always On The Run","Yuksek","SXSW 2012 Showcasing Artists"]
,["Pass this on","The Knife","Deep Cuts"]
,["Mother","The Bloody Beetroots","Romborama"]
,["Behind The Bushes","The Knife","Deep Cuts"]
,["Binary (Dirty Disco Youth Remix)","Etienne De Crecy","Binary EP"]
,["Wuthering Heights","Kate Bush","The Kick Inside"]
,["*","M83","Before the Dawn Heals Us"]
,["Mary","Yann Tiersen","Les Retrouvailles"]
,["I Have a Right","Sonata Arctica","Stones Grow Her Name"]
,["The Day","Sonata Arctica","Stones Grow Her Name"]
,["Cinderblox","Sonata Arctica","Stones Grow Her Name"]
,["Where Is the Blood (feat. Burton C. Bell)","Delain","We Are the Others"]
,["Part That Won't Let Go","Wavorly","The EP"]
,["Blackstar","Celldweller","Wish Upon a Blackstar"]
,["Birthright","Celldweller","Wish Upon a Blackstar"]
,["Silently","Blonde Redhead","23"]
,["Second Lives","Vitalic","Flashmob"]
,["Cyberspace","BATTLE BEAST","Steel"]
,["Dreamweaver","Stratovarius","Elements, Part 2"]
,["Carry Me Over","Avantasia","The Scarecrow"]
,["Soothsayer","Buckethead","Crime Slunk Scene"]
,["Crimewave","Crystal Castles","Crystal Castles (II)"]
,["Everything Fades to Gray (instrumental)","Sonata Arctica","The Days of Grays"]
,["Amaranth","Nightwish","Amaranth"]
,["Don't Say A Word/Outro","Sonata Arctica","Live in Finland"]
,["Burn","I Will Never Be The Same","Standby"]
,["Sumussa hämärän aamun","Korpiklaani","Manala"]
,["Such a Shame","Talk Talk","Natural History: The Very Best of Talk Talk"]
,["Changed the way you kiss me","Nightcore","Unknown Album"]
,["Price Of Fame","Michael Jackson","Bad 25"]
,["Iron Man","Ozzy Osbourne","Tribute"]
,["Bounce (The Bloody Beetroots remix) (feat. N.O.R.E. & Isis Salam)","The Bloody Beetroots","Best of... Remixes"]
,["Storytime","Nightwish","Imaginaerum"]
,["Dolls","Crystal Castles","Untrust Us"]
,["Land of Snow and Sorrow","Wintersun","Time I"]
,["Tonight I Dance Alone","Sonata Arctica","Stones Grow Her Name"]
,["I Take Comfort in Your Ignorance","Ulrich Schnauss","A Long Way to Fall"]
,["Welcome (The Bloody Beetroots Remix)","The Bloody Beetroots","Bloody Beetroots Best of Remixes"]
,["Dawn of Solace","Cain's Offering","Gather the Faithful"]
,["More Than Friends","Cain's Offering","Gather the Faithful"]
,["Russian Attractions","Sébastien Tellier","My God Is Blue"]
,["We Are the Others","Delain","We Are the Others"]
,["Pellonpekko","Korpiklaani","Spirit of the Forest"]
,["Pixies Dance","Korpiklaani","Spirit of the Forest"]
,["Under The Bridge (Brummer Remix)","Red Hot Chili Peppers","Ohheydoctor.com"]
,["Oblivion (feat. Susanne Sundfør)","M83","Oblivion: Original Motion Picture Soundtrack"]
,["Rasputin [Cover of Boney M]","Turisas","Rasputin"]
,["Take the Day!","Turisas","Stand Up and Fight"]
,["Those Were the Days","Turisas","The Heart of Turisas"]
,["Chronicles of a Fallen Love","The Bloody Beetroots","Hide"]
,["Rocksteady","The Bloody Beetroots","Rocksteady"]
,["Beware the Stroke","Almah","Unfold"]
,["Keep Your Dream Alive","Masterplan","Novum Initium"]
,["Dreams and Pyres","Falconer","Among Beggars and Thieves"]
,["Giorgio by Moroder","Daft punk","Random Acces Memories"]
,["Instant Crush","Daft punk","Random Acces Memories"]
,["The Eternal Wayfarer","Edguy","Space Police - Defenders of the Crown"]
,["Walking with Elephants","Ten Walls","Walking with Elephants"]
,["Witches Gather","Elvenking","The Pagan Manifesto"]
,["Heavy Chill","Equilibrium","Erdentempel"]
,["Warriors","Imagine Dragons","League of Legends 2014 World Championship"]
,["Take Me To Church","Hozier","Take Me To Church E.P."]
];

$str = '';
$res = [];
foreach($testdb as $i => $e)
{
  array_push($res, [max(fit($str,$e[0]), fit($str,$e[1]), fit($str,$e[2])), $e[0].", ".$e[1].", ".$e[2]]);
}
usort($res, function($a,$b) { return ($a[0]-$b[0] < 0) ? -1 : 1; });

foreach($res as $e)
{
  echo $e[0]." | ".$e[1]."\n";
}
*/
