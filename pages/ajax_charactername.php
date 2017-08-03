<?php
if(!defined('INITIALIZED'))
	exit;

echo '<?xml version="1.0" encoding="utf-8" standalone="yes"?>';
$name = strtolower(trim($_GET['a_CharacterName']));
if(empty($name))
{
	echo '<font color="red">Please enter new character name.</font>';
	exit;
}

//first word can't be:
$first_words_blocked = array('gm ','cm ', 'god ','tutor ', "'", '-');
//names blocked:
$names_blocked = array('puta', 'caralho', 'karalho', 'porra', 'buceta', 'simone', 'corno','training', 'devovorga', 'energized raging mage', 'ot', 'otserv', 'thunder', 'serve', 'trimera', 'drugo', 'drugovich','adm','godsao','godzao','godsinho','GoDzinho','godzinho','Godzinho','god','GoD','GOd','God','GOD','mage mad', 'mad mage', 'abyssador', 'armadile', 'cliff strider', 'crystalcrusher', 'damaged crystal golem', 'deathstrike', 'stone devourer', 'hideous fungus', 'humongous fungus', 'humorless fungus', 'enraged crystal golem', 'wiggler', 'lost berserker', 'lava golem', 'magma crawler', 'weeper', 'gnomevil', 'ironblight', 'orewalker', 'vulcongra', 'mushroom sniffer', 'parasite', 'infected weeper', 'doctor gnomedix', 'pythius the rotten', 'lady bug', 'manta ray', 'deepling worker', 'god alone', 'bazir', 'crawler', 'deepling guard', 'deepling spellsinger', 'deepling warrior', 'manta', 'shark', 'spidris', 'spitter', 'waspoid', 'kollos', 'insectoid scout', 'calamary', 'fish', 'hive overseer', 'jellyfish', 'northern pike', 'spidris elite', 'swarmer', 'insectoid worker', 'deepling brawler', 'deepling master librarian', 'deepling tyrant', 'deepling elite', 'floor blob', 'hive pore', 'lesser swarmer', 'adi', 'adinmin', 'adimi', 'adimin', 'task', 'task clous', 'queen', 'queen eloise', 'aa ', 'ee', " ' ", 'ii', 'oo', 'uu', 'gm','cm', 'aff ', 'god ', 'abc', 'tutor', 'game', 'admin', 'the', 'rashid', 'alesar', 'benjamin', 'suzy', 'tajis', 'sarina', 'poach', 'Nah Bob', 'galuna', 'elane', 'chonndur', 'chondur', 'addoner', 'haroun', 'yaman', 'towncryer', 'jaul', 'obujos', 'hive overseer', 'crawler', 'deepling guard', 'deepling spellsinger', 'deepling warrior', 'lady bug', 'manta', 'shark', 'spidris', 'spitter', 'waspoid', 'kollos', 'lion event', 'tiger event', 'gerador azul i', 'gerador azul ii', 'gerador azul iii', 'gerador vermelho i', 'gerador vermelho ii', 'gerador vermelho iii', 'zombie event', 'emperium', 'guard', 'feromous', 'abomination fury', 'alvo', 'gate', 'elder beholder', 'trainer', 'beholder', 'yalaharian', 'protect cube', 'protect castle', 'protect statue', 'castle gates', 'lizard magistratus', 'lizard noble', 'askarak demon', 'askarak lord', 'askarak prince', 'bog frog', 'clay guardian', 'crystal wolf', 'death priest', 'deepling scout', 'desperate white deer', 'diamond servant', 'dromedary', 'donkey', 'elder mummy', 'enraged white deer', 'feverish citizen', 'filth toad', 'firestarter', 'ghoulish hyaena', 'golden servant', 'grave guard', 'groam', 'honour guard', 'horestis', 'horse', 'incredible old witch', 'insectoid scout', 'iron servant', 'kraknaknork', 'kraknaknork demon', 'running elite orc guard', 'sacred spider', 'sandstone scorpion', 'shaburak demon', 'shaburak lord', 'shaburak prince', 'slug', 'spider queen', 'starving wolf', 'thornfire wolf', 'tomb servant', 'weakened demon', 'wild dog', 'white deer', 'yielothax', 'boar', 'cake golem', 'crustacea gigantica', 'draptor', 'ghost rat', 'midnight panther', 'slime puddle', 'spectral scum', 'stampor', 'undead cavebear', 'brimstone bug', 'draken abomination', 'draken elite', 'fury of the emperor', 'glitterscale', 'heoni', 'lizard abomination', 'snake god essence', 'scorn of the emperor', 'snake think', 'souleater', 'spite of the emperor', 'wrath of the emperor', 'draken spellweaver', 'draken warmaster', 'ghastly dragon', 'gnarlhound', 'insect swarm', 'killer caiman', 'lancer beetle', 'lizard chosen', 'lizard dragon priest', 'lizard high guard', 'lizard legionnaire', 'lizard zaogun', 'orc marauder', 'sandcrawler', 'terramite', 'undead prospector', 'skeleton', 'wailing widow', 'berserker chicken', 'boogey', 'bride of night', 'demon parrot', 'dirtbeard', 'deer', 'esmeralda', 'essence of darkness', 'evil mastermind', 'evil sheep lord', 'evil sheep', 'fahim the wise', 'hide', 'hot dog', 'killer rabbit', 'medusa', 'mephiles', 'merikh the slaughterer', 'monstor', 'rottie the rotworm', 'shardhead', 'the bloodtusk', 'the many', 'the noxious spawn', 'the snapper', 'badger', 'bat', 'bear', 'black sheep', 'blood crab', 'blood crab underwater', 'carrion worm', 'cat', 'cave rat', 'chicken', 'cockroach', 'crab', 'crocodile', 'dire penguin', 'dog', 'elephant', 'flamingo', 'hyaena', 'husky', 'kitty', 'lion', 'mad sheep', 'mammoth', 'panda', 'parrot', 'penguin', 'pig', 'polar bear', 'rabbit', 'rat', 'rotworm', 'seagull', 'sheep', 'silver rabbit', 'skunk', 'squirrel', 'terror bird', 'thornback tortoise', 'tiger', 'tortoise', 'tortoise anti-bot', 'war wolf', 'winter wolf', 'wolf', 'dwarf', 'dwarf guard', 'dwarf geomancer', 'dwarf soldier', 'quara pincher', 'quara predator', 'quara constrictor', 'quara hydromancer', 'quara mantassin', 'quara pincher scout', 'quara predator scout', 'quara constrictor scout', 'quara hydromancer scout', 'quara mantassin scout', 'sea serpent', 'young sea serpent', 'achad', 'axeitus headbanger', 'bloodpaw', 'bovinus', 'colerian the barbarian', 'cursed gladiator', 'frostfur', 'orcus the cruel', 'rocky', 'the hairy one', 'avalanche', 'drasilla', 'grimgor guteater', 'kreebosh the exile', 'slim', 'spirit of earth', 'spirit of fire', 'spirit of water', 'the dark dancer', 'the hag', 'darakan the executioner', 'deathbringer', 'fallen mooh tah master ghar', 'gnorre chyllson', 'norgle glacierbeard', 'svoren the mad', 'the masked marauder', 'the obliverator', 'the pit lord', 'webster', 'flamethrower', 'hell hole', 'lavahole', 'dwarf dispenser', 'magicthrower', 'magic pillar', 'pillar', 'mechanical figher', 'plaguethrower', 'poisonthrower', 'shredderthrower', 'barbarian bloodwalker', 'barbarian brutetamer', 'barbarian headsplitter', 'barbarian skullhunter', 'arachir the ancient one', 'armenius', 'arthei', 'apprentice sheng', 'azerus', 'barbaria', 'battlemaster zunzu', 'big boss trolliver', 'blistering fire elemental', 'boreth', 'captain jones', 'chizzoron the distorter', 'the countess sorrow', 'cublarc the plunderer', 'deadeye devious', 'demodras', 'dharalion', 'diblis the fair', 'diseased bill', 'diseased dan', 'diseased fred', 'dracola', 'dreadmaw', 'earth overlord', 'energy overlord', 'fernfang', 'ferumbras', 'fire overlord', 'fleabringer', 'foreman kneebiter', 'freegoiz', 'general murius', 'grandfather tridian', 'grand mother foulscale', 'grorlam', 'hairman the huge', 'lizard templar', 'ice overlord', 'inky', 'koshei the deathless', 'lersatio', 'lethal lissy', 'lizard gate guardian', 'lord of the elements', 'mad technomancer', 'man in the cave', 'marziel', 'massacre', 'mooh tah master', 'mr. punish', 'munster', 'necropharus', 'ron the ripper', 'renegade orc', 'rotworm queen', 'rukor zad', 'shadow of boreth', 'shadow of lersatio', 'shadow of marziel', 'shard of corruption', 'sharptooth', 'sir valorcrest', 'splasher', 'smuggler baron silvertoe', 'stonecracker', 'the blightfather', 'the big bad one', 'the collector', 'the count', 'the evil eye', 'the frog prince', 'the handmaiden', 'the horned fox', 'the imperor', 'the old widow', 'the plasmother', 'the voice of ruin', 'the weakened count', 'thul', 'tiquandas revenge', 'ungreez', 'warlord ruzad', 'yakchal', 'yalahari', 'yeti', 'zarabustor', 'zebelon duskbringer', 'zulazza the corruptor', 'chakoya toolshaper', 'chakoya tribewarden', 'chakoya windcaller', 'dark torturer', 'demon', 'destroyer', 'diabolic imp', 'fire devil', 'gozzler', 'hand of cursed fate', 'hellfire fighter', 'hellhound', 'hellspawn', 'juggernaut', 'nightmare', 'nightmare scion', 'nightstalker', 'plaguesmith', 'bazir', 'orshabaal', 'zoralurk', 'frost dragon', 'wyrm', 'dragon lord', 'dragon', 'hydra', 'dragon hatchling', 'dragon lord hatchling', 'frost dragon hatchling', 'undead dragon', 'wyvern', 'blazing fire elemental', 'charged energy elemental', 'earth elemental', 'energy elemental', 'fire elemental', 'jagged earth elemental', 'massive earth elemental', 'massive energy elemental', 'massive fire elemental', 'massive water elemental', 'muddy earth elemental', 'overcharged energy elemental', 'roaring water elemental', 'slick water elemental', 'water elemental', 'elf arcanist', 'elf scout', 'elf', 'bones', 'deathslicer', 'exp bug', 'eye of the seven', 'fluffy', 'gamemaster', 'goblin demon', 'grynch clan goblin', 'hacker', 'the halloween hare', 'the ruthless herald', 'minishabaal', 'primitive', 'servant golem', 'tha exp carrier', 'the mutated pumpkin', 'tibia bug', 'undead minion', 'ashmunrah', 'arkhothep', 'dipthrah', 'mahrdis', 'morguthis', 'omruc', 'rahemos', 'thalas', 'vashresamun', 'frost giant', 'frost giantess', 'cyclops smith', 'cyclops drone', 'behemoth', 'cyclops', 'ice golem', 'the old whopper', 'stone golem', 'war golem', 'worker golem', 'damaged worker golem', 'goblin leader', 'goblin scavenger', 'goblin', 'goblin assassin', 'dworc fleshhunter', 'dworc venomsniper', 'dworc voodoomaster', 'acolyte of the cult', 'adept of the cult', 'amazon', 'crazed beggar', 'enlightened of the cult', 'novice of the cult', 'dark monk', 'monk', 'dark apprentice', 'dark magician', 'fury', 'gladiator', 'gang member', 'ice witch', 'infernalist', 'mad scientist', 'warlock', 'witch', 'necromancer', 'priestess', 'assasin', 'bandit', 'black knight', 'hero', 'hunter', 'nomad', 'morik the gladiator', 'smuggler', 'poacher', 'thief', 'undead jester', 'valkyrie', 'yaga the crone', 'wild warrior', 'baron brute', 'coldheart', 'doomhowl', 'dreadwing', 'fatality', 'haunter', 'incineron', 'menace', 'rocko', 'the axeorcist', 'the dreadorian', 'tirecz', 'tremorak', 'lizard sentinel', 'lizard snakecharmer', 'blue djinn', 'efreet', 'green djinn', 'marid', 'braindeath', 'bonelord', 'elder bonelord', 'gazer', 'mimic', 'stalker', 'wisp', 'minotaur archer', 'minotaur guard', 'minotaur mage', 'minotaur', 'banshee', 'betrayed wraith', 'blightwalker', 'bonebeast', 'crypt shambler', 'demon skeleton', 'dreadbeast', 'gargoyle', 'ghost', 'ghoul', 'ghostly apparition', 'grim reaper', 'gravelord oshuran', 'lich', 'lost soul', 'mummy', 'phantasm', 'pythius the rotten', 'skeleton warrior', 'spectre', 'tormented ghost', 'vampire', 'vampire bride', 'undead gladiator', 'zombie', 'mutated bat', 'mutated human', 'mutated rat', 'mutated tiger', 'werewolf', 'orc berserker', 'orc leader', 'orc rider', 'orc shaman', 'orc spearman', 'orc warlord', 'orc warrior', 'orc', 'brutus bloodbeard', 'pirate buccaneer', 'pirate corsair', 'pirate cutthroat', 'pirate ghost', 'pirate marauder', 'pirate skeleton', 'carniphila', 'haunted treeling', 'spit nettle', 'kongra', 'merlkin', 'sibang', 'serpent spawn', 'apocalypse', 'infernatil', 'verminor', 'annihilon', 'golgordan', 'hellgorak', 'latrivan', 'madareth', 'rift brood', 'rift lord', 'rift phantom', 'rift scythe', 'rift worm', 'ushuriel', 'zugurosh', 'ghazbaran', 'morgaroth', 'troll champion', 'frost troll', 'island troll', 'swamp troll', 'troll', 'acid blob', 'ancient scarab', 'azure frog', 'butterfly', 'bog raider', 'bug', 'centipede', 'cobra', 'coral frog', 'crimson frog', 'crystal spider', 'death blob', 'deathspawn', 'defiler', 'giant spider', 'green frog', 'larva', 'mercury blob', 'orchid frog', 'poison spider', 'scarab', 'scorpion', 'slime2', 'slime', 'snake', 'son of verminor', 'spider', 'tarantula', 'the abomination', 'toad', 'wasp');
//name can't contain:
$words_blocked = array('gamemaster', 'game master', 'game-master', "game'master", '  ', '--', "''","' ", " '", '- ', ' -', "-'", "'-", 'fuck', 'sux', 'suck', 'noob', 'tutor');
$temp = strspn("$name", "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM- '");
if($temp != strlen($name))
{
	echo '<font color="red">Name contains illegal letters. Use only: <b>qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM- \'</b></font>';
	exit;
}
if(strlen($name) > 25)
{
	echo '<font color="red">Too long name. Max. lenght <b>25</b> letters.</font>';
	exit;
}
foreach($names_blocked as $word)
	if($word == $name)
	{
		echo '<font color="red">Blocked names:<b> '.$names_blocked[0];
		if(count($names_blocked) > 1)
			foreach($names_blocked as $word)
				if($word != $names_blocked[0])
					echo ','.$word;
		echo '</b></font>';
		exit;
	}
