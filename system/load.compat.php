<?php
if(!defined('INITIALIZED'))
	exit;

// DEFINE VARIABLES FOR SCRIPTS AND LAYOUTS (no more notices 'undefinied variable'!)
if(!isset($_REQUEST['subtopic']) || empty($_REQUEST['subtopic']) || is_array($_REQUEST['subtopic']))
{
	$_REQUEST['subtopic'] = "latestnews";
}
else
	$_REQUEST['subtopic'] = (string) $_REQUEST['subtopic'];

if(Functions::isValidFolderName($_REQUEST['subtopic']))
{
	if(Website::fileExists("pages/" . $_REQUEST['subtopic'] . ".php"))
	{
		$subtopic = $_REQUEST['subtopic'];
	}
	else
		new Error_Critic('CRITICAL ERROR', 'Cannot load page <b>' . htmlspecialchars($_REQUEST['subtopic']) . '</b>, file does not exist.');
}
else
	new Error_Critic('CRITICAL ERROR', 'Cannot load page <b>' . htmlspecialchars($_REQUEST['subtopic']) . '</b>, invalid file name [contains illegal characters].');

// action that page should execute
if(isset($_REQUEST['action']))
	$action = (string) $_REQUEST['action'];
else
	$action = '';

$logged = false;
$account_logged = new Account();
$group_id_of_acc_logged = 0;
// with ONLY_PAGE option we want disable useless SQL queries
if(!ONLY_PAGE)
{
	// logged boolean value: true/false
	$logged = Visitor::isLogged();
	// Account object with account of logged player or empty Account
	$account_logged = Visitor::getAccount();
	// group of acc. logged
	if(Visitor::isLogged())
		$group_id_of_acc_logged = Visitor::getAccount()->getPageAccess();
}
$layout_name = './layouts/' . Website::getWebsiteConfig()->getValue('layout');

$title = ucwords($subtopic) . ' - ' . Website::getServerConfig()->getValue('serverName');

$topic = $subtopic;

$passwordency = Website::getServerConfig()->getValue('passwordType');
if($passwordency == 'plain')
	$passwordency = '';

$news_content = '';
$vocation_name = array();
foreach(Website::getVocations() as $vocation)
{
	$vocation_name[$vocation->getId()] = $vocation->getName();
}

$layout_ini = parse_ini_file($layout_name.'/layout_config.ini');
foreach($layout_ini as $key => $value)
	$config['site'][$key] = $value;

//###################### FUNCTIONS ######################
function microtime_float()
{
	return microtime(true);
}

function isPremium($premdays, $lastday)
{
	return Functions::isPremium($premdays, $lastday);
}

function saveconfig_ini($config)
{
	new Error_Critic('', 'function <i>saveconfig_ini</i> is deprecated. Do not use it.');
}

function password_ency($password, $account = null)
{
	new Error_Critic('', 'function <i>password_ency</i> is deprecated. Do not use it.');
}

function check_name($name)
{
	$name = (string) $name;
	$temp = strspn("$name", "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM- [ ] '");
	if($temp != strlen($name))
		return false;
	if(strlen($name) > 25)
		return false;

	return true;
}

function check_account_name($name)
{
	$name = (string) $name;
	$temp = strspn("$name", "QWERTYUIOPASDFGHJKLZXCVBNM0123456789");
	if ($temp != strlen($name))
		return false;
	if(strlen($name) < 1)
		return false;
	if(strlen($name) > 32)
		return false;

	return true;
}

