<?php

// Chatter v.1.7 - Dec 17, 2024
// by Cuga Rajal
//
// Use this script to speak the local chat in macOS Firestorm, using macOS built-in text-to-speech.
// More information at https://github.com/cuga-rajal/chat_speak
// Before using please check system requirements at https://github.com/cuga-rajal/chat_speak
//
// Before you run the script you will need to check your system for installed voices and install
// additional ones if necessary. 
//    System Settings -> Accessibility -> Spoken Content -> System Voice -> Manage Voices (or "?" circle)
//
// If necessary, edit the $voices section below to match the list of voices installed on your system.
// The list below is a mix of English-speaking voices available on Monterey (13.x) and later systems.
//
// You will also need to configure your viewer to "Save nearby chat transcript" in:
//    Preferences -> Privacy -> Log & Transcripts
// 
// Once configured, you will need to log into a virtual world before running the script. When the
// script is first started, it will check the last-modified timestamps of chatlogs from all avatar
// accounts and will use the chatlog with most recent last-modified, which generally means the most 
// recent avatar login at the time the script starts up.
//
// The script will assign a unique voice to each speaking avatar or object. Once the number of
// voices assigned reaches the maximum available, additional voices will start over at the beginning of
// the voices list. Voices are assigned in the order they appear in the array.
//
// Version 1.7 includes some code cleanup and better filtering of long technical phrases such as URLs and
// vectors.
//

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
   $phrase = fgets($handle);
   if(preg_match('/(Now playing|is offline|is online|AntiSpam\: Blocked)/',$phrase)) { continue; }  // Don't speak song announcements
   if(preg_match('/^.*\]\s+[^\:]+\:.*$/',$phrase)) {
      $user = urldecode(str_replace(' ','',preg_replace('/^.*\]\s+([^\:]+)\:.*$/',"$1",$phrase)));
   } else {
      $user = "unknown";
   }
   echo "user $user\n"; // For debugging
   $phrase = trim(preg_replace('/^\[.*\]\s+(.*)$/',"$1",$phrase)); // Filter out the beginning time/datestamp
   $phrase = trim(preg_replace('/^.*\:\s+(.*)$/',"$1",$phrase));  // Filter out the speaker's name
   $phrase = strtolower($phrase); // lower case improves generated speech
   $phrase = preg_replace('/[\r\n]+/','',$phrase); // remove newlines
   $phrase = preg_replace('/\<(\/)?nolink\>/','',$phrase);
   $phrase = preg_replace('/http(s)?\:\/\/[^\s]+/', 'URL',$phrase); // Don't speak URLs
   $phrase = preg_replace('/hop\:\/\/[^\s]+/', 'hop URL',$phrase); // Don't speak URLs
   $phrase = preg_replace('/\<[^\>]+\>/', 'vector',$phrase); // Don't speak vectors
   $phrase = preg_replace('/[^a-zA-Z0-9\ \-\:\<\>\&\;\?\.()\❤]+/','',$phrase); // Filter characters not supported by 'say' or would escape to shell

   // Translations to improve spoken content
   $phrase = preg_replace('/^(\s+)?\/me/',str_replace('_',' ',$user),$phrase);
   $phrase = str_replace(';',',',$phrase);
   $phrase = str_replace(' & ',' and ',$phrase);
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
   
   if(! isset($users[$user])) { $users[$user] = $n; $n++; if($n==count($voices)) { $n=0; } } // If it's a new user, assign them a new voice
   $voice = $voices[$users[$user]];
   $cmd = "say -v '$voice' '$phrase'";
   echo "$cmd\n"; // For debugging
   `$cmd`; // Speak the phrase
}
?>