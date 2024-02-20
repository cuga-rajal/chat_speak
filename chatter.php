<?php

// Chatter v.1.6 - Feb 20, 2024
// by Cuga Rajal
//
// Use this script to speak the local chat in Firestorm, using built-in text-to-speech in macOS.
// More information at https://github.com/cuga-rajal/chat_speak
// Before using please check system requirements at https://github.com/cuga-rajal/chat_speak
//
// Before you run the script you will need to edit the following section to include a list of
// voice names installed on your system. Manage and install system voices from:
//    System Settings -> Accessibility -> Spoken Content -> System Voice -> Manage Voices
//
// Voices in the list below should be installed on your system and the ones you want to use.
// You can edit this list to be whichever voices you want from those available.
// The list below is from a US-English Sonoma system (macOS 14).


$voices = array(
'Alex',
'Allison (Enhanced)',
'Ava (Enhanced)',
'Evan (Enhanced)',
'Joelle (Enhanced)',
'Nathan (Enhanced)',
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

$handle = popen("/usr/bin/tail -4f '/Users/$me/Library/Application Support/Firestorm/$avi/chat.txt' 2>&1", 'r');
$users = array();
$n=0;
echo "Chatter script running, click the Cancel button to exit\n";
while(1) {
   $line = fgets($handle);
   if(preg_match('/(Now playing|is offline|is online|AntiSpam\: Blocked)/',$line)) { continue; }  // Don't speak song announcements
   if(preg_match('/(s offline.)/',$line)) { continue; }
   if(preg_match('/^.*\]\s+[^\:]+\:.*$/',$line)) {
      $user = urldecode(str_replace(' ','',preg_replace('/^.*\]\s+([^\:]+)\:.*$/',"$1",$line)));
      $line = trim(preg_replace('/^\[.*\]\s+(.*)$/',"$1",$line));
      $line = trim(preg_replace('/^.*\:\s+(.*)$/',"$1",$line));
   } else {
      $user = "unknown";
      $line = trim(preg_replace('/^\[.*\]\s+(.*)$/',"$1",$line));
   }
   echo "user $user\n";
   $line = trim(preg_replace('/^\[.*\]\s+(.*)$/',"$1",$line));
   $line = trim(preg_replace('/^.*\:\s+\:(.*)$/',"$1",$line));
   
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
   $phrase = trim($phrase);
   //if($phrase=="is online.") { $name = trim(str_replace('.','',split('@',$user)[0])); $phrase = "$name is online"; }
   //if($phrase=="is offline.") { $name = trim(str_replace('.','',split('@',$user)[0])); $phrase = "$name is offline"; }
   
   if(! isset($users[$user])) { $users[$user] = $n; $n++; if($n==count($voices)) { $n=0; } } // If it's a new user, assign them a new voice
   $voice = $voices[$users[$user]];
   $cmd = "say -v '$voice' '$phrase'";
   echo "$cmd\n"; // For debugging
   `$cmd`; // Speak the phrase
}
?>