function check_name_new_char($name)
{
	$name = (string) $name;
	$name_to_check = strtolower($name);
	//first word can't be:
	$first_words_blocked = array('gm ','cm ', 'god ','tutor ', "'", '-');
	//names blocked:
    $names_blocked = array('gm','cm', 'god', 'tutor', 'relembra', 'lixo', 'server', 'reset', 'suporte', 'support', 'senior', 'rashid', 'rashid', 'yasir', 'ukea', 'shirith', 'shiriel', 'shanar', 'roderick', 'repenter', 'Olrik', 'maealil', 'llathriel', 'lavirias', 'larfion the shaman', 'irea', 'huntsman', 'guide thelandil', 'finarfin', 'faluae', 'eroth', 'elvith', 'elf guard', 'elathriel', 'edala', 'dreadeye', 'cruleo', 'ceiron', 'captain seagull', 'briasol', 'brasith', 'benevola', 'bashira', 'ashari', 'anerui', 'an Old dragonlord', 'amarie', 'a wrinkled bonelord', 'a sweaty cyclops', 'william', 'trisha', 'toothless tim', 'tibra', 'shauna', 'sarina', 'rowenna', 'rachel', 'queen eloise', 'phillip', 'percybald', 'perac', 'padreia', 'nydala', 'nielson', 'lothar', 'liane', 'legola', 'lector', 'lea', 'karl', 'imalas', 'guide alexena', 'friedolin', 'florentine', 'fenbala', 'eva', 'emma', 'dane', 'dalbrect', 'cornelia', 'cerdras', 'captain greyhound', 'busty bonecrusher', 'bunny bonecrusher', 'blossom bonecrusher', 'benny the baker', 'barbara', 'bambi bonecrusher', 'arkarra', 'alia', 'xelvar', 'uzgod', 'tulf', 'tezila', 'talphion', 'storkus', 'sigurd', 'shortsighted dwarf', 'scutty', 'robson', 'riddler', 'rapanaio', 'pydar', 'pukosch', 'nezil', 'melfar', 'maryza', 'malech', 'lunch', 'lukosch', 'lokur', 'kroox', 'kawill', 'junkar', 'jimbin', 'jagran', 'iwar', 'isimov', 'humnog the guard', 'humgolf', 'grodrik', 'gewen', 'ferus', 'etzel', 'emperor kruzak', 'dwarven guard', 'duria', 'dukosch', 'dronk', 'burt', 'budrik', 'brom', 'brodrosch', 'bezil', 'basilisk', 'alberto', 'a dwarven ghost', 'al dee', 'amber', 'an Orc guard', 'asralius', 'azure frog', 'bog frog', 'coral frog', 'crimson frog', 'deathspawn', 'filth toad', 'green frog', 'infernal frog', 'Orchid frog', 'toad', 'the frog prince', 'quara constrictor', 'quara hydromancer', 'quara mantassin', 'quara pincher', 'quara predator', 'quara constrictor scout', 'quara hydromancer scout', 'quara mantassin scout', 'quara pincher scout', 'quara predator scout', 'renegade quara constrictor', 'renegade quara hydromancer', 'renegade quara mantassin', 'renegade quara pincher', 'renegade quara predator', 'inky', 'sharptooth', 'splasher', 'thul', 'deepling brawler', 'deepling elite', 'deepling guard', 'deepling master librarian', 'deepling scout', 'deepling spellsinger', 'deepling tyrant', 'deepling warrior', 'deepling worker', 'groam', 'jaul', 'Obujos', 'tanjis', 'salamander', 'crystal spider', 'dawn scorpion', 'frost spider', 'giant spider', 'instable sparkion', 'poison spider', 'sacred spider', 'sandstone scorpion', 'scorpion', 'sparkion', 'spider', 'tarantula', 'wailing widow', 'hide', 'mamma longlegs', 'spider queen', 'the bloodweb', 'the Old widow', 'webster', 'blood crab', 'crab', 'crustacea gigantica', 'deepsea blood crab', 'ancient scarab', 'berrypest', 'brimstone bug', 'bug', 'butterfly', 'dawnfly', 'emerald damselfly', 'insect swarm', 'insectoid scout', 'insectoid worker', 'kollos', 'lady bug', 'lancer beetle', 'larva', 'lesser swarmer', 'parasite', 'sandcrawler', 'scarab', 'shimmying butterfly', 'spidris', 'spidris elite', 'spitter', 'swarmer', 'swarmer hatchling', 'terramite', 'wasp', 'waspoid', 'anmothra', 'chopper', 'fleshcrawler', 'fleshslicer', 'hive Overseer', 'maw', 'mindmasher', 'rotspit', 'sulphur scuttler', 'the blightfather', 'willi wasp', 'anmothra', 'centipede', 'crawler', 'wiggler', 'abyssador', 'shadowstalker', 'apocalypse', 'bazir', 'infernatil', 'verminor', 'annihilon', 'golgordan', 'hellgorak', 'latrivan', 'madareth', 'ushuriel', 'zugurosh', 'angry demon', 'askarak demon', 'askarak lord', 'askarak prince', 'choking fear', 'damned soul', 'dark torturer', 'demon', 'demon Outcast', 'destroyer', 'diabolic imp', 'eclipse knight', 'enthralled demon', 'feversleep', 'fire devil', 'frazzlemaw', 'gloombringer', 'gozzler', 'grave guard', 'gravedigger', 'grimeleech', 'guzzlemaw', 'hand of cursed fate', 'harbinger of darkness', 'hellflayer', 'hellhound', 'hellspawn', 'herald of gloom', 'juggernaut', 'lesser fire devil', 'pit berserker', 'nightmare', 'nightmare scion', 'pit battler', 'nightstalker', 'pit blacking', 'pit brawler', 'plaguesmith', 'retching horror', 'rift brood', 'rift lord', 'rift phantom', 'rift scythe', 'rift worm', 'shaburak demon', 'shaburak lord', 'shaburak prince', 'shadow fiend', 'shadow hound', 'shiversleep', 'shock head', 'sight of surrender', 'silencer', 'sin devourer', 'tentacle of the deep terror', 'terrorsleep', 'the fettered shatterer', 'unbound demon', 'unbound demon Outcast', 'vexclaw', 'weakened demon', 'yielothax', 'boogey', 'bretzecutioner', 'flameborn', 'horadron', 'kerberos', 'massacre', 'mawhawk', 'mazoran', 'mephiles', 'monstor', 'Omrafir', 'Orshabaal', 'phrodomo', 'plagirath', 'prince drazzak', 'ragiaz', 'razzagorn', 'shulgrax', 'tarbaz', 'terofar', 'the handmaiden', 'the imperor', 'the shatterer', 'tormentor', 'ungreez', 'zavarash', 'haunter', 'the dreadorian', 'the masked marauder', 'the Obliverator', 'eclipse knight', 'gloombringer', 'harbinger of darkness', 'herald of gloom', 'phrodomo', 'shadow hound', 'spawn of despair', 'morgaroth', 'zoralurk', 'angry plant', 'bane bringer', 'blood beast', 'bog raider', 'carniphila', 'defiler', 'devourer', 'disgusting Ooze', 'empowered glooth horror', 'feeble glooth horror', 'glooth anemone', 'glooth horror', 'haunted treeling', 'hideous fungus', 'humongous fungus', 'humorless fungus', 'leaf golem', 'mechanical fighter', 'Omnivora', 'possessed tree', 'spit nettle', 'swampling', 'wilting leaf golem', 'woodling', 'bane lord', 'deathbine', 'deep terror', 'diseased bill', 'diseased dan', 'lisa', 'the abomination', 'tiquandas revenge', 'glooth blob', 'death blob', 'acid blob', 'mercury blob', 'midnight spawn', 'essence of darkness', 'midnight spawn', 'frost servant', 'ice golem', 'lost time', 'solid frozen horror', 'shardhead', 'breach brood', 'charged energy elemental', 'dread intruder', 'energy elemental', 'high voltage elemental', 'instable breach brood', 'instable sparkion', 'massive energy elemental', 'Overcharged energy elemental', 'reality reaver', 'sparkion', 'stabilizing reality reaver', 'anomaly', 'energy Overlord', 'earth Overlord', 'energy Overlord', 'fire Overlord', 'ice Overlord', 'lord of the elements', 'armadile', 'clay guardian', 'cliff strider', 'control tower', 'crystal crusher', 'damaged worker golem', 'diamond servant', 'diamond servant replica', 'earth elemental', 'elder forest fury', 'enraged crystal golem', 'eternal guardian', 'forest fury', 'gargoyle', 'glooth golem', 'golden servant', 'golden servant replica', 'infected weeper', 'iron servant', 'iron servant replica', 'jagged earth elemental', 'lava golem', 'magma crawler', 'massive earth elemental', 'medusa', 'metal gargoyle', 'minion of versperoth', 'muddy earth elemental', 'Orewalker', 'rustheap golem', 'stone devourer', 'stone golem', 'vulcongra', 'walker', 'war golem', 'weeper', 'worker golem', 'abyssador', 'deathstrike', 'earth Overlord', 'glooth fairy', 'gorgo', 'professor maxxen', 'massive water elemental', 'roaring water elemental', 'slick water elemental', 'spirit of fertility', 'water elemental', 'blazing fire elemental', 'blistering fire elemental', 'fire elemental', 'flame of Omrafir', 'hellfire fighter', 'infected weeper', 'lava golem', 'magma crawler', 'massive fire elemental', 'Orewalker', 'thornfire wolf', 'vulcongra', 'weeper', 'fire Overlord', 'dwarf', 'dwarf guard', 'dwarf geomancer', 'dwarf soldier', 'lost basher', 'lost berserker', 'lost husher', 'lost thrower', 'foreman kneebiter', 'gnomevil', 'lloyd', 'elf', 'elf arcanist', 'elf Overseer', 'elf scout', 'firestarter', 'mornenion', 'behemoth', 'cyclops', 'cyclops drone', 'cyclops smith', 'frost giant', 'frost giantess', 'juvenile cyclops', 'Orclops doomhauler', 'Orclops ravager', 'yeti', 'stonecracker', 'goblin', 'goblin assassin', 'goblin leader', 'goblin scavenger', 'grynch clan goblin', 'muglex clan assassin', 'muglex clan footman', 'muglex clan scavenger', 'Orc', 'Orc berserker', 'Orc leader', 'Orc marauder', 'Orc rider', 'Orc shaman', 'Orc spearman', 'Orc warlord', 'Orc warrior', 'rorc', 'scar tribe shaman', 'hacker', 'frost troll', 'furious troll', 'island troll', 'mountain troll', 'swamp troll', 'troll', 'troll champion', 'troll guard', 'troll legionnaire', 'troll marauder', 'young troll', 'big boss trolliver', 'salamander trainer', 'Ogre brute', 'Ogre savage', 'Ogre shaman', 'amazon', 'valkyrie', 'xenia', 'barbarian bloodwalker', 'barbarian brutetamer', 'barbarian headsplitter', 'barbarian skullhunter', 'barbaria', 'dark monk', 'monk', 'acolyte of darkness', 'blood hand', 'blood priest', 'bride of night', 'necromancer', 'priestess', 'shadow pupil', 'necropharus', 'adventurer', 'angry adventurer', 'assassin', 'bandit', 'black knight', 'crazed beggar', 'crypt defiler', 'elvira hammerthrust', 'feverish citizen', 'gang member', 'gladiator', 'glooth bandit', 'glooth brigand', 'grave robber', 'hero', 'hunter', 'jesse the wicked', 'midnight warrior', 'mornenion', 'mutated human', 'nightslayer', 'nomad', 'poacher', 'primitive', 'renegade knight', 'robby the reckless', 'smuggler', 'stalker', 'thief', 'vicious squire', 'vile grandmaster', 'wild warrior', 'pirate buccaneer', 'pirate corsair', 'pirate cutthroat', 'pirate ghost', 'pirate marauder', 'pirate skeleton', 'brutus bloodbeard', 'captain jones', 'deadeye devious', 'dirtbeard', 'lethal lissy', 'ron the ripper', 'dark apprentice', 'dark magician', 'dawnfire asura', 'fury', 'ice witch', 'infernalist', 'mad scientist', 'midnight asura', 'warlock', 'witch', 'ascending ferumbras', 'yalahari', 'azerus', 'carlin', 'venore', 'thais', 'yalahar', 'liberty bay', 'darashia', 'roshamuul', 'Oramond', 'death priest shargon', 'destabilized ferumbras', 'doctor perhaps', 'ekatrix', 'energized raging mage', 'ferumbras', 'ferumbras essence', 'ferumbras mortal shell', 'ferumbras soul splinter', 'furyosa', 'mad mage', 'raging mage', 'the flaming Orchid', 'the last lore keeper', 'yaga the crone', 'yakchal', 'zarabustor', 'zushuka', 'acolyte of the cult', 'adept of the cult', 'doomsday cultist', 'enlightened of the cult', 'novice of the cult', 'grandfather tridian', 'tzumrah the dazzler', 'doomsday cultist', 'chakoya toolshaper', 'chakoya tribewarden', 'chakoya windcaller', 'Ocyakao', 'dworc fleshhunter', 'dworc venomsniper', 'dworc voodoomaster', 'Oodok witchmaster', 'depowered minotaur', 'execowtioner', 'glooth powered minotaur', 'minotaur', 'minotaur amazon', 'minotaur archer', 'minotaur mage', 'moohtant', 'worm priestess', 'bullwark', 'the horned fox', 'corym charlatan', 'corym skirmisher', 'corym vanguard', 'little corym charlatan', 'bonelord', 'braindeath', 'elder bonelord', 'eye of the seven', 'gazer', 'evil mastermind', 'the evil eye', 'blue djinn', 'efreet', 'green djinn', 'marid', 'fahim the wise', 'merikh the slaughterer', 'kreebosh the exile', 'kongra', 'merlkin', 'sibang', 'yeti', 'freegoiz', 'hairman the huge', 'the hairy One', 'black sheep', 'boar', 'clomp', 'deer', 'desperate white deer', 'doom deer', 'dromedary', 'enraged white deer', 'evil sheep', 'evil sheep lord', 'horse', 'ironblight', 'mad sheep', 'mushroom sniffer', 'pig', 'sheep', 'stampor', 'stone rhino', 'vampire pig', 'water buffalo', 'wereboar', 'white deer', 'wild horse', 'tromphonyte', 'Owin', 'crystal wolf', 'dog', 'ghost wolf', 'gloom wolf', 'hellhound', 'hot dog', 'husky', 'poodle', 'starving wolf', 'thornfire wolf', 'war wolf', 'werewolf', 'wild dog', 'winter wolf', 'wolf', 'feroxa', 'hemming', 'kerberos', 'the big bad One', 'elephant', 'mammoth', 'terrified elephant', 'the bloodtusk', 'cat', 'lion', 'midnight panther', 'mutated tiger', 'noble lion', 'roaring lion', 'tiger', 'zomba', 'badger', 'bat', 'ghoulish hyaena', 'gnarlhound', 'hyaena', 'modified gnarlhound', 'skunk', 'werebadger', 'fleabringer', 'mutated bat', 'mutated human', 'mutated rat', 'mutated tiger', 'bruise payne', 'esmeralda', 'bear', 'panda', 'polar bear', 'undead cavebear', 'werebear', 'bloodpaw', 'cave rat', 'enraged squirrel', 'killer rabbit', 'mutated rat', 'rabbit', 'rat', 'silver rabbit', 'squirrel', 'thieving squirrel', 'esmeralda', 'munster', 'the lord of the lice', 'carrion worm', 'drillworm', 'enraged bookworm', 'rift worm', 'rotworm', 'rottie the rotworm', 'rotworm queen', 'tremor worm', 'versperoth', 'white pale', 'breach brood', 'instable breach brood', 'jellyfish', 'anomaly', 'berserker chicken', 'cave parrot', 'chicken', 'demon parrot', 'dire penguin', 'flamingo', 'marsh stalker', 'meadow strider', 'parrot', 'penguin', 'pigeon', 'seagull', 'terror bird', 'abyssal calamary', 'calamary', 'slug', 'manta ray', 'fish', 'northern pike', 'shark', 'slippery northern pike', 'guilt', 'lizard sentinel', 'lizard snakecharmer', 'lizard templar', 'wyvern', 'heoni', 'high templar cobrass', 'fatality', 'menace', 'lizard chosen', 'lizard dragon priest', 'lizard high guard', 'lizard legionnaire', 'lizard magistratus', 'lizard noble', 'lizard zaogun', 'souleater', 'battlemaster zunzu', 'fazzrah', 'flamecaller zazrak', 'lizard abomination', 'lizard gate guardian', 'mutated zalamon', 'the voice of ruin', 'draken abomination', 'draken elite', 'draken spellweaver', 'draken warmaster', 'draptor', 'wounded cave draptor', 'chizzoron the distorter', 'paiz the pauperizer', 'zulazza the corruptor', 'tirecz', 'crocodile', 'killer caiman', 'thornback tortoise', 'tortoise', 'dreadmaw', 'the snapper', 'cobra', 'hydra', 'sacred snake', 'sea serpent', 'seacrest serpent', 'serpent spawn', 'snake', 'spawn of the welter', 'young sea serpent', 'leviathan', 'snake god essence', 'snake thing', 'the keeper', 'the many', 'the noxious spawn', 'the welter', 'corrupted soul', 'dryad', 'enraged soul', 'ghost', 'ghostly apparition', 'phantasm', 'pirate ghost', 'redeemed soul', 'rift phantom', 'skullfrost', 'soul spark', 'souleater', 'spectre', 'tainted soul', 'tarnished spirit', 'tormented ghost', 'white shade', 'wisp', 'captain jones', 'countess sorrow', 'teneshpar', 'dryad', 'soul spark', 'teneshpar', 'arkhothep', 'ashmunrah', 'dipthrah', 'horestis', 'mahrdis', 'morguthis', 'Omruc', 'rahemos', 'superior death minion', 'thalas', 'the ravager', 'vashresamun', 'minion of skyrr', 'yellow toilet paper man', 'betrayed wraith', 'bonebeast', 'brittle skeleton', 'death dragon', 'demon skeleton', 'dreadbeast', 'honour guard', 'lesser death minion', 'lost soul', 'party skeleton', 'pirate skeleton', 'skeleton', 'skeleton warrior', 'undead cavebear', 'undead dragon', 'undead gladiator', 'undead mine worker', 'dracola', 'ribstride', 'teleskor', 'zanakeph', 'deathbringer', 'slim', 'bane of light', 'banshee', 'blightwalker', 'crypt shambler', 'death priest', 'death reaper', 'duskbringer', 'elder mummy', 'ghoul', 'greater death minion', 'grim reaper', 'lich', 'mummy', 'nightfiend', 'rift scythe', 'shadow tentacle', 'tomb servant', 'unbound blightwalker', 'undead jester', 'undead prospector', 'vampire', 'vampire bride', 'vampire viscount', 'vicious manbat', 'zombie', 'arachir the ancient One', 'armenius', 'arthei', 'bloom of doom', 'boreth', 'devovorga', 'devovorga', 'diblis the fair', 'gravelord Oshuran', 'koshei the deathless', 'lersatio', 'marziel', 'shadow of boreth', 'shadow of marziel', 'sir valorcrest', 'spawn of devovorga', 'the count', 'the pale count', 'the weakened count', 'vulnerable cocoon', 'zevelon duskbringer', 'cursed gladiator', 'baby dragon', 'death dragon', 'dragon', 'dragon essence', 'dragon hatchling', 'dragon lord', 'dragon lord hatchling', 'dragon servant', 'dragon warden', 'dragonking zyrtarch', 'dragonling', 'draptor', 'elder wyrm', 'fallen challenger', 'frost dragon', 'frost dragon hatchling', 'ghastly dragon', 'haunted dragon', 'ice dragon', 'somewhat beatable', 'unbeatable dragon', 'undead dragon', 'wounded cave draptor', 'wyrm', 'demodras', 'dracola', 'ethershreck', 'fury of the emperor', 'gelidrazah the frozen', 'glitterscale', 'grand mother foulscale', 'hatebreeder', 'kalyassa', 'pythius the rotten', 'scorn of the emperor', 'soul of dragonking zyrtarch', 'spite of the emperor', 'tazhadur', 'the first dragon', 'tyrn', 'wrath of the emperor', 'zanakeph', 'zorvorax', 'deathbringer', 'drasilla', 'dragon essence');
	//name can't contain:
	$words_blocked = array('gamemaster', 'game master', 'adm', 'cm', 'gm', 'tutor', 'Adm', 'reset', 'server', 'serve', 'escroto', 'noob', 'relembra', 'game-master', "game'master", '--', "''","' ", " '", '- ', ' -', "-'", "'-", 'fuck', 'sux', 'suck', 'noob', 'tutor');
	foreach($first_words_blocked as $word)
		if($word == substr($name_to_check, 0, strlen($word)))
			return false;
	if(substr($name_to_check, -1) == "'" || substr($name_to_check, -1) == "-")
		return false;
	if(substr($name_to_check, 1, 1) == ' ')
		return false;
	if(substr($name_to_check, -2, 1) == " ")
		return false;
	foreach($names_blocked as $word)
		if($word == $name_to_check)
			return false;
	for($i = 0; $i < strlen($name_to_check); $i++)
		if($name_to_check[$i-1] == ' ' && $name_to_check[$i+1] == ' ')
			return false;
	foreach($words_blocked as $word)
		if (!(strpos($name_to_check, $word) === false))
			return false;
	for($i = 0; $i < strlen($name_to_check); $i++)
		if($name_to_check[$i] == $name_to_check[($i+1)] && $name_to_check[$i] == $name_to_check[($i+2)])
			return false;
	for($i = 0; $i < strlen($name_to_check); $i++)
		if($name_to_check[$i-1] == ' ' && $name_to_check[$i+1] == ' ')
			return false;
	$temp = strspn("$name", "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM- '");
	if ($temp != strlen($name))
		return false;
	if(strlen($name) < 1)
		return false;
	if(strlen($name) > 25)
		return false;

	return true;
}

