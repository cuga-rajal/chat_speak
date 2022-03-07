<?php

// Chatter v.1.1 - March 7, 2022
// by Cuga Rajal
//
// Run this script at the shell to speak the local chat, using built-in text-to-speech in macOS.
// More information at https://github.com/cuga-rajal/chat_speak
// Before using please check system requirements at https://github.com/cuga-rajal/chat_speak

$voices = array(
'Agnes',
'Alex',
'Allison',
'Ava',
'Bruce',
'Fred',
'Junior',
'Kathy',
'Nicky',
'Princess',
'Ralph',
'Samantha',
'Siri Voice 1',
'Siri Voice 2',
'Siri Voice 3',
'Siri Voice 4',
'Susan',
'Tom',
'Vicki',
'Victoria',
'Karen',
'Lee',
'Rishi',
'Veena',
'Moira',
'Fiona',
'Tessa',
'Daniel',
'Kate',
'Oliver',
'Serena'
);

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