<?php

// Chatter v.1.5 - Oct 3, 2023
// by Cuga Rajal
//
// Run this script to speak the local chat, using built-in text-to-speech in macOS.
// More information at https://github.com/cuga-rajal/chat_speak
// Before using please check system requirements at https://github.com/cuga-rajal/chat_speak
//
// Different macOS versions contain different voice names. Please check the list of voices
// below and update that list if necessary to match your system. 
// The list below is from a US-English Ventura system (macOS 13).


$voices = array(
'Alex',
'Allison (Enhanced)',
'Ava (Enhanced)',
'Evan (Enhanced)',
'Joelle (Enhanced)',
'Noelle (Enhanced)',
"Samantha (Enhanced)",
"Susan (Enhanced)",
"Tom (Enhanced)",
"Zoe (Enhanced)",
"Karen (Enhanced)",
"Lee (Enhanced)",
"Matilda (Enhanced)",
"Moira (Enhanced)",
"Daniel (Enhanced)",
"Jamie (Enhanced)",
"Oliver (Enhanced)"
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
   //if(! preg_match('/\[\d+\//',$line)) { continue; } // Don't speak URLs
   if(preg_match('/(Now playing|is offline|is online|AntiSpam\: Blocked)/',$line)) { continue; }  // Don't speak song announcements
   if(preg_match('/(s offline.)/',$line)) { continue; }
   $user = trim(preg_replace('/^.*\]\s+([^\:]+)\:.*$/',"$1",$line));
   $line = trim(preg_replace('/^.*\]\s+[^\:]+\:(.*)$/',"$1",$line));
   $line = preg_replace('/[\'\"\`\|\[\]]/','',$line);     // Filter characters not supported by 'say' or would escape to shell
   $phrase = preg_replace('/^[^\:]+\:[^\:]+\:[^\:]+\:(.*)$/',"$1",strtolower($line));
   $phrase = preg_replace('/^(\s+)?\/me/',str_replace('_',' ',$user),$phrase);
   $phrase = preg_replace('/[\r\n]+/','',$phrase);   
   $phrase = preg_replace('/http(s)?\:\/\/[^\s]+/', '',$line); // Don't speak URLs
   $phrase = preg_replace('/[^a-zA-Z0-9\ \-\:\<\&\;()\❤]+/','',$phrase); // ??
   $phrase = str_replace(';',',',$phrase);
   $phrase = str_replace('&',' and ',$phrase);
   $phrase = str_replace('°͜°',' happy face ',$phrase);
   $phrase = str_replace('<3',' love ',$phrase);
   $phrase = str_replace('❤',' love ',$phrase);
   $phrase = preg_replace('/^\:\)/',' smiley face ',$phrase);
   $phrase = preg_replace('/ \:\)/',' smiley face ',$phrase);
   $phrase = preg_replace('/ ty$/u',' thank you',$phrase);
   $phrase = preg_replace('/^ty/u',' thank you',$phrase);
   $phrase = preg_replace('/ ty[\s\,\.\!]+/u',' thank you',$phrase);
   $phrase = preg_replace('/ lol([^\w]?)/u'," laugh out loud $2",$phrase);
   $phrase = preg_replace('/^lol([^\w]?)/u'," laugh out loud $2",$phrase);
   $phrase = preg_replace('/brb/u',' be right back ',$phrase);
   $phrase = preg_replace('/rofl/u',' rolling on the floor laughing ',$phrase);
   $phrase = preg_replace('/lmao/u',' laughing my ass off ',$phrase);
   $phrase = preg_replace('/gtsy/u',' good to see you ',$phrase);
   $phrase = preg_replace('/ wb/u', ' welcome back/',$phrase);
   $phrase = preg_replace('/^wb/u', ' welcome back/',$phrase);
   
   $phrase = str_replace('is online',"$user is online",$phrase);
   $phrase = str_replace('is offline',"$user is offline",$phrase);
   if(! isset($users[$user])) { $users[$user] = $n; $n++; if($n==count($voices)) { $n=0; } } // If it's a new user, assign them a new voice
   $voice = $voices[$users[$user]];
   $cmd = "say -v '$voice' '$phrase'";
   echo "$cmd\n"; // For debugging
   `$cmd`; // Speak the phrase
}
?>