function check_rank_name($name)
{
	$name = (string) $name;
	$temp = strspn("$name", "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789-[ ] ");
	if($temp != strlen($name))
		return false;
	if(strlen($name) < 1)
		return false;
	if(strlen($name) > 60)
		return false;

	return true;
}

function check_guild_name($name)
{
	$name = (string) $name;
	$words_blocked = array('--', "''","' ", " '", '- ', ' -', "-'", "'-", '  ');
	$temp = strspn("$name", "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789-' ");
	if($temp != strlen($name))
		return false;
	if(strlen($name) < 1)
		return false;
	if(strlen($name) > 60)
		return false;

	foreach($words_blocked as $word)
		if (!(strpos($name, $word) === false))
			return false;

	return true;
}

function check_password($pass)
{
	$pass = (string) $pass;
	$temp = strspn("$pass", "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890");
	if($temp != strlen($pass))
		return false;
	if(strlen($pass) > 40)
		return false;

	return true;
}

function check_mail($email)
{
	$email = (string) $email;
	$ok = "/[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,4}/";
	return (preg_match($ok, $email))? true: false;
}

function items_on_player($characterid, $pid)
{
	new Error_Critic('', 'function <i>items_on_player</i> is deprecated. Do not use it. It used too many queries!');
}

function getReason($reasonId)
{
	return Functions::getBanReasonName($reasonId);
}

