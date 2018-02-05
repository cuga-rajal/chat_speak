<?php

// Chatter v.1.0 - Feb 4, 2018
// by Cuga Rajal
//
// Run this script at thr shell to speak the local chat, using built-in text-to-speech in macOS.
// More information at https://github.com/cuga-rajal/chat_speak
// Before using please check system requirements at https://github.com/cuga-rajal/chat_speak

$voices = array(
'Agnes','Alex','Bruce','Daniel','Fiona','Fred','Junior','Karen','Kate','Kathy','Lee','Moira','Oliver','Princess','Ralph','Samantha','Serena','Susan','Tessa','Tom','Veena','Vicki','Victoria');
// 'Agnes',     //    en_US    # Isn't it nice to have a computer that will talk to you?
// 'Albert',    //    en_US    #  I have a frog in my throat. No, I mean a real frog!
// 'Alex',      //    en_US    # Most people recognize me by my voice.
// 'Alice',     //    it_IT    # Salve, mi chiamo Alice e sono una voce italiana.
// 'Allison',   //    en_US  
// 'Alva',      //    sv_SE    # Hej, jag heter Alva. Jag är en svensk röst.
// 'Amelie',    //    fr_CA    # Bonjour, je m’appelle Amelie. Je suis une voix canadienne.
// 'Anna',      //    de_DE    # Hallo, ich heiße Anna und ich bin eine deutsche Stimme.
// 'Ava',       //    en_US  
// 'Bad News',  //    en_US    # The light you see at the end of the tunnel is the headlamp of a fast approaching train.
// 'Bahh',      //    en_US    # Do not pull the wool over my eyes.
// 'Bells',     //    en_US    # Time flies when you are having fun.
// 'Boing',     //    en_US    # Spring has sprung, fall has fell, winter's here and it's colder than usual.
// 'Bruce',     //    en_US    # I sure like being inside this fancy computer
// 'Bubbles',   //    en_US    # Pull the plug! I'm drowning!
// 'Carmit',    //    he_IL    # שלום. קוראים לי כרמית, ואני קול בשפה העברית.
// 'Cellos',    //    en_US    # Doo da doo da dum dee dee doodly doo dum dum dum doo da doo da doo da doo da doo da doo da doo
// 'Damayanti', //    id_ID    # Halo, nama saya Damayanti. Saya berbahasa Indonesia.
// 'Daniel',    //    en_GB    # Hello, my name is Daniel. I am a British-English voice.
// 'Deranged',  //    en_US    # I need to go on a really long vacation.
// 'Diego',     //    es_AR    # Hola, me llamo Diego y soy una voz española.
// 'Ellen',     //    nl_BE    # Hallo, mijn naam is Ellen. Ik ben een Belgische stem.
// 'Fiona',     //    en-scotland # Hello, my name is Fiona. I am a Scottish-English voice.
// 'Fred',      //    en_US    # I sure like being inside this fancy computer
// 'Good News', //    en_US    # Congratulations you just won the sweepstakes and you don't have to pay income tax again.
// 'Hysterical',//    en_US    # Please stop tickling me!
// 'Ioana',     //    ro_RO    # Bună, mă cheamă Ioana . Sunt o voce românească.
// 'Joana',     //    pt_PT    # Olá, chamo-me Joana e dou voz ao português falado em Portugal.
// 'Junior',    //    en_US    # My favorite food is pizza.
// 'Kanya',     //    th_TH    # สวัสดีค่ะ ดิฉันชื่อKanya
// 'Karen',     //    en_AU    # Hello, my name is Karen. I am an Australian-English voice.
// 'Kate',      //    en_GB 
// 'Kathy',     //    en_US    # Isn't it nice to have a computer that will talk to you?
// 'Kyoko',     //    ja_JP    # こんにちは、私の名前はKyokoです。日本語の音声をお届けします。
// 'Laura',     //    sk_SK    # Ahoj. Volám sa Laura . Som hlas v slovenskom jazyku.
// 'Lee',       //    en_AU
// 'Lekha',     //    hi_IN    # नमस्कार, मेरा नाम लेखा है.Lekha[[FEMALE_NAME]]मै हिंदी मे बोलने वाली आवाज़ हूँ.
// 'Luciana',   //    pt_BR    # Olá, o meu nome é Luciana e a minha voz corresponde ao português que é falado no Brasil
// 'Mariska',   //    hu_HU    # Üdvözlöm! Mariska vagyok. Én vagyok a magyar hang.
// 'Mei-Jia',   //    zh_TW    # 您好，我叫美佳。我說國語。
// 'Melina',    //    el_GR    # Γεια σας, ονομάζομαι Melina. Είμαι μια ελληνική φωνή.
// 'Milena',    //    ru_RU    # Здравствуйте, меня зовут Milena. Я – русский голос системы.
// 'Moira',     //    en_IE    # Hello, my name is Moira. I am an Irish-English voice.
// 'Monica',    //    es_ES    # Hola, me llamo Monica y soy una voz española.
// 'Nora',      //    nb_NO    # Hei, jeg heter Nora. Jeg er en norsk stemme.
// 'Oliver',    //    en_GB 
// 'Paulina',   //    es_MX    # Hola, me llamo Paulina y soy una voz mexicana.
// 'Pipe Organ',//    en_US    # We must rejoice in this morbid voice.
// 'Princess',  //    en_US    # When I grow up I'm going to be a scientist.
// 'Ralph',     //    en_US    # The sum of the squares of the legs of a right triangle is equal to the square of the hypotenuse.
// 'Samantha',  //    en_US    # Hello, my name is Samantha. I am an American-English voice.
// 'Sara',      //    da_DK    # Hej, jeg hedder Sara. Jeg er en dansk stemme.
// 'Satu',      //    fi_FI    # Hei, minun nimeni on Satu. Olen suomalainen ääni.
// 'Serena',    //    en_GB 
// 'Sin-ji',    //    zh_HK    # 您好，我叫 Sin-ji。我講廣東話。
// 'Susan',     //    en_US  
// 'Tarik',     //    ar_SA    # مرحبًا اسمي Tarik. أنا عربي من السعودية.
// 'Tessa',     //    en_ZA    # Hello, my name is Tessa. I am a South African-English voice.
// 'Thomas',    //    fr_FR    # Bonjour, je m’appelle Thomas. Je suis une voix française.
// 'Ting-Ting', //    zh_CN    # 您好，我叫Ting-Ting。我讲中文普通话。
// 'Tom',       //    en_US  
// 'Trinoids',  //    en_US    # We cannot communicate with these carbon units.
// 'Veena',     //    en_IN    # Hello, my name is Veena. I am an Indian-English voice.
// 'Vicki',     //    en_US    # Isn't it nice to have a computer that will talk to you?
// 'Victoria',  //    en_US    # Isn't it nice to have a computer that will talk to you?
// 'Whisper',   //    en_US    # Pssssst, hey you, Yeah you, Who do ya think I'm talking to, the mouse?
// 'Xander',    //    nl_NL    # Hallo, mijn naam is Xander. Ik ben een Nederlandse stem.
// 'Yelda',     //    tr_TR    # Merhaba, benim adım Yelda. Ben Türkçe bir sesim.
// 'Yuna',      //    ko_KR    # 안녕하세요. 제 이름은 Yuna입니다. 저는 한국어 음성입니다.
// 'Zarvox',    //    en_US    # That looks like a peaceful planet.
// 'Zosia',     //    pl_PL    # Witaj. Mam na imię Zosia, jestem głosem kobiecym dla języka polskiego.
// 'Zuzana');   //    cs_CZ    # Dobrý den, jmenuji se Zuzana. Jsem český hlas.