foreach($first_words_blocked as $word)
	if($word == substr($name, 0, strlen($word)))
	{
		echo '<font color="red">First letters in name can\'t be:<b> '.$first_words_blocked[0];
		if(count($first_words_blocked) > 1)
			foreach($first_words_blocked as $word)
				if($word != $first_words_blocked[0])
					echo ','.$word;
		echo '</b></font>';
		exit;
	}
if(substr($name, -1) == "'" || substr($name, -1) == "-")
{
	echo '<font color="red">Last letter can\'t be <b>\'</b> and <b>-</b></font>';
	exit;
}
foreach($words_blocked as $word)
	if (!(strpos($name, $word) === false))
	{
		echo '<font color="red">Name can\'t cointain words:<b> '.$words_blocked[0];
		if(count($words_blocked) > 1)
			foreach($words_blocked as $word)
				if($word != $words_blocked[0])
					echo ','.$word;
		echo '</b></font>';
		exit;
	}
for($i = 0; $i < strlen($name); $i++)
	if($name[$i] == $name[($i+1)] && $name[$i] == $name[($i+2)])
	{
		echo '<font color="red">Name can\'t contain 3 same letters one by one.</font><br /><font color="green"><u>Good:</u> M<b>oo</b>nster</font><font color="red"><br />Wrong: M<b>ooo</b>nster</font>';
		exit;
	}
for($i = 0; $i < strlen($name); $i++)
	if($name[$i-1] == ' ' && $name[$i+1] == ' ')
	{
		echo '<font color="red">Use normal name format.</font><br /><font color="green"><u>Good:</u> <b>Gesior</b></font><font color="red"><br />Wrong: <b>G e s ior</b></font>';
		exit;
	}
if(substr($name, 1, 1) == ' ')
{
	echo '<font color="red">Use normal name format.</font><br /><font color="green"><u>Good:</u> <b>Gesior</b></font><font color="red"><br />Wrong: <b>G esior</b></font>';
	exit;
}
if(substr($name, -2, 1) == " ")
{
	echo '<font color="red">Use normal name format.</font><br /><font color="green"><u>Good:</u> <b>Gesior</b></font><font color="red"><br />Wrong: <b>Gesio r</b></font>';
	exit;
}
$name_db = new Player();
$name_db->find($name);
if($name_db->isLoaded())
	echo '<font color="red"><b>Player with this name already exist.</b></font>';
else
	echo '<font color="green">Good. Your name will be:<br />"<b>'.htmlspecialchars(ucwords($name)).'</b>"</font>';
exit;