//################### DISPLAY FUNCTIONS #####################
//return shorter text (news ticker)
function short_text($text, $chars_limit) 
{
	if(strlen($text) > $chars_limit)
		return substr($text, 0, strrpos(substr($text, 0, $chars_limit), " ")).'...';
	else
		return $text;
}
//return text to news msg
function news_place()
{
	return '';
}
//set monster of week
function logo_monster()
{
	new Error_Critic('', 'function <i>logo_monster</i> is deprecated. Do not use it!');
}

// we don't want to count AJAX scripts/guild images as page views, we also don't need status
if(!ONLY_PAGE)
{
	// STATUS CHECKER
	$statustimeout = 1;
	foreach(explode("*", str_replace(" ", "", $config['server']['statusTimeout'])) as $status_var)
		if($status_var > 0)
			$statustimeout = $statustimeout * $status_var;
	$statustimeout = $statustimeout / 1000;
	$config['status'] = parse_ini_file('cache/DONT_EDIT_serverstatus.txt');
	if($config['status']['serverStatus_lastCheck']+$statustimeout < time())
	{
		$config['status']['serverStatus_checkInterval'] = $statustimeout+3;
		$config['status']['serverStatus_lastCheck'] = time();
		$statusInfo = new ServerStatus($config['server']['ip'], $config['server']['statusPort'], 1);
		if($statusInfo->isOnline())
		{
			$config['status']['serverStatus_online'] = 1;
			$config['status']['serverStatus_players'] = $statusInfo->getPlayersCount();
			$config['status']['serverStatus_playersMax'] = $statusInfo->getPlayersMaxCount();
			$h = floor($statusInfo->getUptime() / 3600);
			$m = floor(($statusInfo->getUptime() - $h*3600) / 60);
			$config['status']['serverStatus_uptime'] = $h.'h '.$m.'m';
			$config['status']['serverStatus_monsters'] = $statusInfo->getMonsters();
		}
		else
		{
			$config['status']['serverStatus_online'] = 0;
			$config['status']['serverStatus_players'] = 0;
			$config['status']['serverStatus_playersMax'] = 0;
		}
		$file = fopen("cache/DONT_EDIT_serverstatus.txt", "w");
		$file_data = '';
		foreach($config['status'] as $param => $data)
		{
	$file_data .= $param.' = "'.str_replace('"', '', $data).'"
	';
		}
		rewind($file);
		fwrite($file, $file_data);
		fclose($file);
	}
	//PAGE VIEWS COUNTER
	$views_counter = "cache/DONT_EDIT_usercounter.txt";
	// checking if the file exists
	if (file_exists($views_counter))
	{
		$actie = fopen($views_counter, "r+"); 
		if ($actie) {
			$page_views = fgets($actie, 9); 
			$page_views++; 
			rewind($actie); 
			fputs($actie, $page_views, 9); 
			fclose($actie);
		}
	}
	else
	{ 
		// the file doesn't exist, creating a new one with value 1
		$actie = fopen($views_counter, "w"); 
		$page_views = 1; 
		fputs($actie, $page_views, 9); 
		fclose($actie); 
	}
}