$me = chop(`whoami`);
$avidirs = scandir("/Users/$me/Library/Application Support/Firestorm");
$fsfiles = array('browser_profile','cef_cookies','data','logs','user_settings','.','..','.DS_Store');
$avis = array();
foreach ($avidirs as $avidir) {
   if((! in_array($avidir,$fsfiles)) && (is_file("/Users/$me/Library/Application Support/Firestorm/$avidir/chat.txt"))) {
      $avis[$avidir] = filemtime("/Users/$me/Library/Application Support/Firestorm/$avidir/chat.txt");
   }
}
if(count($avis)==0) { echo "Cannot determine avatar name, exiting."; exit(0); }
arsort($avis);
$avi = array_keys($avis)[0];

$handle = popen("/usr/bin/tail -2f '/Users/$me/Library/Application Support/Firestorm/$avi/chat.txt' 2>&1", 'r');
$users = array();
$n=0;
echo "Chatter script running, click the Cancel button to exit\n";
while(1) {
   $line = fgets($handle);
   if(! preg_match('/\[\d+\//',$line)) { continue; } // Don't speak URLs
   if(preg_match('/http(s)?\:\/\//',$line)) { continue; } // Don't speak URLs
   if(preg_match('/(Now playing|is offline|is online|AntiSpam\: Blocked)/',$line)) { continue; }  // Don't speak song announcements
   if(preg_match('/(s offline.)/',$line)) { continue; }
   $user = trim(preg_replace('/^.*\]\s+([^\:]+)\:.*$/',"$1",$line));
   $line = preg_replace('/[\'\"\`\|\[\]]/','',$line);     // Filter characters not supported by 'say' or would escape to shell
   if($n==count($voices)) { $n=0; } // If all voices assigned, round-robin back to the 1st voice
   $phrase = preg_replace('/^[^\:]+\:[^\:]+\:[^\:]+\:(.*)$/',"$1",strtolower($line));
   $phrase = preg_replace('/^(\s+)?\/me/',str_replace('_',' ',$user),$phrase);
   $phrase = preg_replace('/[\r\n]+/','',$phrase);
   $phrase = preg_replace('/^(.*)secondlife\:\/\/\/[^\ ]+\s(.*)$/',"$1 object link $2",$phrase); // ??
   $phrase = preg_replace('/[^a-z0-9\ \-\:\<\&\;()\❤]+/','',$phrase); // ??
   $phrase = str_replace(';',',',$phrase);
   $phrase = str_replace('&',' and ',$phrase);
   $phrase = str_replace('°͜°',' happy face ',$phrase);
   $phrase = str_replace('<3',' love ',$phrase);
   $phrase = str_replace('❤',' love ',$phrase);
   $phrase = preg_replace('/\:\)/',' smiley face ',$phrase);
   $phrase = preg_replace('/^(\s+)?ty/',' thank you ',$phrase);
   $phrase = preg_replace('/^(.*)([^\w]+)?ty[^\w]?/',"$1 thank you $2",$phrase);
   $phrase = preg_replace('/^([\w\s]+)?lol[^\w]?/',"$1 laugh out loud $2",$phrase);
   $phrase = str_replace('brb',' be right back ',$phrase);
   $phrase = str_replace('rofl',' rolling on the floor laughing ',$phrase);
   $phrase = str_replace('lmao',' laughing my ass off ',$phrase);
   $phrase = str_replace('gtsy',' good to see you ',$phrase);
   $phrase = preg_replace('/^(.*) wb (.*)?$/',"$1 welcome back $2 ",$phrase);
   //$phrase = preg_replace('/^gtsy(.*)?$/',"good to see you $1 ",$phrase);
   
   $phrase = str_replace('is online',"$user is online",$phrase);
   $phrase = str_replace('is offline',"$user is offline",$phrase);
   if(! isset($users[$user])) { $users[$user] = $n; $n++; } // If it's a new user, assign them a new voice
   $voice = $voices[$users[$user]];
   $cmd = "say -v '$voice' '$phrase'";
   // echo "$cmd\n"; // For debugging
   `$cmd`; // Speak the phrase
}
?>